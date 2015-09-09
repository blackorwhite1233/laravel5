<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Menu extends Model {

	//
	protected $table = 'tb_menu';
	protected $primaryKey = 'menu_id';
	public $timestamps = false;

	/*public static function getInfoTable(){
		return [
			'group_id' => [
				"type" => 'text',
				'title' => trans("admin.id"),
				'name'	=>	'group_id',
				'value'	=>	'',
				'search'	=>	'=',
			],
			'name' => [
				"type" => 'text',
				'title' => trans("admin.group_name"),
				'name'	=>	'name',
				'value'	=>	'',
				'search'	=>	'LIKE',
			],
			'description' => [
				"type" => 'text',
				'title' => trans("admin.description"),
				'name'	=>	'description',
				'value'	=>	'',
				'search'	=>	'LIKE',
			],
		];
	}

	public static $rules=array(
			"name" => "required",
		);
	*/
}