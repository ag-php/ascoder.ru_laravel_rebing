<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class SuccessType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Success',
        'description' => 'A type of success'
    ];

    public function fields(): array
    {
        return [
            'success' => [
                'type' => Type::boolean()
            ],
        ];
    }
}
