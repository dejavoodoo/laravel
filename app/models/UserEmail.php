<?php

class UserEmail extends Eloquent {

    protected $connection = 'fmtdb';

    protected $table = 'user_emails';

    public function getUsersAndEmails()
    {
        return $this->with('User')->get();
    }

    public function users()
    {
        return $this->belongsTo('User', 'user_id', 'id');
    }

}