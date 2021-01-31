<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $categoryId
 * @property string $slug
 * @property string $name
 * @property string $text
 * @property string $image
 * @property string $description
 * @property bool $active
 *
 * @property Category $category
 *
 * @package App\Models
 */
class Post extends Model
{
	protected $table = 'posts';

	protected $casts = [
		'categoryId' => 'int',
		'active' => 'bool'
	];

	protected $fillable = [
		'categoryId',
		'slug',
		'name',
		'text',
		'active',
		'image',
		'description'
	];

	public function category()
	{
		return $this->belongsTo(Category::class, 'categoryId');
	}
}
