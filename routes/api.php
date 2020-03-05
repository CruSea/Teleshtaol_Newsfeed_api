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

Route::group(['middleware' => 'api'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});
Route::group(['namespace' => 'Authenticate'], function () {
    Route::post('moblogin', 'MobileAuthenticate@login');
    Route::post('mobsignup', 'MobileAuthenticate@signup');
    Route::post('moblogout', 'MobileAuthenticate@logout');
    Route::post('mobrefresh', 'MobileAuthenticate@refresh');
    Route::get('mobme', 'MobileAuthenticate@me');
});

/* Route::get('users','UsersController@index'); */
/* Route::get('/users',[
    'uses'=>'UsersController@index'
]); */
Route::get('/roles',['uses'=>'UsersController@getrole']);
Route::get('/getusers/{id}',['uses'=>'UsersController@getusers']);
Route::post('/roledetach',['uses'=>'UsersController@roledetach']);
Route::post('/attachrole/{id}',['uses'=>'UsersController@roleattach']);

Route::group(['namespace' => 'Admin'], function () {
    Route::get('/users',['uses'=>'UsersController@index']);
    Route::get('/user/{id}',['uses'=>'UsersController@getUser']);
    Route::get('/editusers',['uses'=>'UsersController@edit']);
    //Route::get('/getusers/{id}',['uses'=>'UsersController@getusers']);
});

Route::group(['namespace' => 'NewsPost'], function () {
   // Route::get('/test',['uses'=> 'NewsPostcontroller@test' ]);
    Route::post('/news_post',['uses'=> 'NewsPostcontroller@create' ]);
    Route::get('/news_posts',['uses'=> 'NewsPostController@show' ]);
    Route::delete('/news_post/{id}',['uses'=> 'NewsPostController@delete' ]);
    Route::post('/newspostupdate',['uses'=> 'NewsPostController@update']);//Update
    
    Route::get('/all',['uses'=> 'NewsListController@all' ]);
    Route::get('/showapproved',['uses'=> 'NewsListController@showapproved' ]);
    Route::get('/showdispproved',['uses'=> 'NewsListController@showDisapproved' ]);
    
    Route::get('/approved',['uses'=>  'TestimonyController@showapproved']);//show approved news for mobile
    Route::get('/disapproved',['uses'=>  'TestimonyController@showDisapproved']);
    
    Route::get('/newspostcomments',['uses'=> 'NewsPostCommentController@index']);
    Route::get('/getcomments/{id}',['uses'=> 'NewsPostCommentController@getCommentsList']);
    Route::post('/newspostcomment',['uses'=> 'NewsPostCommentController@store']);

    Route::post('/news_post_like',['uses'=>  'NewsPostLikeController@like']);
    Route::post('/news_post_unlike',['uses'=>  'NewsPostLikeController@unLike']);
    Route::get('/likedbyme',['uses'=>  'NewsPostLikesController@isLikedByMe']);
});
Route::group(['namespace' => 'Authenticate'], function () {
    Route::post('/mobile_authenticate',['uses'=>'MobileAuthenticate@authenticate']);
    
});
Route::get('/getcurrentuser',['uses'=>'AuthController@getcurrentuser']);

Route::group(['namespace' => 'Dashboard'], function () {
    Route::get('/mobile_user_dashboard/{id}', 'DashboardController@getDailyMobileUserChartData');
    Route::get('/weekly_mobile_user_chart/{id}', 'DashboardController@getWeeklyMobileUserChartData');
    Route::get('/main_dashboard', 'DashboardController@getMainDashboardData');
    Route::get('/posts_dashboard', 'DashboardController@getNewsPostDashboardData');
    Route::get('/stat', 'DashboardController@total');
    
    
});

