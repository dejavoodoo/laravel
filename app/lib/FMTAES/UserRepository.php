<?php

namespace FMTAES;

interface UserRepository {
    public function getUsers();
    public function user();
    public function getUserCustomers();
    public function getUserSuppliers();
    public function dbconnection();
    public function getUserEmail($user_id);
}