<?php

namespace App;

use DateTime;
use App\Utils;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    public function category() {
    	return $this->belongsTo('App\Category');
    }

    public function users() {
    	return $this->belongsToMany('App\User', 'attendants');
    }

    public function comments() {
    	return $this->hasMany('App\Comment');
    }

    public function creator() {
    	return $this->belongsTo('App\User');
    }

    public function attending($user_id) {
        $event = $this;
        $found = false;

        foreach ($event->users as $value) {
            if($value->id === $user_id) {
                $found = true;
            }
        }

        return $found;
    }

    public function duration() {
        $start_string = $this->startdate . " " . $this->starttime;
        $end_string = $this->enddate . " " . $this->endtime;

        return Utils::dbDuration($start_string, $end_string);
    }

    public function durationNow() {
        $start_string = $this->startdate . " " . $this->starttime;
        $end_string = $this->enddate . " " . $this->endtime;

        if (Utils::dbBefore($end_string)) {
            return "Ended";
        }

        $prefix = Utils::dbBefore($start_string) ? 'Started ' : 'Starts in ';
        $sufix = Utils::dbBefore($start_string) ? ' ago' : '';

        return $prefix . Utils::dbDuration($start_string) . $sufix;
    }

    public function attendantsNum() {
        return sizeof($this->users);
    }

    public static function activeEvents() {
        return Event::where([
            ['enddate', ">", date('Y-m-d')]
        ])->orWhere(function ($query) {
            $query->where([
                ['enddate', "=", date('Y-m-d')],
                ['endtime', ">", date('H:i:s')]
            ]);
        });
    }

    public function toAPIJson() {
        return array(
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->description,
            "when" => $this->durationNow(),
            "duration" => $this->duration(),
            "attendants" => $this->attendantsNum(),
            "location_lat" => $this->location_lat,
            "location_lng" => $this->location_lng,
            "href" => url('events/' . $this->id),
            "price" => $this->price,
            "currency" => $this->currency,
            "startdate" => $this->startdate,
            "starttime" => $this->starttime,
            "image" => url('/images/events/' . $this->image),
            "location" => $this->location,
            "created_at" => $this->created_at
        );
    }
}
