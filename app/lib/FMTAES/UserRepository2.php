<?php

namespace FMTAES;

interface UserRepository2 {
    public function getUsers();
    public function getUserCustomers();
    public function getUserSuppliers();
    public function getUserEmails();
    public function getUsersWithCustomers();
    public function mergeUsersWith($users_array, $custs_array, $supps_array, $emails_array);
    public function pushKeyAndValueToArray($users_array, $key_name_to_add, $value_to_add, $user_key);
    public function createArrayGroupedBy($input_array, $column_name_to_group_by);
}