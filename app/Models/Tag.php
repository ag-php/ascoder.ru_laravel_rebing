<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tag
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $slug
 * @property string $name
 * @property bool $active
 *
 * @package App\Models
 */
class Tag extends Model
{
	protected $table = 'tags';

	protected $casts = [
		'active' => 'bool'
	];

	protected $fillable = [
		'slug',
		'name',
		'active'
	];
}
