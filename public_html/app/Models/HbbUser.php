<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 08 Aug 2017 04:45:29 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class HbbUser
 * 
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $fullname
 * @property string $avatar
 * @property bool $status
 * @property \Carbon\Carbon $create_at
 * @property \Carbon\Carbon $update_at
 * @property string $remember_token
 *
 * @package App\Models
 */
class HbbUser extends Eloquent
{
	protected $table = 'hbb_user';
	public $timestamps = false;

	protected $casts = [
		'status' => 'bool'
	];

	protected $dates = [
		'create_at',
		'update_at'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'username',
		'email',
		'password',
		'fullname',
		'avatar',
		'status',
		'create_at',
		'update_at',
		'remember_token'
	];
//	validator
	public static $rules = [
        'username'=>'required|unique:hbb_user',
        'email'=>'required|email|unique:hbb_user',

    ];
}
