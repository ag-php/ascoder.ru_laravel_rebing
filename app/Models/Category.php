<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $slug
 * @property string $name
 * @property bool $active
 * 
 * @property Collection|Post[] $posts
 *
 * @package App\Models
 */
class Category extends Model
{
	protected $table = 'categories';

	protected $casts = [
		'active' => 'bool'
	];

	protected $fillable = [
		'slug',
		'name',
		'active'
	];

	public function posts()
	{
		return $this->hasMany(Post::class, 'categoryId');
	}
}
