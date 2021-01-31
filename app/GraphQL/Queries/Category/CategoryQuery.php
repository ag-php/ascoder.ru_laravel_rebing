<?php

namespace App\GraphQL\Queries\Category;

use App\Models\Category;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class CategoryQuery extends Query
{
    public function type(): Type
    {
        return GraphQL::type('Category');
    }

    public function args(): array
    {
        return [
            'slug' => [
                'type' => Type::nonNull(Type::string())
            ],
        ];
    }

    public function resolve($root, $args, $cts, $info, $select)
    {
        $slug = $args['slug'];

        $category = Category::query()->where('slug', $slug)->first();

        if (!$category) {
            return new Error('not found');
        }

        return $category->toArray();
    }
}
