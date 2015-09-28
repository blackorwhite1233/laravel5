<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
if (defined('CNF_MULTILANG')) {
    $lang = (Session::get('lang') != "" ? Session::get('lang') : CNF_LANG);
    App::setLocale($lang);
}else{
	App::setLocale('en');
}

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('maps', 'HomeController@map');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth'], function()
{
    // Controllers Within The "App\Http\Controllers\Admin" Namespace

    Route::controllers([
		'dashboard' => 'DashboardController',
		'user' => 'UserController',
		'group' => 'GroupController',
		'module' => 'ModuleController',
		'Menu' => 'MenuController',
	]);
});
