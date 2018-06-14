<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 01 Aug 2017 08:40:12 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbSlider
 * 
 * @property int $id
 * @property string $link
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $sort_order
 *
 * @package App\Models
 */
class HbbSlider extends Eloquent
{
	protected $table = 'hbb_slider';

	protected $casts = [
		'status' => 'int',
		'sort_order' => 'int'
	];

	protected $fillable = [
		'link',
		'status',
		'sort_order'
	];
}
