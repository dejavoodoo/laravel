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

    public static function prePrintR($object)
    {
        echo '<pre>';
        print_r($object);
        echo '</pre>';
    }

}