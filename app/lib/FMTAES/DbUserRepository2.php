<?php

namespace FMTAES;

use Baum\Node;

class DbUserRepository2 extends Node implements UserRepository2 {

    protected $user;
    protected $userCustomer;
    protected $userSupplier;
    protected $userEmail;

    public function __construct(\User $user, \UserCustomer $userCustomer, \UserSupplier $userSupplier, \UserEmail $userEmail)
    {
        ini_set('display_errors',1);
        ini_set('display_startup_errors',1);
        error_reporting(-1);
        $this->user = $user;
        $this->userCustomer = $userCustomer;
        $this->userSupplier = $userSupplier;
        $this->userEmail = $userEmail;
    }

    public function getUsers()
    {
/*        $users = $this->user
            ->leftJoin('user_jsdb_customers', 'user_jsdb_customers.user_id', '=', 'users.id')
            ->leftJoin('user_jsdb_suppliers', 'user_jsdb_suppliers.user_id', '=', 'users.id')
            ->get();*/

        $users = $this->user
            ->leftJoin('user_jsdb_customers', function($join)
            {
                $join->on('users.id', '=', 'user_jsdb_customers.user_id')
                    ->whereNotExists('user_jsdb_customers.user_id');
            })
            //->leftJoin('user_jsdb_suppliers', 'user_jsdb_suppliers.user_id', '=', 'users.id')
            ->get()->toArray();
        return $users;
    }

    public function getUserCustomers()
    {
        $customers = $this->userCustomer->all();
        return $customers;
        //return $this->createArrayGroupedBy($customers, 'user_id');
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
        $users = $this->user->get()->toHierarchy()->toArray();
        return $users;
    }

    // Add "is_leaf" to each element of the array if this user ID is a leaf (end of a branch)
    public function addLeafKeys($array)
    {
        foreach($array as $k => $v)
        {
            if(!empty($array[$k]) && is_array($array[$k]))
                $this->addLeafKeys($array[$k]);

            if($k > 0) {
                if($this->user->find($k)->isLeaf())
                    $array[$k]['is_leaf'] = 1;
            }
        }
        return $array;
    }

    public function mergeUsersWith($users_array, $custs_array, $supps_array, $emails_array)
    {
        // Iterate through the user array and merge CustID, SubCustID and SuppID if user_id key values match.
        foreach ($users_array as $user_key => $user_value) {

            // Do some recursion - no children left behind!
            if (!empty($users_array[$user_key]) && is_array($users_array[$user_key])) {
                $users_array[$user_key] = $this->mergeUsersWith($users_array[$user_key], $custs_array, $supps_array, $emails_array);
            }

            // Remove the children element temporarily so we can place some key and value pairs above its position in the array
            $children_array = [];
            if (is_array($users_array[$user_key]) && array_key_exists('children', $users_array[$user_key]))
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


            if (!empty($users_array[$user_key]) && is_array($users_array[$user_key])) {

                if(array_key_exists('email', $users_array[$user_key])) {
                    $email = $users_array[$user_key]['email'];
                    $id = $users_array[$user_key]['id'];
                    echo "$id :: Email sent to $email<br>";
                }
                if(array_key_exists('user_emails_array', $users_array[$user_key])) {
                    $email = '';
                    $id = '';
                    echo 'it exists!<br>';
                    foreach($users_array[$user_key]['user_emails_array'] as $e_k => $e_v)
                    {
                        if($e_k == 'email')
                            if(!is_array($e_v))
                                $email = $e_v;
                        if($e_k == 'id')
                            if(!is_array($e_v))
                                $id = $e_v;
                        echo "$id :: Email sent to $email<br>";
                    }
                }
            }

            /*            var_dump(memory_get_usage());
            echo '<br>';*/
        }

        $users_array = $this->addLeafKeys($users_array);
        return $users_array;
    }

    public function sendEmailAndDropFromArray($users_array)
    {

    }

    public function pushKeyAndValueToArray($users_array, $key_name_to_add, $value_to_add, $user_key)
    {
        if (!array_key_exists($key_name_to_add, $users_array))
        {
            $users_array[$user_key][$key_name_to_add] = $value_to_add;
            /*            var_dump(memory_get_usage());
                        echo '<br>';*/
        }
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