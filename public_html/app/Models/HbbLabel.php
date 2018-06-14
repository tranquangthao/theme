<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Jul 2017 09:05:07 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbLabel
 * 
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $update_at
 *
 * @package App\Models
 */
class HbbLabel extends Eloquent
{
	protected $table = 'hbb_label';
	public $timestamps = false;

	protected $dates = [
		'update_at'
	];

	protected $fillable = [
		'update_at'
	];
}
