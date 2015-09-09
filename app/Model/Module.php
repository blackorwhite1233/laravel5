<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Module extends Model {

	//
	protected $table = 'tb_module';
	protected $primaryKey = 'module_id';
	public $timestamps = false;

	public static function getInfoTable(){
		return [
			'module_id' => [
				"type" => 'text',
				'title' => trans("admin.id"),
				'name'	=>	'module_id',
				'value'	=>	'',
				'search'	=>	'=',
			],
			'module_name' => [
				"type" => 'text',
				'title' => trans("admin.module_name"),
				'name'	=>	'module_name',
				'value'	=>	'',
				'search'	=>	'LIKE',
			],
			'module_db' => [
				"type" => 'text',
				'title' => trans("admin.module_db"),
				'name'	=>	'module_db',
				'value'	=>	'',
				'search'	=>	'=',
			],
			'module_created' => [
				"type" => 'datetime',
				'title' => trans("admin.created"),
				'name'	=>	'module_created',
				'value'	=>	'',
				'search'	=>	'=',
			],
		];
	}

	public static $rules=array(
			"module_name" => "required",
			"module_title" => "required",
			"module_db" => "required",
		);

	public static function getTableList( $db ) 
	{
	 	$t = array(); 
		$dbname = 'Tables_in_'.$db ; 
		foreach(DB::select("SHOW TABLES FROM {$db}") as $table)
        {
		    $t[$table->$dbname] = $table->$dbname;
        }	
		return $t;
	}

}
