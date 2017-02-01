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

    public function latestAttending() {
        return $this->events()->orderBy('startdate', 'desc');
    }

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
