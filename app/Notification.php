<?php

// Define Namespace
namespace App;

// Deps
use Illuminate\Database\Eloquent\Model;

class Notification extends Model {

    protected $table = 'notifications';

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
