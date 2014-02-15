<?php

namespace FMTAES;

class DbUserRepository implements UserRepository {

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
        return $this->user->all()->toArray();
    }

    public function getUserCustomers()
    {
        $customers = $this->userCustomer->all()->toArray();
        return $this->createArrayGroupedBy($customers, 'user_id');
    }

    public function getUserSuppliers()
    {
        $suppliers = $this->userSupplier->all()->toArray();
        return $this->createArrayGroupedBy($suppliers, 'user_id');
    }

    public function getUserEmails()
    {
        $emails = $this->userEmail->all()->toArray();
        return $this->createArrayGroupedBy($emails, 'user_id');
    }

    public function getUsersWithCustomers()
    {
        return $this->user->get()->toHierarchy()->toArray();
    }

    public function mergeUsersWith($users_array, $custs_array, $supps_array, $emails_array)
    {
        // Iterate through the user array and merge CustID, SubCustID and SuppID if user_id key values match.
        foreach ($users_array as $user_key => $user_value) {

            // If the array element has children, recursively add some elements until there are no children remaining. If not, continue to the next element on this level
            if (!empty($users_array[$user_key]) && is_array($users_array[$user_key])) {

                // Remove the children element temporarily so we can place some key and value pairs above its position in the array
                if (array_key_exists('children', $users_array[$user_key]))
                    $children_array = array_pop($users_array[$user_key]);

                // Add the customer data
                foreach ($custs_array as $cust_key => $cust_value) {
                    if ($user_key == $cust_key) // user_key is the user ID
                        $users_array = $this->pushKeyAndValueToArray($users_array, 'jsdb_cust_id_array', $cust_value, $user_key);
                }

                // Add the supplier data
                foreach ($supps_array as $supp_key => $supp_value) {
                    if ($user_key == $supp_key) // user_key is the user ID
                        $users_array = $this->pushKeyAndValueToArray($users_array, 'jsdb_supp_id_array', $supp_value, $user_key);
                }

                // Add the user emails
                foreach ($emails_array as $e_key => $e_value) {
                    if ($user_key == $e_key) // user_key is the user ID
                        $users_array = $this->pushKeyAndValueToArray($users_array, 'user_emails_array', $e_value, $user_key);
                }

                // Re-add the children element to the array
                if (!empty($children_array))
                    $users_array[$user_key]['children'] = $children_array;

                // Do some recursion - no children left behind!
                $users_array[$user_key] = $this->mergeUsersWith($users_array[$user_key], $custs_array, $supps_array, $emails_array);
            }
        }
        return $users_array;
    }

    public function pushKeyAndValueToArray($users_array, $key_name_to_add, $value_to_add, $user_key)
    {
        if (!array_key_exists($key_name_to_add, $users_array))
            $users_array[$user_key][$key_name_to_add] = $value_to_add;

        return $users_array;
    }

    /**
     * @param $input_array
     * @param $column_name_to_group_by
     * @return array
     */
    public function createArrayGroupedBy($input_array, $column_name_to_group_by)
    {
        // Group by user id
        $arr = [];
        foreach ($input_array as $k => $v)
            $arr[$v[$column_name_to_group_by]][$k] = $v;

        return $arr;
    }

}