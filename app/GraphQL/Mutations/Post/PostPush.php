<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations\Post;

use App\Models\Post;
use Closure;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;

class PostPush extends Mutation
{
    public function type(): Type
    {
        return GraphQL::type('Post');
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
            'text' => [
                'name' => 'text',
                'type' => Type::nonNull(Type::string())
            ],
            'image' => [
                'name' => 'image',
                'type' => Type::string()
            ],
            'description' => [
                'name' => 'description',
                'type' => Type::nonNull(Type::string())
            ],
            'active' => [
                'name' => 'active',
                'type' => Type::nonNull(Type::boolean())
            ],
            'categoryId' => [
                'name' => 'categoryId',
                'type' => Type::nonNull(Type::int())
            ],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $slug = $args['slug'];
        $name = $args['name'];
        $text = $args['text'];
        $image = isset($args['image']) ? $args['image'] : null;
        $description = $args['description'];
        $active = $args['active'];
        $categoryId = $args['categoryId'];

        /** @var Post $post */
        $post = Post::query()
            ->where('slug', $slug)
            ->first();

        if(!$post) {
            $post = new Post();
        }

        $post->slug = $slug;
        $post->name = $name;
        $post->text = $text;
        $post->image = $image;
        $post->description = $description;
        $post->active = $active;
        $post->categoryId = $categoryId;
        $post->save();

        return $post->toArray();
    }
}
