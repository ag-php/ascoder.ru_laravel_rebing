<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Category;

use App\Models\Category;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class CategoryDelete extends Mutation
{
    public function type(): Type
    {
        return GraphQL::type('Success');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id())
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $success = Category::destroy($args['id']);

        return [
            'success' => $success
        ];
    }
}
