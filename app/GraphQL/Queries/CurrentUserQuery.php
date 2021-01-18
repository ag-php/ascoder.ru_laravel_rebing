<?php

namespace App\GraphQL\Queries;

use App\Models\User;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class CurrentUserQuery extends Query
{
    public function type(): Type
    {
        return GraphQL::type('User');
    }

    public function resolve($root, $args, $cts, $info, $select)
    {
        $user = User::query()
            ->where('id', Auth::id())
            ->first();

        if ($user) return $user->toArray();

        return new Error('user invalid');
    }
}
