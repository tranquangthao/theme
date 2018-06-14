<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Jul 2017 09:05:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbUserPermission
 * 
 * @property int $id
 * @property int $user_id
 * @property int $permission_id
 *
 * @package App\Models
 */
class HbbUserPermission extends Eloquent
{
	protected $table = 'hbb_user_permission';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'permission_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'permission_id'
	];
}
