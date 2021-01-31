<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Category;

use App\Models\Category;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CategoryPush extends Mutation
{
    protected $attributes = [
        'name' => 'CategoryPush',
        'description' => 'A mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('Category');
    }

    public function args(): array
    {
        return [
            'slug' => [
                'name' => 'slug',
                'type' => Type::nonNull(Type::string())
            ],
            'name' => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string())
            ],
            'active' => [
                'name' => 'active',
                'type' => Type::nonNull(Type::boolean())
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $slug = $args['slug'];
        $name = $args['name'];
        $active = $args['active'];

        /** @var Category $category */
        $category = Category::query()
            ->where('slug', $slug)
            ->first();

        if(!$category) {
            $category = new Category();
        }

        $category->slug = $slug;
        $category->name = $name;
        $category->active = $active;
        $category->save();

        return $category->toArray();
    }
}
