<?php

class Helpers {

    public static function isValidSQLDate($string)
    {
        $array = explode('-', $string);

        $month 	= $array[1];
        $day	= $array[2];
        $year 	= $array[0];

        return checkdate($month, $day, $year);
    }

    public static function isValidDate($date)
    {
        return Validator::make(
/*            [
                ['date' => $date],
                ['date' => 'required'],

                ['date_format:Y-m-d' => $date]
            ]*/
            array('date' => $date),
            array('date' => 'required|date|date_format:Y-m-d')
        );
    }

    public static function prePrintR($object)
    {
        $string = '<pre>';
        $string .= print_r($object, true);
        $string .= '</pre>';
        return $string;
    }

}