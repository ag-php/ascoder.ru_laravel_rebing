<?php

declare(strict_types=1);

namespace App\GraphQL\Types\Post;

use App\Models\Post;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PostType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Post',
        'description' => 'A type of post',
        'model' => Post::class
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
            'text' => [
                'type' => Type::string()
            ],
            'image' => [
                'type' => Type::string()
            ],
            'description' => [
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
            'categoryId' => [
                'type' => Type::int()
            ],
            'category' => [
                'type' => GraphQL::type('Category')
            ],
        ];
    }
}
