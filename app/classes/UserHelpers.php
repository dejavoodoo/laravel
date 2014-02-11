<?php

class UserHelpers {

    protected $user;
    protected $userCustomer;
    protected $userSupplier;

    public function __construct()
    {
        $this->user = new User;
        $this->userCustomer = new UserCustomer;
        $this->userSupplier = new UserSupplier;
    }

    public function getUsers()
    {
        return $this->user->all()->toArray();
    }

    public function getUserCustomers()
    {
        $customers = $this->userCustomer->all()->toArray();

        // group by user id
        $arr = array();
        foreach($customers as $k => $v) {
            $arr[$v['user_id']][$k] = $v;
        }

        return $arr;
    }

    public function getUserSuppliers()
    {
        $suppliers = $this->userSupplier->all()->toArray();

        // group by user id
        $arr = array();
        foreach($suppliers as $k => $v) {
            $arr[$v['user_id']][$k] = $v;
        }

        return $arr;
    }

    public function getUsersWithCustomers()
    {
        return $this->user->get()->toHierarchy()->toArray();
    }

    public function mergeUsersWithCustsAndSupps($users_array, $custs_array, $supps_array, $output_array = [])
    {

            // Iterate through the user array and merge CustID, SubCustID and SuppID if user_id key values match.
            foreach($users_array as $user_key => $user_value)
            {
                // if array_key_exists(children) --> has children. Go deeper (do recursion).  If not, continue to the next array element on this array-level
                if(is_array($users_array[$user_key])) {

                    if(array_key_exists('children', $users_array[$user_key])) {
                        $children_array = array_pop($users_array[$user_key]);

                    }

                    foreach($custs_array as $cust_key => $cust_value) {
                        if($user_key == $cust_key) { // user_key is the user ID
                            $users_array = $this->pushKeyAndValueToArray($users_array, 'jsdb_cust_id_array', $cust_value, $user_key);
                        }
                    }

                    foreach($supps_array as $supp_key => $supp_value) {
                        if($user_key == $supp_key) { // user_key is the user ID
                            $users_array = $this->pushKeyAndValueToArray($users_array, 'jsdb_supp_id_array', $supp_value, $user_key);
                        }
                    }

                    if(!empty($children_array)) {
                        $users_array[$user_key]['children'] = $children_array;
                    }

                    $users_array[$user_key] = $this->mergeUsersWithCustsAndSupps($users_array[$user_key], $custs_array, $supps_array, $output_array);
                }
            }
        return $users_array;
    }

    /**
     * @param $users_array
     * @param $key_name_to_add
     * @param $value_to_add
     * @param $user_key
     * @return mixed
     */
    private function pushKeyAndValueToArray($users_array, $key_name_to_add, $value_to_add, $user_key)
    {
        if (!array_key_exists($key_name_to_add, $users_array)) {
            $users_array[$user_key][$key_name_to_add] = $value_to_add;
            return $users_array;
        }
        return $users_array;
    }

}