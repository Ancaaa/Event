<?php

// Define Namespace
namespace App\Models;

// Deps
use Illuminate\Database\Eloquent\Model;

class Admin extends Model {

    protected $table = 'admins';

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
