<?php

// Auth
Route::auth();

// Guest
Route::get('/', 'PagesController@getIndex')->name('home');
Route::get('/home', 'PagesController@getIndex');
Route::get('allevents', 'PagesController@getAllEvents')->name('allevents');
Route::get('categories', 'PagesController@showCategories')->name('category.index');
Route::get('categories/{id}', 'PagesController@showCategory')->name('category.show');
Route::post('events', ['uses' => 'EventController@store', 'as' => 'events.store']);
Route::get('discover-events', 'PagesController@discoverEvents')->name('events.discover');

// Logged-In
Route::group(['middleware' => ['auth', 'blocked'] ], function() {

    // Profiles
    Route::resource('profiles', 'ProfileController');
    Route::get('profile/{id}/edit', 'ProfileController@edit')->name('profile.edit');
    Route::get('profile/{id}/block', 'ProfileController@block')->name('profile.block');
    Route::get('profile/{id}/unblock', 'ProfileController@unblock')->name('profile.unblock');
    Route::get('profile/{id}', 'ProfileController@show')->name('profile.show');

    // Events
    Route::resource('events', 'EventController');
    Route::get('events/{id}', ['uses' => 'EventController@show', 'as' => 'events.show']);
    Route::get('events/{id}/toggle', 'EventController@toggleAttend');
    Route::get('events/{id}/status', 'EventController@isAttending');
    Route::get('events/{id}/warn', 'NotificationsController@warnEvent')->name('events.warn');
    Route::get('events-search', 'EventController@search')->name('events.search');

    // Comments
    Route::post('comments/{event_id}', ['uses' => 'CommentsController@store', 'as' => 'comments.store']);
    Route::get('comments/{event_id}/delete', ['uses' => 'CommentsController@destroy', 'as' => 'comments.delete']);

    // Notification
    Route::get('notifications/', 'NotificationsController@getNotifications')->name('notifications.read');
    Route::get('check-notifications/', 'NotificationsController@updateNotifications')->name('notifications.update');

    // API Routes (redefine the other ones)
    Route::get('api/events/by-area/{area}', 'EventController@apiGetEventInArea');
    Route::get('api/events/search', 'EventController@apiSearchEvents');
    Route::get('api/event/{id}', 'EventController@apiGetEvent');
});

// Admin
Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function() {
    Route::get('/', 'AdminController@index')->name('admin.index');
    Route::get('/categories', 'AdminController@listCategories')->name('admin.list_categories');
    Route::get('/categories/create', 'AdminController@createCategory')->name('admin.create_category');
    Route::post('/categories/create', 'AdminController@createCategoryAction');
    Route::get('/category/{id}', 'AdminController@editCategory')->name('admin.edit_category');
    Route::post('/category/{id}', 'AdminController@editCategoryAction');
    Route::get('/category/{id}/delete', 'AdminController@deleteCategory')->name('admin.delete_category');
    Route::get('/users', 'AdminController@listUsers')->name('admin.list_users');
    Route::get('/users/{id}/block', 'AdminController@blockUser')->name('admin.block_user');
    Route::get('/users/{id}/unblock', 'AdminController@unblockUser')->name('admin.unblock_user');
});