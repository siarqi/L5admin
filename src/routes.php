<?php

// Route::middleware('l5adminlogin', 'App\Http\Middleware\L5AdminFilters');

Route::group(['prefix'=>'l5admin'], function(){
	Route::get('/', function() {
		return 1;
	});
	Route::get('/aaa', ['uses'=>'Liuyq\L5admin\L5adminController@aaa']);

	Route::get('/ctb','Liuyq\L5admin\L5schemaController@up');
	Route::get('/dtb','Liuyq\L5admin\L5schemaController@down');
	Route::get('l5adminlogin',array('as'=>'l5admin.login','uses'=>'Liuyq\L5admin\L5adminController@L5AdminLogin'));
	Route::post('l5adminloginpost',array('as'=>'l5admin.loginpost','uses'=>'Liuyq\L5admin\L5adminController@L5AdminLoginPost'));
	Route::get('l5adminloginout',array('as'=>'l5admin.loginout','uses'=>'Liuyq\L5admin\L5adminController@L5AdminLogout'));

	Route::get('l5adminlist',array('as'=>'l5admin.list','uses'=>'Liuyq\L5admin\L5adminController@L5AdminList'));
	Route::get('l5adminadd',array('as'=>'l5admin.add','uses'=>'Liuyq\L5admin\L5adminController@L5AdminAdd'));
	Route::post('l5adminaddpost',array('as'=>'l5admin.addpost','uses'=>'Liuyq\L5admin\L5adminController@L5AdminAddPost'));
	Route::get('l5adminupdate/{id}',array('as'=>'l5admin.update','uses'=>'Liuyq\L5admin\L5adminController@L5AdminUpdate'));
	Route::post('l5adminupdatepost',array('as'=>'l5admin.updatepost','uses'=>'Liuyq\L5admin\L5adminController@L5AdminUpdatePost'));
	Route::post('l5admindel',array('as'=>'l5admin.del','uses'=>'Liuyq\L5admin\L5adminController@L5AdminDel'));

});