<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('shop','ShopController@search');
Route::get('shop/map/{shopid}','ShopController@map');

Route::match(['get', 'post'],'/','UserinfoController@index');
Route::post('sendMsg','UserinfoController@sendMsg');         //发送验证码短信
Route::get('callback','UserinfoController@callBack');       //微信授权回掉地址
// Route::get('setpc','UserinfoController@setSession');       //微信授权回掉地址
Route::any('success',function (){
    return view('success');
});
Route::match(['get','post'],'webztyy','UserinfoController@webztyy');//web端展厅预约
Route::get('web_success',function (){
	return view('web.success');
});

	
Route::get('wechat/awards_list','Wechat\AwardsController@index');
Route::get('wechat/awards_data','Wechat\AwardsController@getData');

Route::get('wechat/life','Wechat\LifeController@index')->name('wechat.life.list');
Route::get('wechat/life/{id}','Wechat\LifeController@show')->name('wechat.life.detail');

Route::get('wechat/instru_index','Wechat\InstructionsController@index');
Route::get('wechat/instru_search','Wechat\InstructionsController@search');
Route::get('wechat/instru_details','Wechat\InstructionsController@details');

//  后台管理路由
Route::any('admin', 'Admin\MemberController@login');


Route::any('api/getAccessToken','WxController@getAccessToken');

//文件上传路由
Route::any('uploadImages','ImgUploadController@uploadImages');
Route::group(['prefix' => 'admin','middleware'=>'admin.login'], function () {
//用户操作路由
    Route::match(['get', 'post'],'pass','Admin\MemberController@modifyPassword');
    Route::get  ('logout','Admin\MemberController@loginOut');
//    Route::get('user/export','Admin\MemberController@export');
    
// 后台欢迎首页路由
    Route::get  ('welcome', 'Admin\WelcomeController@index');
    
    
//店铺管理路由
    Route::post('shop/destroy','Admin\ShopController@destroy');
    Route::post('shop/memberDestroy','Admin\ShopController@memberDestroy');
    Route::get('shop/memberList/{shopid}','Admin\ShopController@memberList');
    Route::get('shop/memberUpdate/{shopid}','Admin\ShopController@memberUpdate');
    Route::put('shop/memberUpdate/{shopid}','Admin\ShopController@memberUpdate');
    Route::post('shop/memberStore','Admin\ShopController@memberStore');
    Route::get('shop/export','Admin\ShopController@export');
    Route::resource('shop','Admin\ShopController');
    
    //品牌荣誉管理路由
    Route::get('awards','Admin\AwardsController@index');    
    Route::post('awards/destroy','Admin\AwardsController@destroy');
    Route::get('awards/listBanner','Admin\AwardsController@listBanner');  
    Route::get('awards/createBanner','Admin\AwardsController@createBanner');
    Route::post('awards/storeBanner','Admin\AwardsController@storeBanner');
    Route::get('awards/showBanner/{id}','Admin\AwardsController@showBanner');
    Route::post('awards/updateBanner/{id}','Admin\AwardsController@updateBanner');
    Route::post('awards/delBanner','Admin\AwardsController@delBanner'); 
    Route::resource('awards','Admin\AwardsController');
    
    //品牌荣誉管理路由
    Route::get('life','Admin\LifeController@index');
    Route::post('life/destroy','Admin\LifeController@destroy');
    Route::get('life/listBanner','Admin\LifeController@listBanner');
    Route::get('life/createBanner','Admin\LifeController@createBanner');
    Route::post('life/storeBanner','Admin\LifeController@storeBanner');
    Route::get('life/showBanner/{id}','Admin\LifeController@showBanner');
    Route::post('life/updateBanner/{id}','Admin\LifeController@updateBanner');
    Route::post('life/delBanner','Admin\LifeController@delBanner');
    Route::resource('life','Admin\LifeController');
    Route::resource('life_type','Admin\LifeTypeController');
    
    //设计师
    Route::resource('designer','Admin\DesignerController');
    //设计师案例
    Route::get('designer/cases','Admin\DesignerController@cases')->name('designer.cases');
    
    //空调使用说明管理路由
    Route::get('instruction','Admin\InstructionController@index');
    Route::post('instruction/destroy','Admin\InstructionController@destroy');
    Route::resource('instruction','Admin\InstructionController');
    
//短信列表路由
    Route::resource('message','Admin\MessageController');

//预约用户留资路由
    Route::get('user/export','Admin\UserController@export');
    Route::get('user/exportToday','Admin\UserController@exportToday');
    Route::get('user/exportHistory','Admin\UserController@exportHistory');
    Route::get('user/today','Admin\UserController@today');
    Route::get('user/history','Admin\UserController@history');
    Route::get('user/history/{user}','Admin\UserController@showHistory');
    Route::get('user/exportHistoryById/{user}','Admin\UserController@exportHistoryById');
    Route::any('user','Admin\UserController@index');
    Route::resource('user','Admin\UserController');       
});