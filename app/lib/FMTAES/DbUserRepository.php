<?php

namespace FMTAES;

use Baum\Node;

class DbUserRepository extends Node implements UserRepository {

    protected $user;
    protected $userCustomer;
    protected $userSupplier;
    protected $userEmail;

    public function __construct(\User $user, \UserCustomer $userCustomer, \UserSupplier $userSupplier, \UserEmail $userEmail)
    {
        $this->user = $user;
        $this->userCustomer = $userCustomer;
        $this->userSupplier = $userSupplier;
        $this->userEmail = $userEmail;
    }

    public function getUsers()
    {
        return $this->user->all();
    }

    public function user()
    {
        return $this->user;
    }

    public function getUserCustomers()
    {
        return $this->userCustomer->all();
    }

    public function getUserSuppliers()
    {
        return $this->userSupplier->all();
    }

    public function dbconnection()
    {
        return $this->user->getConnection();
    }

    public function getUserEmail($user_id)
    {
        return $this->user->find($user_id)->userEmails();
    }


}