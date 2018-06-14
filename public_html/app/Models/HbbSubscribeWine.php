<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Jul 2017 09:05:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbSubscribeWine
 * 
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $status
 * @property string $email
 * @property string $name
 * @property int $language_id
 * @property int $product_id
 * @property string $phone
 * @property string $date
 * @property string $message
 *
 * @package App\Models
 */
class HbbSubscribeWine extends Eloquent
{
	protected $table = 'hbb_subscribe_wine';

	protected $casts = [
		'status' => 'bool',
		'language_id' => 'int',
		'product_id' => 'int'
	];

	protected $fillable = [
		'status',
		'email',
		'name',
		'language_id',
		'product_id',
		'phone',
		'date',
		'message'
	];
}
