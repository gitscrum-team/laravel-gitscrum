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

Route::get('/dashboard', 'Web\UserController@dashboard')->name('user.dashboard')->middleware('user.authenticated', 'product-backlog');
Route::get('/profile/{username}', 'Web\UserController@show')->name('user.profile')->middleware('user.authenticated');

Route::group(['prefix' => 'auth'], function () {
    Route::get('/register', 'Web\Auth\AuthController@register')->name('auth.register');
    Route::get('/login', 'Web\Auth\AuthController@login')->name('auth.login');
    Route::get('/dologin', 'Web\Auth\AuthController@dologin')->name('auth.dologin');
    Route::get('/provider/{provider}', 'Web\Auth\AuthController@redirectToProvider')->name('auth.provider');
    Route::get('/provider/{provider}/callback', 'Web\Auth\AuthController@handleProviderCallback');
    Route::get('/logout', 'Web\Auth\AuthController@logout')->name('auth.logout');
});

Route::group(['prefix' => 'product-backlogs', 'middleware' => ['user.authenticated']], function () {
    Route::get('/list/{mode?}', 'Web\ProductBacklogController@index')->name('product_backlogs.index');
    Route::get('/show/{slug}', 'Web\ProductBacklogController@show')->name('product_backlogs.show');
    Route::get('/create', 'Web\ProductBacklogController@create')->name('product_backlogs.create');
    Route::post('/store', 'Web\ProductBacklogController@store')->name('product_backlogs.store');
    Route::get('/edit/{slug}', 'Web\ProductBacklogController@edit')->name('product_backlogs.edit');
    Route::post('/update/{slug}', 'Web\ProductBacklogController@update')->name('product_backlogs.update');
});

Route::group(['prefix' => 'sprints', 'middleware' => ['user.authenticated', 'sprint.expired', 'global.activities']], function () {
    Route::get('/planning/{slug}/issues', 'Web\IssueController@index')->name('issues.index');
    Route::get('/list/{mode?}/{slug_product_backlog?}', 'Web\SprintController@index')->name('sprints.index');
    Route::get('/show/{slug}', 'Web\SprintController@show')->name('sprints.show');
    Route::get('/create/{slug_product_backlog?}', 'Web\SprintController@create')->name('sprints.create');
    Route::post('/store', 'Web\SprintController@store')->name('sprints.store');
    Route::get('/edit/{slug}', 'Web\SprintController@edit')->name('sprints.edit');
    Route::post('/update/{slug}', 'Web\SprintController@update')->name('sprints.update');
    Route::delete('/destroy', 'Web\SprintController@destroy')->name('sprints.destroy');
    Route::any('/status-update/{slug?}/{status?}', 'Web\SprintController@statusUpdate')->name('sprints.status.update');
});

Route::group(['prefix' => 'user-stories', 'middleware' => ['user.authenticated']], function () {
    Route::get('/list', 'Web\UserStoryController@index')->name('user_stories.index');
    Route::get('/show/{slug}', 'Web\UserStoryController@show')->name('user_stories.show');
    Route::get('/create/{slug_product_backlog?}', 'Web\UserStoryController@create')->name('user_stories.create');
    Route::post('/store', 'Web\UserStoryController@store')->name('user_stories.store');
    Route::get('/edit/{slug}', 'Web\UserStoryController@edit')->name('user_stories.edit');
    Route::delete('/destroy', 'Web\UserStoryController@destroy')->name('user_stories.destroy');
    Route::post('/update/{slug}', 'Web\UserStoryController@update')->name('user_stories.update');
});

Route::group(['prefix' => 'issues', 'middleware' => ['user.authenticated', 'issue']], function () {
    Route::get('/show/{slug}', 'Web\IssueController@show')->name('issues.show');
    Route::get('/create/{scope}/{slug}/{parent_id?}', 'Web\IssueController@create')->name('issues.create');
    Route::post('/store', 'Web\IssueController@store')->name('issues.store');
    Route::get('/edit/{slug}', 'Web\IssueController@edit')->name('issues.edit');
    Route::post('/update/{slug}', 'Web\IssueController@update')->name('issues.update');
    Route::delete('/destroy', 'Web\IssueController@destroy')->name('issues.destroy');
    Route::any('/status-update/{slug?}/{status?}', 'Web\IssueController@statusUpdate')->name('issues.status.update');
});

Route::group(['prefix' => 'user-issue', 'middleware' => ['user.authenticated']], function () {
    Route::get('/list/{username}/{slug_type?}/{mode?}', 'Web\UserIssueController@index')->name('user_issue.index');
    Route::post('/update/{slug}', 'Web\UserIssueController@update')->name('user_issue.update');
});

Route::group(['prefix' => 'issue-types', 'middleware' => ['user.authenticated']], function () {
    Route::get('/sprint/{slug_sprint}/{slug_type?}', 'Web\IssueTypeController@index')->name('issue_types.index');
});

Route::group(['prefix' => 'commits', 'middleware' => ['user.authenticated']], function () {
    Route::get('/show/{sha}', 'Web\CommitController@show')->name('commits.show');
});

Route::group(['prefix' => 'notes', 'middleware' => ['user.authenticated']], function () {
    Route::get('/--------', 'Web\NoteController@store')->name('notes.show');
    Route::post('/store', 'Web\NoteController@store')->name('notes.store');
    Route::get('/update/{slug}', 'Web\NoteController@update')->name('notes.update');
    Route::get('/destroy/{id}', 'Web\NoteController@destroy')->name('notes.destroy');
});

Route::group(['prefix' => 'comments', 'middleware' => ['user.authenticated']], function () {
    Route::get('/--------', 'Web\CommentController@store')->name('comments.show');
    Route::get('/edit/{id}', 'Web\CommentController@edit')->name('comments.edit');
    Route::post('/update/{id}', 'Web\CommentController@update')->name('comments.update');
    Route::post('/store', 'Web\CommentController@store')->name('comments.store');
    Route::get('/destroy/{id}', 'Web\CommentController@destroy')->name('comments.destroy');
});

Route::group(['prefix' => 'labels', 'middleware' => ['user.authenticated']], function () {
    Route::get('/--------', 'Web\LabelController@store')->name('labels.show');
    Route::get('/{model}/{slug_label?}', 'Web\LabelController@index')->name('labels.index');
    Route::post('/store', 'Web\LabelController@store')->name('labels.store');
});

Route::group(['prefix' => 'favorites', 'middleware' => ['user.authenticated']], function () {
    Route::get('/store/{type}/{id}', 'Web\FavoriteController@store')->name('favorites.store');
    Route::get('/destroy/{type}/{id}', 'Web\FavoriteController@destroy')->name('favorites.destroy');
});

Route::group(['prefix' => 'attachments'], function () {
    Route::get('/--------', 'Web\AttachmentController@store')->name('attachments.show');
    Route::post('/store', 'Web\AttachmentController@store')->name('attachments.store');
});

Route::group(['prefix' => 'teams', 'middleware' => ['user.authenticated']], function () {
    Route::get('/members', 'Web\TeamController@index')->name('team.index');
});

Route::group(['prefix' => 'wizard', 'middleware' => ['user.authenticated']], function () {
    Route::get('/install', 'Web\WizardController@install')->name('wizard.install');
    Route::get('/step1', 'Web\WizardController@step1')->name('wizard.step1');
    Route::post('/step2', 'Web\WizardController@step2')->name('wizard.step2');
    Route::get('/step3', 'Web\WizardController@step3')->name('wizard.step3');
});
