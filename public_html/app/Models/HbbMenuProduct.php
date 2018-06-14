<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 11 Jul 2017 09:23:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbMenuProduct
 * 
 * @property int $id
 * @property int $parent_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $status
 *
 * @package App\Models
 */
class HbbMenuProduct extends Eloquent
{
	protected $table = 'hbb_menu_product';

	protected $casts = [
		'parent_id' => 'int',
		'status' => 'bool'
	];

	protected $fillable = [
		'parent_id',
		'status'
	];
}
