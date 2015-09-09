<?php namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\Group as Group;
use Request;
use DB;
use Validator;

class GroupController extends Controller {

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
		$this->page['title'] = trans('admin.manager_group');
		$this->model = new Group();
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$sort = Request::input('sort','DESC');
		$order = Request::input('order','group_id');
		$rows = Request::input('rows','10');
		list($arr_search,$module) = $this->buildSearch(Group::getInfoTable());

		$data = array();
		$page = DB::table('tb_groups')
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
		return view("layout.admin.group.group",$data)->with('page', $this->page);
	}

	public function getAdd(){
		$data = array();
		$this->page['title'] = trans("admin.create_group");
		return view("layout.admin.group.add",$data)->with('page', $this->page);
	}

	public function postAdd(){
		$v = Validator::make(Request::all(), Group::$rules);

	    if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors());
	    }
	    else{
	    	$data = $this->getDataPost('tb_groups');
	    	unset($data['lang']);
	    	$id = $this->model->insertGetId($data);
	    	$this->inputLogs('Insert data successful with ID = "'.$id.'"');
	    	return redirect('admin/group')->with('message',array('success'=>'Insert data successful with ID = "'.$id.'"'));
	    }
	}

	public function getEdit(){
		if(!Request::input('id') || Request::input('id') == ''){
			return redirect('admin/group');
		}
		$id = Request::input('id');
		$data = array();
		$data = Group::find($id);
		$this->page['title'] = trans("admin.edit_group");
		return view("layout.admin.group.edit",$data)->with('page', $this->page);
	}

	public function postEdit(){
		if(!Request::input('group_id') || Request::input('group_id') == ''){
			return redirect('admin/group');
		}
		$v = Validator::make(Request::all(), Group::$rules);
		if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors());
	    }
	    else{
	    	$obj = Group::find(Request::input('group_id'));
	    	$obj = $this->getDataPostObject('tb_groups',$obj);
	    	$obj->save();
	    	$this->inputLogs('Update data successful with ID = "'.$obj->group_id.'"');
	    	return redirect('admin/group')->with('message',array('success'=>'Update data successful with ID = "'.$obj->group_id.'"'));
	    }

	}

	public function postDel(){
		$this->model->destroy(Request::input('destroy_id'));
		$this->inputLogs("ID : ".implode(",",Request::input('destroy_id'))."  , Has Been Removed Successfull");
		return redirect('admin/group')->with('message',array('success'=>"ID : ".implode(",",Request::input('destroy_id'))."  , Has Been Removed Successfull"));
	}

}