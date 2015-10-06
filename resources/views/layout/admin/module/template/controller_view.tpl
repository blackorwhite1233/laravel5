<?php namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\{Class} as {Class};
use Request;
use DB;
use Validator;

class {Controller}Controller extends Controller {

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
		$this->page['title'] = '{Title}';
		$this->model = new {Class}();
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$sort = Request::input('sort','DESC');
		$order = Request::input('order','{Key}');
		$rows = Request::input('rows','10');
		list($arr_search,$module) = $this->buildSearch({Class}::getInfoTable());

		$data = array();
		$page = DB::table('{Database}')
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
		return view("layout.admin.{Controller}.index",$data)->with('page', $this->page);
	}

	public function getAdd(){
		$data = array();
		$this->page['title'] = '{Title}';
		return view("layout.admin.{Controller}.add",$data)->with('page', $this->page);
	}

	public function postAdd(){
		$v = Validator::make(Request::all(), {Controller}::$rules);

	    if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors());
	    }
	    else{
	    	$data = $this->getDataPost('{Database}');
	    	$id = $this->model->insertGetId($data);
	    	$this->inputLogs('Insert data successful with ID = "'.$id.'"');
	    	return redirect('admin/{Controller}')->with('message',array('success'=>'Insert data successful with ID = "'.$id.'"'));
	    }
	}

	public function getEdit(){
		if(!Request::input('id') || Request::input('id') == ''){
			return redirect('admin/{Controller}');
		}
		$id = Request::input('id');
		$data = array();
		$data = {Controller}::find($id);
		$this->page['title'] = '{Title}';
		return view("layout.admin.{Controller}.edit",$data)->with('page', $this->page);
	}

	public function postEdit(){
		if(!Request::input('{KEY}') || Request::input('{KEY}') == ''){
			return redirect('admin/{Controller}');
		}
		$v = Validator::make(Request::all(), {Controller}::$rules);
		if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors());
	    }
	    else{
	    	$obj = {Database}::find(Request::input('{KEY}'));
	    	$obj = $this->getDataPostObject('{Database}',$obj);
	    	$obj->save();
	    	$this->inputLogs('Update data successful with ID = "'.$obj->{Key}.'"');
	    	return redirect('admin/{Controller}')->with('message',array('success'=>'Update data successful with ID = "'.$obj->{Key}.'"'));
	    }

	}

	public function getDetail(){
		if(!Request::input('id') || Request::input('id') == ''){
			return redirect('admin/{Controller}');
		}
		$id = Request::input('id');
		$data = array();
		$data = {Controller}::find($id);
		$this->page['title'] = '{Title}';
		return view("layout.admin.{Controller}.detail",$data)->with('page', $this->page);
	}

	public function postDel(){
		$this->model->destroy(Request::input('destroy_id'));
		$this->inputLogs("ID : ".implode(",",Request::input('destroy_id'))."  , Has Been Removed Successfull");
		return redirect('admin/{Controller}')->with('message',array('success'=>"ID : ".implode(",",Request::input('destroy_id'))."  , Has Been Removed Successfull"));
	}

}
