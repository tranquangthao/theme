<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Jul 2017 09:05:06 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbComment
 * 
 * @property int $id
 * @property int $language_current
 * @property string $content
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $user_id
 *
 * @package App\Models
 */
class HbbComment extends Eloquent
{
	protected $table = 'hbb_comment';

	protected $casts = [
		'language_current' => 'int',
		'status' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'language_current',
		'content',
		'status',
		'user_id'
	];
}
