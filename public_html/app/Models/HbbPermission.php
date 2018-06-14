<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Jul 2017 09:05:07 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbPermission
 * 
 * @property int $id
 * @property string $permission
 * @property string $link
 * @property string $note
 *
 * @package App\Models
 */
class HbbPermission extends Eloquent
{
	protected $table = 'hbb_permission';
	public $timestamps = false;

	protected $fillable = [
		'permission',
		'link',
		'note'
	];
}
