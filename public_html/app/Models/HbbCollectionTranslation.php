<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Jul 2017 09:05:06 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbCollectionTranslation
 * 
 * @property int $id
 * @property int $language_id
 * @property int $collection_id
 * @property string $collection_name
 * @property string $slug
 *
 * @package App\Models
 */
class HbbCollectionTranslation extends Eloquent
{
	protected $table = 'hbb_collection_translation';
	public $timestamps = false;

	protected $casts = [
		'language_id' => 'int',
		'collection_id' => 'int'
	];

	protected $fillable = [
		'language_id',
		'collection_id',
		'collection_name',
		'slug'
	];
}
