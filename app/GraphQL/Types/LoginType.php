<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class LoginType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Login',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::int()
            ],
            'email' => [
                'type' => Type::string()
            ],
            'access_token' => [
                'type' => Type::string()
            ]
        ];
    }
}
