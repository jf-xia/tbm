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

Auth::routes();

//Route::get('/dd', function () { return redirect()->back()->getTargetUrl();});
Route::any('wechat', 'WechatController@server')->name('wechat.server');
Route::any('wechat/users', 'WechatController@users')->name('wechat.users');
Route::any('wechat/materials', 'WechatController@materials')->name('wechat.materials');

Route::get('/', 'BlogController@index')->name('index.index');
Route::get('/help',  function () { return view('intro.index');})->name('intro.index');

Route::get('sort/{sort}', 'BlogController@index')->name('index.sort');
Route::get('sort/{sort}/{tag}', 'BlogController@index')->name('index.tag');
Route::get('sort/{sort}/{tag}/{search}', 'BlogController@index')->name('index.search');
Route::get('/{id}', 'BlogController@userinfo')->name('index.user')->where('id', '[0-9]+');
Route::get('post/{id}', 'BlogController@post')->name('index.post')->where('id', '[0-9]+');

Route::get('habitsajax/{user_id}', 'BlogController@habitsAjax');//->name('resumse.habitsajax');
Route::any('update_info', 'BlogController@update_info')->name('resumse.update_info');
//Route::any('/upload', 'UploadController@serve')->name('upload.serve');

Route::get('test/{id}', 'TaskController@test');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'TaskController@calendar');
    Route::get('/calendar', 'TaskController@calendar')->name('tasks.calendar');
    Route::any('laravel-u-editor-server/server', 'UeditorController@server')->name('ueditor.server');

//    Route::resource('technicalsupports', 'TechnicalsupportController');
    Route::resource('projects', 'ProjectController');

    Route::get('tasks/tagcreateajax/{post}/{name}', 'BlogController@createTagAjax')->name('tasks.tagcreate');
    Route::get('tasks/tagremoveajax/{post}/{name}', 'BlogController@removeTagAjax')->name('tasks.tagdelete');
    Route::post('tasks/tagupdateajax', 'BlogController@updateTagAjax')->name('tasks.tagupdate');

    Route::get('tasktypes/ajaxlist', 'TasktypeController@ajaxlist')->name('tasktypes.ajaxlist');
    Route::get('tasks/tagajax', 'BlogController@tagAjax')->name('tasks.tag');
    Route::get('tasks/projectsajaxlist', 'ProjectController@ajaxlist')->name('projects.ajaxlist');
    Route::get('tasks/project/{id}', 'ProjectController@show')->name('tasks.project');
    Route::get('tasks/usersajaxlist', 'Auth\UsersController@ajaxlist')->name('users.ajaxlist');
    Route::get('tasks/showajax/{id}', 'TaskController@showAjax')->name('tasks.showajax');
    Route::get('tasks/listajax', 'TaskController@listAjax')->name('tasks.listajax');
    Route::get('tasks/updateajax', 'TaskController@updateAjax')->name('tasks.updateajax');
    Route::get('tasks/createajax', 'TaskController@createAjax')->name('tasks.createajax');
    Route::get('tasks/productajax', 'TaskController@productajax');
    Route::get('tasks/share/{id}', 'TaskController@share')->name('tasks.share');

    Route::get('tasks/editmyself', 'Auth\UsersController@editmyself')->name('tasks.editmyself');
    Route::patch('tasks/updatemyself', 'Auth\UsersController@updatemyself')->name('users.updatemyself');
    Route::get('tasks/create/{tasktype_id}', 'TaskController@create')->name('tasks.createByTypeId');

    Route::get('tasks/import/{tasktype_id}', 'TaskController@import')->name('tasks.importByTypeId');
    Route::get('tasks/importExample/{tasktype_id}', 'TaskController@importExample')->name('tasks.importExample');
    Route::post('tasks/upload/importfile', 'TaskController@tasksUpload')->name('tasks.upload');
    Route::get('tasks/upload/checkData', 'TaskController@checkData')->name('tasks.checkimport');
    Route::get('tasks/upload/submitimportdata', 'TaskController@submitImportData')->name('tasks.submitimport');
    Route::get('tasks/deleteimportdata/{id}', 'TaskController@deleteImportData')->name('tasks.deleteimport');

    Route::get('tasks/delete/{id}', 'TaskController@destroy')->name('tasks.destroyById');
    Route::resource('tasks', 'TaskController');

    Route::get('taskgroups/type/{type}', 'TaskgroupController@type')->name('taskgroups.type');
    Route::get('taskgroups/updateajax/{id}/{type}/{comment}', 'TaskgroupController@updateajax')->name('taskgroups.updateajax');
    Route::resource('taskgroups', 'TaskgroupController');

    Route::post('tasks/comments', 'TaskcommentController@create')->name('tasks.createcomment');
    Route::delete('tasks/comments/delete/{id}', 'TaskcommentController@delete')->name('tasks.deletecomment');
    Route::get('tasks/comments/{id}', 'TaskcommentController@show')->name('tasks.showcomment');

    Route::resource('taskstatuses', 'TaskstatusController');
    Route::resource('tasktypes', 'TasktypeController');
    //Route::resource('taskcomments', 'TaskcommentController');
    Route::get('tasktypeEavs/create/{tasktype_id}', 'Tasktype_eavController@create')->name('tasktypeEavs.createByTypeId');
    Route::resource('tasktypeEavs', 'Tasktype_eavController');
//    Route::resource('tasktypeeavvalues', 'Tasktype_eav_valueController');

    Route::get('reports/chart', 'ReportController@chart')->name('reports.chart');
    Route::get('reports/task/{tasktype}', 'ReportController@task')->name('reports.task');
    Route::post('reports/task/{tasktype}', 'ReportController@task');
    Route::resource('reports', 'ReportController');

//    Route::get('users/search/{email}', 'Auth\UsersController@index')->name('users.search');
    Route::resource('users', 'Auth\UsersController');
    Route::resource('role_permission', 'Auth\RolesPermissionsController');
    Route::resource('roles', 'Auth\RolesController');
    Route::resource('permissions', 'Auth\PermissionsController');
//    \Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
//        echo '<pre class="queryLog">'.'SQL: '.$query->sql.'<br>VAR: '.json_encode($query->bindings).',TIME：'.$query->time.'</pre>';
////        echo implode(',',$query->bindings);
//    });
});
