<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class User extends Model {

	//
	protected $table = 'users';

	public function getUser($id){
		return DB::table('users')->find($id);
	}

}
