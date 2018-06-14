<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Jul 2017 09:05:06 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbCollection
 * 
 * @property int $id
 * @property int $parrent_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $status
 * @property string $avatar
 *
 * @package App\Models
 */
class HbbCollection extends Eloquent
{
	protected $table = 'hbb_collection';

	protected $casts = [
		'parrent_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'parrent_id',
		'status',
		'avatar'
	];
}
