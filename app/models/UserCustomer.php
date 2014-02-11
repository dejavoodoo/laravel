<?php

class UserCustomer extends Eloquent {

    protected $connection = 'fmtdb';

    protected $table = 'user_jsdb_customers';

    public function user()
    {
        return $this->belongsTo('User');
    }

}