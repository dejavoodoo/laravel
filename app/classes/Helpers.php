<?php

class Helpers {

    public static function prePrintR($object)
    {
        return '<pre>' . print_r($object, true) . '</pre>';
    }

    public static function isValidSqlDate($date)
    {
        return Validator::make(
            ['date' => $date],
            ['date' => 'required|date|date_format:Y-m-d']
        );
    }

    /* --------- Graveyard of functions --------- */

/*    public static function isValidSQLDate($string)
    {
        $array = explode('-', $string);

        $month 	= $array[1];
        $day	= $array[2];
        $year 	= $array[0];

        return checkdate($month, $day, $year);
    }*/

}