<?php

namespace App\GraphQL\Queries\Post;

use App\Models\Post;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class PostListQuery extends Query
{
    public function type(): Type
    {
        return GraphQL::paginate('Post', 'PostList');
    }

    public function args(): array
    {
        return [
            'page' => [
                'name' => 'page',
                'type' => Type::nonNull(Type::int())
            ],
            'size' => [
                'name' => 'size',
                'type' => Type::nonNull(Type::int())
            ],
        ];
    }

    public function resolve($root, $args, $cts, $info, $select)
    {
        $page = $args['page'];
        $size = $args['size'];

        $posts = Post::query()
            ->with('category')
            ->orderByDesc('created_at')
            ->paginate($size, ['*'], 'page', $page);

        return $posts;
    }
}
