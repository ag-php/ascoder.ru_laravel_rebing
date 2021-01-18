<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Models\User;
use Closure;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Hash;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class Login extends Mutation
{
    protected $attributes = [
        'name' => 'login',
        'description' => 'A query'
    ];

    public function type(): Type
    {
        return GraphQL::type('Login');
    }

    public function args(): array
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string())
            ],
            'password' => [
                'name' => 'password',
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $email = $args['email'];
        $password = $args['password'];

        /** @var User $user */
        $user = User::query()
            ->where('email', $email)
            ->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                $token = $this->getAuthToken($user->email, $password);

                return [
                    'id' => $user->id,
                    'email' => $user->email,
                    'access_token' => $token['access_token'],
                ];
            }
        }

        return new Error('Invalid email or password');
    }

    protected function getAuthToken($email, $password)
    {
        $params = [
            'grant_type'    => 'password',
            'client_id'     => config('api.client_id'),
            'client_secret' => config('api.secret_key'),
            'username'      => $email,
            'password'      => $password,
        ];

        $request = app('request');
        $request->request->add($params);
        $proxy = \Illuminate\Http\Request::create('oauth/token', 'POST');
        /** @var \Illuminate\Http\Response $response */
        $response = \Illuminate\Support\Facades\Route::dispatch($proxy);
        return json_decode($response->content(), true);
    }
}
