<?php namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\Menu as Menu;
use Request;
use DB;
use Validator;
use Lang;
use Auth;

class MenuController extends Controller {

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

	protected $lang ;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->page['title'] = 'Manager Menu';
		$this->model = new Menu();
		$this->lang = Lang::getLocale();
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getIndex($id = null)
	{
		$data = array();
		$pos = "top";
		$row = $this->model->find($id);
		if($row)
		{
			$data['row'] =  $row;
		} else {
			$data['row'] = $this->getColumnTable('tb_menu'); 
		}
		$data['menus']		= self::menus( $pos ,'all');
		$data['listpage'] = DB::table('tb_pages')->select('pageID', 'title', 'alias')->where('lang','=',$this->lang)->get();
		//print_r($data['pages']);die;
		$data['active'] = $pos;
		return view("layout.admin.Menu.index",$data)->with('page', $this->page);
	}

	function postSaveorder()
	{
		$rules = array(
			'reorder'	=> 'required'
		);
		$v = Validator::make(Request::all(), $rules);
		if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors());
	    }
	    else{
	    	$menus = json_decode(Request::input('reorder'),true);
			$child = array();
			$a=0;
			foreach($menus as $m)
			{
				if(isset($m['children']))
				{
					$b=0;
					foreach($m['children'] as $l)					
					{
						if(isset($l['children']))
						{
							$c=0;
							foreach($l['children'] as $l2)
							{
								$level3[] = $l2['id'];
								DB::table('tb_menu')->where('menu_id','=',$l2['id'])
									->update(array('parent_id'=> $l['id'],'ordering'=>$c));
								$c++;	
							}		
						}
						DB::table('tb_menu')->where('menu_id','=', $l['id'])
							->update(array('parent_id'=> $m['id'],'ordering'=>$b));
						$b++;
					}
				}
				DB::table('tb_menu')->where('menu_id','=', $m['id'])
					->update(array('parent_id'=>'0','ordering'=>$a));
				$a++;
	    	}
	    	return redirect('admin/Menu')->with('message',array('success'=>'Update Menu Successfull'));
		}
	}

	public function getAdd(){
		$data = array();
		$this->page['title'] = 'Manager Menu';
		return view("layout.admin.Menu.add",$data)->with('page', $this->page);
	}

	public function postAdd(){
		$v = Validator::make(Request::all(), Menu::$rules);

	    if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors());
	    }
	    else{
	    	$data = $this->getDataPost('tb_menu');
	    	$id = $this->model->insertGetId($data);
	    	$this->inputLogs('Insert data successful with ID = "'.$id.'"');
	    	return redirect('admin/Menu')->with('message',array('success'=>'Insert data successful with ID = "'.$id.'"'));
	    }
	}

	public function getEdit(){
		if(!Request::input('id') || Request::input('id') == ''){
			return redirect('admin/Menu');
		}
		$id = Request::input('id');
		$data = array();
		$data = Menu::find($id);
		$this->page['title'] = 'Manager Menu';
		return view("layout.admin.Menu.edit",$data)->with('page', $this->page);
	}

	public function postEdit(){
		if(!Request::input('menu_id') || Request::input('menu_id') == ''){
			return redirect('admin/Menu');
		}
		$v = Validator::make(Request::all(), Menu::$rules);
		if ($v->fails())
	    {
	        return redirect()->back()->withErrors($v->errors());
	    }
	    else{
	    	$obj = tb_menu::find(Request::input('menu_id'));
	    	$obj = $this->getDataPostObject('tb_menu',$obj);
	    	$obj->save();
	    	$this->inputLogs('Update data successful with ID = "'.$obj->menu_id.'"');
	    	return redirect('admin/Menu')->with('message',array('success'=>'Update data successful with ID = "'.$obj->menu_id.'"'));
	    }

	}

	public function postDel(){
		$this->model->destroy(Request::input('destroy_id'));
		$this->inputLogs("ID : ".implode(",",Request::input('destroy_id'))."  , Has Been Removed Successfull");
		return redirect('admin/Menu')->with('message',array('success'=>"ID : ".implode(",",Request::input('destroy_id'))."  , Has Been Removed Successfull"));
	}

	protected static function menus( $position ='top',$active = '1')
	{
		$data = array();  
		$menu = self::nestedMenu(0,$position ,$active);		
		foreach ($menu as $row) 
		{
			$child_level = array();
			$p = json_decode($row->access_data,true);
			
			
			if($row->allow_guest == 1)
			{
				$is_allow = 1;
			} else {
				$is_allow = (isset($p[Session::get('gid')]) && $p[Session::get('gid')] ? 1 : 0);
			}
			if($is_allow ==1) 
			{
				
				$menus2 = self::nestedMenu($row->menu_id , $position ,$active );
				if(count($menus2) > 0 )
				{	 
					$level2 = array();							 
					foreach ($menus2 as $row2) 
					{
						$p = json_decode($row2->access_data,true);
						if($row2->allow_guest == 1)
						{
							$is_allow = 1;
						} else {
							$is_allow = (isset($p[Session::get('gid')]) && $p[Session::get('gid')] ? 1 : 0);
						}						
									
						if($is_allow ==1)  
						{						
					
							$menu2 = array(
									'menu_id'		=> $row2->menu_id,
									'module'		=> $row2->module,
									'menu_type'		=> $row2->menu_type,
									'url'			=> $row2->url,
									'menu_name'		=> $row2->menu_name,
									'menu_icons'	=> $row2->menu_icons,
									'childs'		=> array()
								);	
												
							$menus3 = self::nestedMenu($row2->menu_id , $position , $active);
							if(count($menus3) > 0 )
							{
								$child_level_3 = array();
								foreach ($menus3 as $row3) 
								{
									$p = json_decode($row3->access_data,true);
									if($row3->allow_guest == 1)
									{
										$is_allow = 1;
									} else {
										$is_allow = (isset($p[Session::get('gid')]) && $p[Session::get('gid')] ? 1 : 0);
									}										
									if($is_allow ==1)  
									{								
										$menu3 = array(
												'menu_id'		=> $row3->menu_id,
												'module'		=> $row3->module,
												'menu_type'		=> $row3->menu_type,
												'url'			=> $row3->url,												
												'menu_name'		=> $row3->menu_name,
												'menu_icons'	=> $row3->menu_icons,
												'childs'		=> array()
											);	
										$child_level_3[] = $menu3;	
									}					
								}
								$menu2['childs'] = $child_level_3;
							}
							$level2[] = $menu2 ;
						}	
					
					}
					$child_level = $level2;
						
				}
				
				$level = array(
						'menu_id'		=> $row->menu_id,
						'module'		=> $row->module,
						'menu_type'		=> $row->menu_type,
						'url'			=> $row->url,						
						'menu_name'		=> $row->menu_name,
						'menu_icons'	=> $row->menu_icons,
						'childs'		=> $child_level
					);			
				
				$data[] = $level;	
			}	
				
		}	
		//echo '<pre>';print_r($data); echo '</pre>'; exit;
		return $data;
	}

	protected static function nestedMenu($parent=0,$position ='top',$active = '1')
	{
		$lang = Lang::getLocale() == '' ? CNF_LANG : Lang::getLocale();
		$group_sql = " AND tb_menu_access.group_id ='".Auth::user()->group_id."' ";
		$active 	=  ($active =='all' ? "" : "AND active ='1' ");
		$Q = DB::select("
		SELECT 
			tb_menu.*
		FROM tb_menu WHERE parent_id ='". $parent ."' ".$active." AND position ='{$position}' AND lang ='$lang'
		GROUP BY tb_menu.menu_id ORDER BY ordering
		");
		return $Q;
	}

}
