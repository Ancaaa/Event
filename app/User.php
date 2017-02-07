<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    public function events() {
        return $this->belongsToMany('App\Event', 'attendants');
    }

    public function comments() {
        return $this->hasMany('App\Comment', 'username', 'name');
    }

    public function myevents() {
        return $this->hasMany('App\Event', 'creator_id');
    }

    public function profile() {
        return $this->hasOne('App\Profile');
    }

    public function admin() {
        return $this->hasOne('App\Admin', 'user_id', 'id');
    }

    public function blocked() {
        return $this->hasOne('App\Blocked', 'user_id', 'id');
    }

    public function isAdmin() {
        return $this->admin()->count() > 0;
    }

    public function isBlocked() {
        return $this->blocked()->count() > 0;
    }

    public function latestAttending() {
        return $this->events()->orderBy('startdate', 'desc');
    }

    public function notifications() {
        return $this->hasMany('App\Notification')->orderBy('created_at', 'desc')->take(10);
    }

    public function unreadNotifications() {
        return $this->notifications()->where('seen', '<>', true);
    }

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
