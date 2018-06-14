<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 01 Aug 2017 08:40:12 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbSliderTranslation
 * 
 * @property int $id
 * @property int $language_id
 * @property int $slider_id
 * @property string $content_slider
 *
 * @package App\Models
 */
class HbbSliderTranslation extends Eloquent
{
	protected $table = 'hbb_slider_translation';
	public $timestamps = false;

	protected $casts = [
		'language_id' => 'int',
		'slider_id' => 'int'
	];

	protected $fillable = [
		'language_id',
		'slider_id',
		'content_slider'
	];
}
