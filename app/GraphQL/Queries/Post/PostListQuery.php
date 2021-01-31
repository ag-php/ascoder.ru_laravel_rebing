<?php

namespace App\GraphQL\Queries\Post;

use App\Models\Post;
use GraphQL\Type\Definition\Type;
use Illuminate\Database\Eloquent\Builder;
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
            'category' => [
                'name' => 'category',
                'type' => Type::string()
            ],
        ];
    }

    public function resolve($root, $args, $cts, $info, $select)
    {
        $page = $args['page'];
        $size = $args['size'];

        $category = isset($args['category']) ? $args['category'] : null;


        $posts = Post::query()
            ->with('category')
            ->orderByDesc('created_at');

        if ($category) {
            $posts->whereHas('category', function (Builder $q) use ($category) {
                $q->where('slug', $category);
            });
        }

        return $posts->paginate($size, ['*'], 'page', $page);
    }
}
