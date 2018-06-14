<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Jul 2017 09:05:07 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbNews
 * 
 * @property int $id
 * @property int $menu_news_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $avatar
 * @property int $reviews
 * @property bool $status
 *
 * @package App\Models
 */
class HbbNews extends Eloquent
{
	protected $casts = [
		'menu_news_id' => 'int',
		'reviews' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'menu_news_id',
		'avatar',
		'reviews',
		'status'
	];
}
