<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        // php artisan db:seed --database=fmtdb

        // Delete the current table contents
        DB::table('users')->truncate();
        DB::table('user_emails')->truncate();
        DB::table('user_jsdb_customers')->truncate();
        DB::table('user_jsdb_suppliers')->truncate();

        // Create a static user for easy login testing
        $user = User::create([
            'username' => 'dejavoodoo',
            'email' => 'insanekilroy@gmail.com',
            'password' => Hash::make('abc123'),
            'first_name' => 'Scott',
            'last_name' => 'Smith',
            'company_name' => 'Bobs Transport',
        ]);

        // Helpers::prePrintR($user);

        $faker = Faker\Factory::create();

        // Create n users
        for($i = 0; $i < $_ENV['number_of_seeds_to_insert']; $i++)
        {
            $user = $this->createRandomUser($faker);
            $this->insertSomeUserEmails($faker, $user);
            $this->insertSomeUserCustomers($faker, $user);
            $this->insertSomeUserSuppliers($faker, $user);

            // foreach user, insert 0-3 child users
            $rand_j = rand(0,3);
            if($rand_j > 0) {
                for($j = 0; $j <= $rand_j; $j++)
                {
                    $user_child = $this->createRandomUser($faker);
                    $user_child->makeChildOf($user);

                    $this->insertSomeUserEmails($faker, $user_child);
                    $this->insertSomeUserCustomers($faker, $user_child);
                    $this->insertSomeUserSuppliers($faker, $user_child);

                    // foreach child user, insert 0-3 child-child users
                    $rand_k = rand(0,3);
                    if($rand_k > 0) {
                        for($k = 0; $k <= $rand_k; $k++)
                        {
                            $user_child_child = $this->createRandomUser($faker);
                            $user_child_child->makeChildOf($user_child);

                            $this->insertSomeUserEmails($faker, $user_child_child);
                            $this->insertSomeUserCustomers($faker, $user_child_child);
                            $this->insertSomeUserSuppliers($faker, $user_child_child);

                        }
                    }
                }
            }
        }

    }

    protected function createRandomUser($faker)
    {
        return User::create([
            'username' => $faker->userName,
            'email' => $faker->email,
            'password' => Hash::make('abc123'),
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'company_name' =>  $faker->company,
        ]);
    }

    protected function createRandomUserEmail($faker, $user_id)
    {
        if($user_id > 0)
        {
            // Create a user email
            return UserEmail::create([
                'user_id' => $user_id,
                'email' => $faker->email,
            ]);
        }
    }

    protected function createRandomUserCustomer($faker, $user_id)
    {
        if($user_id > 0) {

            $cust_or_subcust_picker = rand(0,1);

            if($cust_or_subcust_picker == 0) {

                // Create a customer
                return UserCustomer::create([
                    'user_id' => $user_id,
                    'jsdb_cust_id' => rand(1,999),
                    'jsdb_sub_cust_id' => 0,
                    'cust_name' => $faker->company,
                ]);

            }

            // Create a sub customer
            return UserCustomer::create([
                'user_id' => $user_id,
                'jsdb_cust_id' => 0,
                'jsdb_sub_cust_id' => rand(1,999),
                'cust_name' => $faker->company,
            ]);
        }
    }

    protected function createRandomUserSupplier($faker, $user_id)
    {
        if($user_id > 0) {

            // Create a supplier
            return UserSupplier::create([
                'user_id' => $user_id,
                'jsdb_supp_id' => rand(1,999),
                'supp_name' => $faker->company,
            ]);

        }
    }

    protected function insertSomeUserEmails($faker, $user)
    {
        // insert 0-3 emails (user_emails_tbl)
        $rand = rand(0, 2);
        if ($rand > 0) {
            for ($i = 0; $i < $rand; $i++) {
                $this->createRandomUserEmail($faker, $user->id);
            }
        }
    }

    protected function insertSomeUserCustomers($faker, $user)
    {
        // insert 0-3 customers (user_jsdb_customers_tbl)
        $rand = rand(0, 1);
        if ($rand > 0) {
            for ($i = 0; $i < $rand; $i++) {
                $this->createRandomUserCustomer($faker, $user->id);
            }
        }
    }

    protected function insertSomeUserSuppliers($faker, $user)
    {
        // insert 0-3 suppliers (user_jsdb_suppliers_tbl)
        $rand = rand(0, 1);
        if ($rand > 0) {
            for ($i = 0; $i < $rand; $i++) {
                $this->createRandomUserSupplier($faker, $user->id);
            }
        }
    }


}