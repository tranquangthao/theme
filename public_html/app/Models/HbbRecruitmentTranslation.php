<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Jul 2017 09:05:08 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbRecruitmentTranslation
 * 
 * @property int $id
 * @property int $language_id
 * @property int $recruitment_id
 * @property string $recruiment_name
 * @property string $recruiment_content
 * @property string $slug
 *
 * @package App\Models
 */
class HbbRecruitmentTranslation extends Eloquent
{
	protected $table = 'hbb_recruitment_translation';
	public $timestamps = false;

	protected $casts = [
		'language_id' => 'int',
		'recruitment_id' => 'int'
	];

	protected $fillable = [
		'language_id',
		'recruitment_id',
		'recruiment_name',
		'recruiment_content',
		'slug'
	];
}
