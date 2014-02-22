<?php

namespace FMTAES;

class DbUserEmailsRepository implements UserEmailsRepository {

    protected $user_email;

    public function __construct(\UserEmail $user_email)
    {
        $this->user_email = $user_email;
    }

    public function getAllUserEmails()
    {
        return $this->user_email->get();
    }

    public function getUserEmail($user_id)
    {
        return $this->user_email->where('user_id', '=', $user_id)->get();
    }

}