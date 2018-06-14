<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Jul 2017 09:05:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbWineCenterTranslation
 * 
 * @property int $id
 * @property int $wine_center_id
 * @property int $language_id
 * @property string $wine_center_name
 * @property string $wine_center_content
 * @property string $slug
 *
 * @package App\Models
 */
class HbbWineCenterTranslation extends Eloquent
{
	protected $table = 'hbb_wine_center_translation';
	public $timestamps = false;

	protected $casts = [
		'wine_center_id' => 'int',
		'language_id' => 'int'
	];

	protected $fillable = [
		'wine_center_id',
		'language_id',
		'wine_center_name',
		'wine_center_content',
		'slug'
	];
}
