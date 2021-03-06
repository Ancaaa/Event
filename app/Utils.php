<?php

namespace App;

use DateTime;

class Utils {
    public static function dbBefore($start=null, $end=null) {
        $format = "Y-m-d H:i:s";
        $startDateTime = DateTime::createFromFormat($format, $start);

        if ($end === null) {
            $endDateTime = new DateTime();
        }
        else {
            $endDateTime = DateTime::createFromFormat($format, $end);
        }

        return $startDateTime < $endDateTime;
    }

    public static function dbDuration($start=null, $end=null, $format=null) {
        if ($format === null) {
            $format = "Y-m-d H:i:s";
        }

        if ($start === null) {
            return null;
        }

        $startDateTime = DateTime::createFromFormat($format, $start);

        if ($end === null) {
            $endDateTime = new DateTime();
        }
        else {
            $endDateTime = DateTime::createFromFormat($format, $end);
        }

        return Utils::formatDateDiff($startDateTime, $endDateTime);
    }

    public static function formatDateDiff($start, $end=null) {
        if (!($start instanceof DateTime)) {
            $start = new DateTime($start);
        }

        if ($end === null) {
            $end = new DateTime();
        }

        if (!($end instanceof DateTime)) {
            $end = new DateTime($start);
        }

        $interval = $end->diff($start);
        $doPlural = function($nb,$str){return $nb>1?$str.'s':$str;}; // adds plurals

        $format = array();
        if ($interval->y !== 0) {
            $format[] = "%y ".$doPlural($interval->y, "year");
        }
        if ($interval->m !== 0) {
            $format[] = "%m ".$doPlural($interval->m, "month");
        }
        if ($interval->d !== 0) {
            $format[] = "%d ".$doPlural($interval->d, "day");
        }
        if ($interval->h !== 0) {
            $format[] = "%h ".$doPlural($interval->h, "hour");
        }
        if ($interval->i !== 0) {
            $format[] = "%i ".$doPlural($interval->i, "minute");
        }
        if ($interval->s !== 0) {
            if(!count($format)) {
                return "less than a minute ago";
            } else {
                $format[] = "%s ".$doPlural($interval->s, "second");
            }
        }

        // We use the two biggest parts
        if (count($format) > 1) {
            $format = array_shift($format)." and ".array_shift($format);
        } else {
            $format = array_pop($format);
        }

        // Prepend 'since ' or whatever you like
        return $interval->format($format);
    }
}
