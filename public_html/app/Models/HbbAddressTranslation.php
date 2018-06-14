<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Jul 2017 09:05:06 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbAddressTranslation
 * 
 * @property int $id
 * @property int $address_id
 * @property int $language_id
 * @property string $address_name
 * @property string $address_content
 *
 * @package App\Models
 */
class HbbAddressTranslation extends Eloquent
{
	protected $table = 'hbb_address_translation';
	public $timestamps = false;

	protected $casts = [
		'address_id' => 'int',
		'language_id' => 'int'
	];

	protected $fillable = [
		'address_id',
		'language_id',
		'address_name',
		'address_content'
	];
}
