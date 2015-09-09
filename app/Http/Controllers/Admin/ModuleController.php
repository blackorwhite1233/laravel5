<?php namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\Module as Module;
use Request;
use DB;
use Validator;

class ModuleController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/
	protected $perpage = 10;

	protected $page = array();

	protected $model ;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->page['title'] = trans('admin.manager_module');
		$this->model = new Module();
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$sort = Request::input('sort','DESC');
		$order = Request::input('order','module_id');
		$rows = Request::input('rows','10');
		list($arr_search,$module) = $this->buildSearch(Module::getInfoTable());

		$data = array();
		$page = DB::table('tb_module')
					->where('module_type','=','new')
					->Where(function($query) use ($arr_search){
				    foreach($arr_search as $s){
				    	$query->where($s[0],$s[1],$s[2]);
				    }
				  })->OrderBy($order , $sort)->paginate($rows);
		$data['module'] = $module;
		$data['items'] = $page;
		$data['url_page'] = $page->appends(['search' => urldecode(Request::input('search')),'sort' => Request::input('sort'),'order' => Request::input('order'),'rows' => Request::input('rows')])->render();
		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['rows'] = $rows;
		$data['total'] = $page->total();
		$data['count'] = $page->count() . $page->currentPage();
		return view("layout.admin.module.index",$data)->with('page', $this->page);
	}

	public function getAdd(){
		$data = array();
		$data['table_list'] = Module::getTableList(env('DB_DATABASE'));
		$this->page['title'] = trans("admin.create_module");
		return view("layout.admin.module.add",$data)->with('page', $this->page);
	}

	public function postAdd(){
		$v = Validator::make(Request::all(), Module::$rules);

	    if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors());
	    }
	    else{
	    	$data = $this->getDataPost('tb_module');
	    	$data['module_type'] = "new";
	    	$key = DB::select("SHOW KEYS FROM ".$data['module_db']." WHERE Key_name = 'PRIMARY'");
	    	$data['module_db_key'] = $key[0]->Column_name;
	    	$id = $this->model->insertGetId($data);
	    	$this->inputLogs('Insert data successful with ID = "'.$id.'"');
	    	return redirect('admin/module')->with('message',array('success'=>'Insert data successful with ID = "'.$id.'"'));
	    }
	}

	public function getEdit(){
		if(!Request::input('id') || Request::input('id') == ''){
			return redirect('admin/module');
		}
		$id = Request::input('id');
		$data_module = Module::find($id);
		$data = array();
		$data['config'] = unserialize($data_module->module_config);
				//print_r($data['config']);die;
		$data['field_list'] = DB::getSchemaBuilder()->getColumnListing($data_module->module_db);
		$data['module_id'] = $id;
		$data['data'] = $data_module;
		$this->page['title'] = trans("admin.edit_module");
		return view("layout.admin.module.edit",$data)->with('page', $this->page);
	}

	public function postEdit(){
		if(!Request::input('module_id') || Request::input('module_id') == ''){
			return redirect('admin/module');
		}
		//print_r(Request::all());die;
    	$obj = Module::find(Request::input('module_id'));
    	$ctr = Request::input('module_name');
    	$config = $this->dataModule($obj->module_db);
    	//print_r($config);die;
    	$obj->module_config = serialize($config);
    	$obj->save();
    	$show = 'public static function getInfoTable(){
					return [
    			';
    	$req = '';
    	//print_r($config['fields']);die;
    	foreach($config['fields'] as $key => $form)
		{
			if($form['require'] =='no')
			{

			} elseif ($form['require'] == 'alpha'){
				$req .= "'".$key."'=>'alpa',
				";
			} elseif ($form['require'] == 'alphanum'){
				$req .= "'".$key."'=>'alpa_num',
				";
			} elseif ($form['require'] == 'alpa_dash'){
				$req .= "'".$key."'=>'alpa_dash',
				";
			} elseif ($form['require'] == 'email'){
				$req .= "'".$key."'=>'email',
				";
			} elseif ($form['require'] == 'number'){
				$req .= "'".$key."'=>'numeric',
				";
			} elseif ($form['require'] == 'date'){
				$req .= "'".$key."'=>'date',
				";
			} else if($form['require'] == 'require'){
				$req .= "'".$key."'=>'required',
				";
			}

			if($form['show'] == 1){
				$show .= "'$key' => [
									'type' => '".$form['type']."',
									'title' => '".$form['title']."',
									'name' => '".$form['name']."',
									'value' => '".$form['value']."',
									'search' => '".$form['search']."',
				";
			}
		}
		$show .= "];}";
		if($req != ""){
			$req = 'public static $rules=array(
				'.$req.'
				)';
		}

    	$codes = array(
			'Controller'		=> $obj->module_name,
			'Class'				=> $obj->module_name,
			//'fields'			=> $f,
			'required'			=> $req,
			'Database'			=> $obj->module_db ,
			'Title'				=> $obj->module_title ,
			//'note'				=> $row->module_note ,
			'Key'				=> $obj->module_db_key,
			'Show'				=> $show,
		);

		$controller = file_get_contents(  base_path().'/resources/views/layout/admin/module/template/controller_view.tpl' );
		//$form = file_get_contents(  app_path().'/views/admin/module/template/form.tpl' );
		$model = file_get_contents(  base_path().'/resources/views/layout/admin/module/template/model_view.tpl' );

		$build_controller 	= self::blend($controller,$codes);
		$build_model 	= self::blend($model,$codes);

		file_put_contents(  base_path()."/app/Http/Controllers/{$ctr}Controller.php" , $build_controller) ;
		file_put_contents(  base_path()."/app/Model/{$ctr}.php" , $build_model) ;
		echo "asdasd";die;
    	$this->inputLogs('Update data successful with ID = "'.$obj->module_id.'"');
    	return redirect('admin/module/edit?id='.$obj->module_id)->with('message',array('success'=>'Update data successful with ID = "'.$obj->module_id.'"'));

	}

	private function dataModule($table){
		$result = array();
		$config = array();
		$data = Request::all();
		$colums = $this->columnTable($table);
		foreach($colums as $colum){
			$result[$colum]['type'] = $data['type'][$colum];
			$result[$colum]['title'] = $data['title'][$colum];
			$result[$colum]['require'] = $data['require'][$colum];
			$result[$colum]['show'] = (isset($data['show'][$colum]) && $data['show'][$colum] == 'on') ? 1 : 0;
			$result[$colum]['form'] = (isset($data['form'][$colum]) && $data['form'][$colum] == 'on') ? 1 : 0;
			$result[$colum]['search'] = $data['search'][$colum];
			$result[$colum]['path'] = $data['path'][$colum];
			$result[$colum]['image'] = (isset($data['image'][$colum]) && $data['image'][$colum] == 'on') ? 1 : 0;
			$result[$colum]['name'] = $colum;
			$result[$colum]['value'] = "";
		}
		$config['fields'] = $result;
		$config['action']['create'] = (isset($data['action']['create']) && $data['action']['create'] == 'on') ? 1 : 0;
		$config['action']['delete'] = (isset($data['action']['delete']) && $data['action']['delete'] == 'on') ? 1 : 0;
		$config['action']['edit'] = (isset($data['action']['edit']) && $data['action']['edit'] == 'on') ? 1 : 0;
		$config['action']['detail'] = (isset($data['action']['detail']) && $data['action']['detail'] == 'on') ? 1 : 0;

		return $config;
	}
	public static function blend($str,$data) {
		$src = $rep = array();
		
		foreach($data as $k=>$v){
			$src[] = "{".$k."}";
			$rep[] = $v;
		}
		
		if(is_array($str)){
			foreach($str as $st ){
				$res[] = trim(str_ireplace($src,$rep,$st));
			}
		} else {
			$res = str_ireplace($src,$rep,$str);
		}
		
		return $res;
		
	}

	private function createFileModule(){

	}

	public function postDel(){
		$this->model->destroy(Request::input('destroy_id'));
		$this->inputLogs("ID : ".implode(",",Request::input('destroy_id'))."  , Has Been Removed Successfull");
		return redirect('admin/group')->with('message',array('success'=>"ID : ".implode(",",Request::input('destroy_id'))."  , Has Been Removed Successfull"));
	}

}
