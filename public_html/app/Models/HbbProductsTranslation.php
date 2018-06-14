<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Jul 2017 09:05:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbProductsTranslation
 * 
 * @property int $id
 * @property int $language_id
 * @property int $product_id
 * @property string $product_name
 * @property string $product_content
 * @property string $slug
 *
 * @package App\Models
 */
class HbbProductsTranslation extends Eloquent
{
	protected $table = 'hbb_products_translation';
	public $timestamps = false;

	protected $casts = [
		'language_id' => 'int',
		'product_id' => 'int'
	];

	protected $fillable = [
		'language_id',
		'product_id',
		'product_name',
		'product_tags',
		'product_content',
		'slug'
	];
}
