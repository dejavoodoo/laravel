<?php

class JSSupplier extends Eloquent {

    protected $connection = 'jsdb';
    protected $table = 'Suppliers';
    protected $primaryKey = 'SuppID';
    public $timestamps = false;

    protected $guarded = array();

    public static $rules = array();

/*    public function customer()
    {
        return $this->hasOne('Customer', 'CustID', 'CustID');
    }*/

/*    public function callNote()
    {
        return $this->hasMany('JSJobSuppCall', 'SuppID', 'SuppID');
    }*/
}
