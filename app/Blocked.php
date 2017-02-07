<?php

// Define Namespace
namespace App;

// Deps
use Illuminate\Database\Eloquent\Model;

class Blocked extends Model {

    protected $table = 'blocked';

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
