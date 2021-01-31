<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Post;

use App\Models\Post;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class PostDelete extends Mutation
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
        $success = Post::destroy($args['id']);

        return [
            'success' => $success
        ];
    }
}
