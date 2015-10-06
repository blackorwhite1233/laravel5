<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Page extends Model {

	//
	protected $table = 'tb_pages';
	protected $primaryKey = 'pageID';
	public $timestamps = false;

	public static function getInfoTable(){
					return [
    			'pageID' => [
									'type' => 'text',
									'title' => 'ID',
									'name' => 'pageID',
									'value' => '',
									'search' => '=',
				],'title' => [
									'type' => 'text',
									'title' => trans('admin.title'),
									'name' => 'title',
									'value' => '',
									'search' => 'LIKE',
				],'created' => [
									'type' => 'date',
									'title' => trans('admin.created'),
									'name' => 'created',
									'value' => '',
									'search' => '=',
				],'updated' => [
									'type' => 'date',
									'title' => trans('admin.updated'),
									'name' => 'updated',
									'value' => '',
									'search' => '=',
				],'status' => [
									'type' => 'radio',
									'title' => trans('admin.status'),
									'name' => 'status',
									'value' => '2',
									'search' => '=',
									"option"=>["0"=>trans('admin.disable'),"1"=>trans('admin.enable')]
				],];}

	public static $rules=array(
				'title'=>'required',
				'status'=>'required',
				'content'=>'required',
				
				);

}