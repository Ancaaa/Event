<?php

// Pages Routes
Route::get('/', 'PagesController@getIndex');
Route::post('/', 'PagesController@postIndex');
Route::get('/home', 'PagesController@getIndex');
Route::get('allevents', 'PagesController@getAllEvents')->name('allevents');

// Profile Routes
Route::resource('profiles', 'ProfileController');
Route::get('profile/{id}/edit', 'ProfileController@edit')->name('profile.edit');
Route::get('profile/{id}/block', 'ProfileController@block')->name('profile.block');
Route::get('profile/{id}/unblock', 'ProfileController@unblock')->name('profile.unblock');
Route::get('profile/{id}', 'ProfileController@show')->name('profile.show');

// Events Routes
Route::resource('events', 'EventController');
Route::post('events/', ['uses' => 'EventController@store', 'as' => 'events.store']);
Route::post('events/{id}', ['uses' => 'EventController@show', 'as' => 'events.show']);
Route::get('events/{id}/toggle', 'EventController@toggleAttend');
Route::get('events/{id}/status', 'EventController@isAttending');
Route::get('events/{id}/warn', 'NotificationsController@warnEvent')->name('events.warn');
Route::get('events-search', 'EventController@search')->name('events.search');

// Categories
Route::get('categories/{id}', 'PagesController@showCategory')->name('category.show');

// Notification Routes
Route::get('notifications/', 'NotificationsController@getNotifications')->name('notifications.read');
Route::get('check-notifications/', 'NotificationsController@updateNotifications')->name('notifications.update');

// Auth Routes
Route::auth();

// Comments
Route::post('comments/{event_id}', ['uses' => 'CommentsController@store', 'as' => 'comments.store']);
Route::get('comments/{event_id}/delete', ['uses' => 'CommentsController@destroy', 'as' => 'comments.delete']);

// API Routes (redefine the other ones)
Route::get('api/events/by-area/{area}', 'EventController@apiGetEventInArea');
Route::get('api/events/search', 'EventController@apiSearchEvents');
Route::get('api/event/{id}', 'EventController@apiGetEvent');
