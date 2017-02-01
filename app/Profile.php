<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

    public $timestamps = false;

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function isEmpty() {
        return !$this->firstname && !$this->lastname && !$this->location && !$this->birthdate && !$this->gender && !$this->bio;
    }
}
