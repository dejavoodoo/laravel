<?php

class UserEmail extends Eloquent {

    protected $connection = 'fmtdb';

    protected $table = 'user_emails';

    public function user()
    {
        return $this->belongsTo('User');
    }

}