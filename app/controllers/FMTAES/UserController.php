<?php

namespace FMTAES;

class UserController extends \BaseController {

    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function showUsers()
    {
            $user_customers = $this->users->getUserCustomers();

            $user_suppliers = $this->users->getUserSuppliers();

            $user_emails = $this->users->getUserEmails();

            $users_and_customers = $this->users->getUsersWithCustomers();

            $users_array = $this->users->mergeUsersWith($users_and_customers, $user_customers, $user_suppliers, $user_emails);

            return \Helpers::prePrintR($users_array);
    }

}