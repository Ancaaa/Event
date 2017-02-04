<?php

// Pages Routes
Route::get('/', 'PagesController@getIndex');
Route::post('/', 'PagesController@postIndex');
Route::get('/home', 'PagesController@getIndex');
Route::get('allevents', 'PagesController@getAllEvents')->name('allevents');

// Old Profile Routes
//Route::resource('profile', 'ProfilesController', ['only' => ['show', 'edit', 'update']]);
//Route::get('/{username}', ['as' => 'profile', 'uses' => 'ProfileController@show']);
//Route::get('/profile', 'PagesController@getProfile');
//Route::get('ViewEvent/{id}', ['as' => 'site.single', 'uses' =>'PagesController@getSingle']);

// Profile Routes
Route::resource('profiles', 'ProfileController');
Route::get('profile/{id}/edit', 'ProfileController@edit')->name('profile.edit');
Route::get('profile/{id}', 'ProfileController@show')->name('profile.show');

// Events Routes
Route::resource('events', 'EventController');
Route::post('events/', ['uses' => 'EventController@store', 'as' => 'events.store']);
Route::post('events/{id}', ['uses' => 'EventController@show', 'as' => 'events.show']);
Route::get('events/{id}/toggle', 'EventController@toggleAttend');
Route::get('events/{id}/status', 'EventController@isAttending');
Route::get('events/{id}/warn', 'NotificationsController@warnEvent')->name('events.warn');

// Notification Routes
Route::get('notifications/', 'NotificationsController@getNotifications')->name('notifications.read');
Route::get('check-notifications/', 'NotificationsController@updateNotifications')->name('notifications.update');

// Auth Routes
Route::auth();

// Comments
Route::post('comments/{event_id}', ['uses' => 'CommentsController@store', 'as' => 'comments.store']);
