<?php

namespace App\GraphQL\Queries\Post;

use App\Models\Post;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class PostQuery extends Query
{
    public function type(): Type
    {
        return GraphQL::type('Post');
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

        $post = Post::query()->with('category')->where('slug', $slug)->first();

        if (!$post) {
            return new Error('not found');
        }

        return $post->toArray();
    }
}
