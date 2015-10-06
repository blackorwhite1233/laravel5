<?php namespace App\Http\Controllers;
use Request;
use Redirect;
use Session;
class HomeController extends Controller {

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

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

	public function map(){
		return view('layout.default.index');
	}

	public function language(){
		if(Request::input('lang') == '')
			return  Redirect::back();

		$lang = Request::input('lang');
		Session::put('lang', $lang);
		return  Redirect::back();
	}
}
