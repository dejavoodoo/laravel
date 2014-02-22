<?php

namespace FMTAES;

interface UserEmailsRepository {
    public function getAllUserEmails();
    public function getUserEmail($user_id);
}