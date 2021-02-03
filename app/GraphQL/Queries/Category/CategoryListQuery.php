<?php

namespace App\GraphQL\Queries\Category;

use App\Models\Category;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class CategoryListQuery extends Query
{
    public function type(): Type
    {
        return GraphQL::paginate('Category', 'CategoryList');
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

        $categories = Category::query()
            ->withCount('posts')->orderBy('posts_count', 'desc')
            ->paginate($size, ['*'], 'page', $page);

        return $categories;
    }
}
