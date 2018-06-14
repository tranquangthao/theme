<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 12 Jul 2017 09:57:01 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbLabelInSite
 * 
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $update_at
 *
 * @package App\Models
 */
class HbbLabelInSite extends Eloquent
{
	protected $table = 'hbb_label_in_site';
	public $timestamps = false;

	protected $dates = [
		'update_at'
	];

	protected $fillable = [
		'update_at'
	];
}
