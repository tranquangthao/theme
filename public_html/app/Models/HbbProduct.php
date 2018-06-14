<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 21 Aug 2017 09:11:57 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbProduct
 * 
 * @property int $id
 * @property string $avatar
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $collection_id
 * @property bool $status
 * @property float $price
 * @property int $brand_id
 * @property int $country_id
 * @property bool $is_selling
 * @property int $is_featured
 * @property string $alcohol
 *
 * @package App\Models
 */
class HbbProduct extends Eloquent
{
	protected $casts = [
		'collection_id' => 'int',
		'status' => 'bool',
		'price' => 'float',
		'brand_id' => 'int',
		'country_id' => 'int',
		'is_selling' => 'bool',
		'is_featured' => 'int'
	];

	protected $fillable = [
		'avatar',
		'collection_id',
		'status',
		'price',
		'brand_id',
		'country_id',
		'is_selling',
		'is_featured',
		'alcohol'
	];
    //	validator
    public static $rules = [
        'price'=>'required|numeric|between:0,99.99|unique:hbb_products',


    ];
}
