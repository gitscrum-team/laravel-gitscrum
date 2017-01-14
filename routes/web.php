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
Route::get('/', function () {
    return redirect()->route('auth.login');
})->name('home');

Route::get('/dashboard', 'UserController@dashboard')->name('user.dashboard')->middleware('user.authenticated', 'product-backlog');
Route::get('/profile/{username}', 'UserController@show')->name('user.profile')->middleware('user.authenticated');

Route::group(['prefix' => 'auth'], function () {
    Route::get('/register', 'Auth\AuthController@register')->name('auth.register');
    Route::get('/login', 'Auth\AuthController@login')->name('auth.login');
    Route::get('/dologin', 'Auth\AuthController@dologin')->name('auth.dologin');
    Route::get('/provider/{provider}', 'Auth\AuthController@redirectToProvider')->name('auth.provider');
    Route::get('/provider/{provider}/callback', 'Auth\AuthController@handleProviderCallback');
    Route::get('/logout', 'Auth\AuthController@logout')->name('auth.logout');
});

Route::group(['prefix' => 'product-backlogs', 'middleware' => ['user.authenticated']], function () {
    Route::get('/list/{mode?}', 'ProductBacklogController@index')->name('product_backlogs.index');
    Route::get('/show/{slug}', 'ProductBacklogController@show')->name('product_backlogs.show');
    Route::get('/create', 'ProductBacklogController@create')->name('product_backlogs.create');
    Route::post('/store', 'ProductBacklogController@store')->name('product_backlogs.store');
    Route::get('/edit/{slug}', 'ProductBacklogController@edit')->name('product_backlogs.edit');
    Route::post('/update/{slug}', 'ProductBacklogController@update')->name('product_backlogs.update');
});

Route::group(['prefix' => 'sprints', 'middleware' => ['user.authenticated', 'sprint.expired', 'global.activities']], function () {
    Route::get('/planning/{slug}/issues', 'IssueController@index')->name('issues.index');
    Route::get('/list/{mode?}/{slug_product_backlog?}', 'SprintController@index')->name('sprints.index');
    Route::get('/show/{slug}', 'SprintController@show')->name('sprints.show');
    Route::get('/create/{slug_product_backlog?}', 'SprintController@create')->name('sprints.create');
    Route::post('/store', 'SprintController@store')->name('sprints.store');
    Route::get('/edit/{slug}', 'SprintController@edit')->name('sprints.edit');
    Route::post('/update/{slug}', 'SprintController@update')->name('sprints.update');
    Route::delete('/destroy', 'SprintController@destroy')->name('sprints.destroy');
    Route::any('/status-update/{slug?}/{status?}', 'SprintController@statusUpdate')->name('sprints.status.update');
});

Route::group(['prefix' => 'user-stories', 'middleware' => ['user.authenticated']], function () {
    Route::get('/list', 'UserStoryController@index')->name('user_stories.index');
    Route::get('/show/{slug}', 'UserStoryController@show')->name('user_stories.show');
    Route::get('/create/{slug_product_backlog?}', 'UserStoryController@create')->name('user_stories.create');
    Route::post('/store', 'UserStoryController@store')->name('user_stories.store');
    Route::get('/edit/{slug}', 'UserStoryController@edit')->name('user_stories.edit');
    Route::delete('/destroy', 'UserStoryController@destroy')->name('user_stories.destroy');
    Route::post('/update/{slug}', 'UserStoryController@update')->name('user_stories.update');
});

Route::group(['prefix' => 'issues', 'middleware' => ['user.authenticated', 'issue']], function () {
    Route::get('/show/{slug}', 'IssueController@show')->name('issues.show');
    Route::get('/create/{scope}/{slug}/{parent_id?}', 'IssueController@create')->name('issues.create');
    Route::post('/store', 'IssueController@store')->name('issues.store');
    Route::get('/edit/{slug}', 'IssueController@edit')->name('issues.edit');
    Route::post('/update/{slug}', 'IssueController@update')->name('issues.update');
    Route::delete('/destroy', 'IssueController@destroy')->name('issues.destroy');
    Route::any('/status-update/{slug?}/{status?}', 'IssueController@statusUpdate')->name('issues.status.update');
});

Route::group(['prefix' => 'user-issue', 'middleware' => ['user.authenticated']], function () {
    Route::get('/list/{username}/{slug_type?}/{mode?}', 'UserIssueController@index')->name('user_issue.index');
    Route::post('/update/{slug}', 'UserIssueController@update')->name('user_issue.update');
});

Route::group(['prefix' => 'issue-types', 'middleware' => ['user.authenticated']], function () {
    Route::get('/sprint/{slug_sprint}/{slug_type?}', 'IssueTypeController@index')->name('issue_types.index');
});

Route::group(['prefix' => 'commits', 'middleware' => ['user.authenticated']], function () {
    Route::get('/show/{sha}', 'CommitController@show')->name('commits.show');
});

Route::group(['prefix' => 'notes', 'middleware' => ['user.authenticated']], function () {
    Route::get('/--------', 'NoteController@store')->name('notes.show');
    Route::post('/store', 'NoteController@store')->name('notes.store');
    Route::get('/update/{slug}', 'NoteController@update')->name('notes.update');
    Route::get('/destroy/{id}', 'NoteController@destroy')->name('notes.destroy');
});

Route::group(['prefix' => 'comments', 'middleware' => ['user.authenticated']], function () {
    Route::get('/--------', 'CommentController@store')->name('comments.show');
    Route::get('/edit/{id}', 'CommentController@edit')->name('comments.edit');
    Route::post('/update/{id}', 'CommentController@update')->name('comments.update');
    Route::post('/store', 'CommentController@store')->name('comments.store');
    Route::get('/destroy/{id}', 'CommentController@destroy')->name('comments.destroy');
});

Route::group(['prefix' => 'labels', 'middleware' => ['user.authenticated']], function () {
    Route::get('/--------', 'LabelController@store')->name('labels.show');
    Route::get('/{model}/{slug_label?}', 'LabelController@index')->name('labels.index');
    Route::post('/store', 'LabelController@store')->name('labels.store');
});

Route::group(['prefix' => 'favorites', 'middleware' => ['user.authenticated']], function () {
    Route::get('/store/{type}/{id}', 'FavoriteController@store')->name('favorites.store');
    Route::get('/destroy/{type}/{id}', 'FavoriteController@destroy')->name('favorites.destroy');
});

Route::group(['prefix' => 'attachments'], function () {
    Route::get('/--------', 'AttachmentController@store')->name('attachments.show');
    Route::post('/store', 'AttachmentController@store')->name('attachments.store');
});

Route::group(['prefix' => 'teams', 'middleware' => ['user.authenticated']], function () {
    Route::get('/members', 'TeamController@index')->name('team.index');
});

Route::group(['prefix' => 'wizard', 'middleware' => ['user.authenticated']], function () {
    Route::get('/install', 'WizardController@install')->name('wizard.install');
    Route::get('/step1', 'WizardController@step1')->name('wizard.step1');
    Route::post('/step2', 'WizardController@step2')->name('wizard.step2');
    Route::get('/step3', 'WizardController@step3')->name('wizard.step3');
});
