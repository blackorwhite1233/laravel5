<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Request;
use DB;
use Lang;
use Auth;
use Redirect;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	public function __construct()
	{
		$this->checkPermision();
	}

	public function checkPermision(){
		$module = Request::segment(2);
		$action = (Request::segment(3)) ? Request::segment(3) : "index";
		$gid = Auth::user()->group_id;

		$module = DB::table('tb_module')->where("module_name","=",$module)->first();

		$access = DB::table('tb_groups_access')->where("group_id","=",$gid)->where("module_id","=",$module->module_id)->first();

		if($access == ''){
			Auth::logout();
		}
		$access = json_decode($access->access_data);
		$flag = false;
		switch ($action) {
			case 'index':
				if($access->is_view == 1)
					$flag = true;
				break;
			case 'add':
				if($access->is_add == 1)
					$flag = true;
				break;
			case 'edit':
				if($access->is_edit == 1)
					$flag = true;
				break;
			case 'del':
				if($access->is_remove == 1)
					$flag = true;
				break;
			case 'detail':
				if($access->is_detail == 1)
					$flag = true;
				break;
		}
		if(!$flag){
			header('Location: '.Request::segment(0).'/admin/dashboard');die;
		}
	}

	public function buildSearch($arr = array()){
		$param = array();
		if(Request::input('search') !='')
		{
			$type = explode("|",urldecode(Request::input('search')));
			if(count($type) >= 1)
			{
				foreach($type as $t)
				{
					$keys = explode(":",$t);
					if(in_array($keys[0],array_keys($arr))):
						$search = $arr[$keys[0]]['search'] == "LIKE" ? "%".$keys[1]."%" : $keys[1];
						$param[] = array($keys[0], $arr[$keys[0]]['search'], $search);
						$arr[$keys[0]]['value'] = $keys[1];
					endif;
				}
			}
		}
		//print_r($param);die;
		return array($param,$arr) ;
	}

	function postMultisearch()
	{
		$post = $_POST;
		$items ='';
		foreach($post as $item=>$val):
			if($_POST[$item] !='' and $item !='_token' and $item !='md' and $item !='sort' and $item !='order' and $item !='rows'):
				$items .= $item.':'.urldecode(trim($val)).'|';
			endif;
		endforeach;
		$sort 	= (!is_null(Request::input('sort')) ? Request::input('sort') : '');
		$order 	= (!is_null(Request::input('order')) ? Request::input('order') : '');
		$rows 	= (!is_null(Request::input('rows')) ? Request::input('rows') : '');
		$filter = '';
		if($sort!='') $filter .= '&sort='.$sort; 
		if($order!='') $filter .= '&order='.$order; 
		if($rows!='') $filter .= '&rows='.$rows; 

		return redirect('/admin/group/'.'?search='.substr($items,0,strlen($items)-1).$filter);
	}

	function getDataPost($table)
	{
		$arrColumn = self::columnTable($table);
		$arrdata = array();

		foreach($arrColumn as $col)
		{
			$arrdata[$col] = (Request::input($col)) ? Request::input($col) : "";
		}
		$lang = Lang::getLocale();
		$arrdata['lang'] = $lang;
		return $arrdata;
	}

	public static function columnTable( $table )
	{
        $columns = array();
	    foreach(DB::select("SHOW COLUMNS FROM $table") as $column)
        {
           //print_r($column);
		    $columns[] = $column->Field;
        }

        return $columns;
	}

	function inputLogs( $note = NULL)
	{
		$data = array(
			'module'	=> Request::segment(2),
			'task'		=> Request::segment(3),
			'user_id'	=> Auth::user()->id,
			'ipaddress'	=> Request::ip(),
			'note'		=> $note
		);
		 DB::table( 'tb_logs')->insert($data);
	}

	function getDataPostObject($table, $obj){
		$arrColumn = self::columnTable($table);

		foreach($arrColumn as $col)
		{
			$obj->$col = (Request::input($col)) ? Request::input($col) : $obj->$col;
		}
		return $obj;
	}

}
