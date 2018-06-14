<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Jul 2017 09:05:06 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbBrand
 * 
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $status
 *
 * @package App\Models
 */
class HbbBrand extends Eloquent
{
	protected $table = 'hbb_brand';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'status'
	];
}
