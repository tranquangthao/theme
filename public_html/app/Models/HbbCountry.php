<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 08 Aug 2017 04:45:29 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbCountry
 * 
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $status
 *
 * @package App\Models
 */
class HbbCountry extends Eloquent
{
	protected $table = 'hbb_country';

	protected $casts = [
		'status' => 'bool'
	];

	protected $fillable = [
		'status'
	];
}
