<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Jul 2017 09:05:06 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbBrandTranslation
 * 
 * @property int $id
 * @property int $language_id
 * @property int $brand_id
 * @property string $brand_name
 * @property string $slug
 *
 * @package App\Models
 */
class HbbBrandTranslation extends Eloquent
{
	protected $table = 'hbb_brand_translation';
	public $timestamps = false;

	protected $casts = [
		'language_id' => 'int',
		'brand_id' => 'int'
	];

	protected $fillable = [
		'language_id',
		'brand_id',
		'brand_name',
		'slug'
	];
}
