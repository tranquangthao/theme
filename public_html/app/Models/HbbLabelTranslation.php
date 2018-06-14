<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Jul 2017 09:05:07 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbLabelTranslation
 * 
 * @property int $id
 * @property int $language_id
 * @property int $label_id
 * @property string $label_name
 *
 * @package App\Models
 */
class HbbLabelTranslation extends Eloquent
{
	protected $table = 'hbb_label_translation';
	public $timestamps = false;

	protected $casts = [
		'language_id' => 'int',
		'label_id' => 'int'
	];

	protected $fillable = [
		'language_id',
		'label_id',
		'label_name'
	];
}
