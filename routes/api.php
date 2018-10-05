<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test','HomeController@test');

//profile
Route::get('/profile','Auth\RegisterController@profile')->middleware('jwt.auth','cors')
       ->name('user.profile');
Route::post('/update/profile','Auth\RegisterController@updateProfile')
       ->middleware('jwt.auth','cors')
       ->name('update.profile');

//roles
Route::get('/role','RoleController@index')->middleware('cors')->name('user.roles');

//isemployed
Route::get('/checkemployed','EmployController@isEmployed')->middleware('jwt.auth','cors');

//messaging
Route::group(['prefix'=>'msg','middleware'=>['jwt.auth','cors']],function(){
	//send message
	Route::post('/send/{id}','MessageController@send')->name('message.send');
	Route::post('/send/text/{id}','MessageController@sendText')->name('text.send');
	Route::get('/all','MessageController@messages')->name('message.fetch');
	Route::get('/texts/{id}','MessageController@texts')->name('message.fetch');

	//mark as read
	Route::post('/read/{id}','MessageController@markAsRead')->name('message.read');

   
});
//distress
Route::post('/distress','UserController@sendDistressCall')
     ->middleware('jwt.auth');

//notifications

Route::get('/unread/notifications','UserController@getUnreadNotifications')
     ->middleware('cors')
     ->name('unread.notify');
Route::get('/all/notifications','UserController@getUnreadNotifications')
      ->middleware('cors')
      ->name('all.notify');
      //count
Route::get('/noticount','UserController@countNotifications')
      ->middleware('cors')
      ->name('all.count');
Route::post('/notification/read/{id}','UserController@markAsRead')
     ->middleware('cors')
     ->name('read.notify');

Route::get('/notification/{id}/delete','UserController@delete')
     ->middleware('cors')
     ->name('delete.notify');

//user
Route::group(['prefix' =>'user','middleware'=>'cors'], function(){

	Route::get('/myuser/{id}','Auth\LoginController@myUser')->name('my.user');

	//login
	Route::post('/login','Auth\LoginController@userLogin')->name('user.login');
	Route::post('/logout','Auth\LoginController@logout')->middleware('jwt.auth')->name('user.logout');
    //resetpass
    Route::post('/reset/password','Auth\LoginController@resetPassword')->name('reset.password');
	//register
	Route::post('/signup','Auth\RegisterController@userRegister')->name('user.signup');

	//user
	Route::get('/user','Auth\LoginController@user')->middleware('jwt.auth')->name('user.logged');

});


//mama
Route::group(['prefix' => 'mama','middleware' =>['jwt.auth','cors']], function(){

	//list of nanis
	Route::get('/nanis','MamaController@getNanis')->name('list.nanis');
	 //get nani
	Route::get('/nani/{id}','MamaController@getNani')->name('nani');

	//request
	Route::post('/request','MamaController@requestNani')->name('request.nani');
	Route::get('/requests','MamaController@getMyRequests')->name('list.requests');
	Route::post('/abort/{id}','MamaController@abortRequest')->name('abort.request');

	//detail about user
	Route::post('/details/{id}','MamaController@details')->name('details');
  

	//payment
	Route::post('/pay','PaymentController@makePayment')->name('make.payment');
	Route::get('/account','MamaController@myAccount')->name('account');
	Route::post('/deposit','PaymentController@makeDeposit')->name('make.deposit');

	//employ
	Route::post('/employ/{id}','EmployController@employ')->name('employ');
	//fire
	Route::post('/fire','MamaController@fire')->name('fire');

	//rate
	Route::post('/rate','MamaController@rateNanny')->name('rate.nanny');


});

//employment

Route::get('/employment','EmployController@employment')
       ->middleware('jwt.auth','cors')->name('employment');


//nani
Route::group(['prefix' => 'nani','middleware' =>['jwt.auth','cors']], function(){

	Route::get('/mamas','NaniController@getMamas')->name('nani.mamas');
	
	Route::get('/requests','NaniController@getRequests')->name('nani.list.requests');
	Route::post('/confirm/{id}','NaniController@confirmRequest')->name('confirm.request');
	Route::post('/reject/{id}','NaniController@rejectRequest')->name('reject.request');

	//rate
	Route::post('/rate','NaniController@rateMama')->name('rate.mama');
    //quit
	Route::post('/quit','NaniController@quit')->name('nani.quit');

	//employ
	Route::post('/confirm/employ/{id}','NaniController@confirmEmployment');
	Route::post('/reject/employ/{id}','NaniController@rejectEmployment');

	

});




