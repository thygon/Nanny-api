<?php



Route::get('/','Admin\DashboardController@index')->name('admin.home');

//////////////////////Admin//////////////////////////

Route::group(['prefix' => 'admin'], function(){

    Route::get('/login','Admin\LoginController@showLoginForm')->name('admin.login');
	Route::post('/login','Admin\LoginController@login')->name('admin.login');
	Route::post('/logout','Admin\LoginController@logout')->name('admin.logout');

	Route::get('/users',function(){
		return view('users',['users'=>App\User::all()]);
	})->name('users');

	Route::get('/connections',function(){
		return view('connections',['connects'=>App\Employ::with('mama','nani')->get()]);
	})->name('connections');

	Route::get('/notifications',function(){
		return view('notifications',['notifications' => Auth::guard('admin')->user()->notifications]);
	})->name('notifications');
    
    Route::get('/notification/{id}','Admin\DashboardController@notification')->name('notification');
	

	Route::get('/payments',function(){
		return  view('payments',['payments'=>App\Payment::all()]);
	})->name('payments');

	Route::get('/requests',function(){
		return view('requests',['requests'=> App\Friend::with('user','nani')->get()]);
	})->name('requests');
	

	Route::resource('security','SecurityController');

});