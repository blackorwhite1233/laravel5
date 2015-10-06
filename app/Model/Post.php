<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class Post extends Model {

	//
	protected $table = 'post';
	protected $primaryKey = 'post_id';
	public $timestamps = false;

	public static function getInfoTable(){
					return [
    			'post_id' => [
									'type' => 'text',
									'title' => 'ID',
									'name' => 'post_id',
									'value' => '',
									'search' => '=',
				],'post_typecustomer' => [
									'type' => 'select',
									'title' => '',
									'name' => 'post_typecustomer',
									'value' => '',
									'search' => '=',
				],'post_slug' => [
									'type' => 'text',
									'title' => 'Slug',
									'name' => 'post_slug',
									'value' => '',
									'search' => '=',
				],'post_note' => [
									'type' => 'text',
									'title' => 'Note',
									'name' => 'post_note',
									'value' => '',
									'search' => '=',
				],];}

	public static $rules=array(
				'post_id'=>'numeric',
				
				);

}