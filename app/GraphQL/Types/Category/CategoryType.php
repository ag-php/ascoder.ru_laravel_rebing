<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Category;

use App\Models\Category;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CategoryType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Category',
        'description' => 'A type of category',
        'model' => Category::class
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::int()
            ],
            'slug' => [
                'type' => Type::string()
            ],
            'name' => [
                'type' => Type::string()
            ],
            'created_at' => [
                'type' => Type::string()
            ],
            'updated_at' => [
                'type' => Type::string()
            ],
            'active' => [
                'type' => Type::boolean()
            ],

            'posts_count' => [
                'type' => Type::int()
            ],
        ];
    }
}
