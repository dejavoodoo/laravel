<?php

class Job extends Eloquent {

    protected $connection = 'jsdb';
    protected $table = 'Jobs';
    protected $primaryKey = 'JobNo';
    public $timestamps = false;

    protected $guarded = array();

    public static $rules = array();

/*    public function customer()
    {
        return $this->hasOne('Customer', 'CustID', 'CustID');
    }*/
}
