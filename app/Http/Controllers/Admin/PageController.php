<?php namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\Page as Page;
use Request;
use DB;
use Validator;

class PageController extends Controller {

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
		$this->page['title'] = 'Page';
		$this->model = new Page();
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$sort = Request::input('sort','DESC');
		$order = Request::input('order','pageID');
		$rows = Request::input('rows','10');
		list($arr_search,$module) = $this->buildSearch(Page::getInfoTable());

		$data = array();
		$page = DB::table('tb_pages')
					->Where(function($query) use ($arr_search){
				    foreach($arr_search as $s){
				    	$query->where($s[0],$s[1],$s[2]);
				    }
				  })->OrderBy($order , $sort)->paginate($rows);
		$data['module'] = $module;
		$data['items'] = $page;
		$data['url_page'] = $page->render();
		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['rows'] = $rows;
		$data['total'] = $page->total();
		$data['count'] = $page->count() . $page->currentPage();
		return view("layout.admin.Page.index",$data)->with('page', $this->page);
	}

	public function getAdd(){
		$data = array();
		$this->page['title'] = 'Page';
		return view("layout.admin.Page.add",$data)->with('page', $this->page);
	}

	public function postAdd(){
		$v = Validator::make(Request::all(), Page::$rules);

	    if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors());
	    }
	    else{
	    	$data = $this->getDataPost('tb_pages');
	    	$id = $this->model->insertGetId($data);
	    	$this->inputLogs('Insert data successful with ID = "'.$id.'"');
	    	return redirect('admin/Page')->with('message',array('success'=>'Insert data successful with ID = "'.$id.'"'));
	    }
	}

	public function getEdit(){
		if(!Request::input('id') || Request::input('id') == ''){
			return redirect('admin/Page');
		}
		$id = Request::input('id');
		$data = array();
		$data = Page::find($id);
		$this->page['title'] = 'Page';
		return view("layout.admin.Page.edit",$data)->with('page', $this->page);
	}

	public function postEdit(){
		if(!Request::input('pageID') || Request::input('pageID') == ''){
			return redirect('admin/Page');
		}
		$v = Validator::make(Request::all(), Page::$rules);
		if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors());
	    }
	    else{
	    	$obj = tb_pages::find(Request::input('pageID'));
	    	$obj = $this->getDataPostObject('tb_pages',$obj);
	    	$obj->save();
	    	$this->inputLogs('Update data successful with ID = "'.$obj->pageID.'"');
	    	return redirect('admin/Page')->with('message',array('success'=>'Update data successful with ID = "'.$obj->pageID.'"'));
	    }

	}

	public function getDetail(){
		if(!Request::input('id') || Request::input('id') == ''){
			return redirect('admin/Page');
		}
		$id = Request::input('id');
		$data = array();
		$data = Page::find($id);
		$this->page['title'] = 'Page';
		return view("layout.admin.Page.detail",$data)->with('page', $this->page);
	}

	public function postDel(){
		$this->model->destroy(Request::input('destroy_id'));
		$this->inputLogs("ID : ".implode(",",Request::input('destroy_id'))."  , Has Been Removed Successfull");
		return redirect('admin/Page')->with('message',array('success'=>"ID : ".implode(",",Request::input('destroy_id'))."  , Has Been Removed Successfull"));
	}

}
