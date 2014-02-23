<?php

namespace FMTAES;

interface UserEmailsRepository {
    public function getAllUserEmails();
    public function getUserEmail($user_id);
    public function getCustomers();
    public function userEmail();
}