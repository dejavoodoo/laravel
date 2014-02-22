<?php

class JSJobSuppCall extends Eloquent {

    protected $connection = 'jsdb';
    protected $table = 'JobSuppCalls';
    protected $primaryKey = 'JSCID';
    public $timestamps = false;

    protected $guarded = array();

    public static $rules = array();

}