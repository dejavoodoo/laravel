<?php

use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind(
            'FMTAES\UserRepository',
            'FMTAES\DbUserRepository'
        );

        $this->app->bind(
            'FMTAES\JobRepository',
            'FMTAES\DbJobRepository'
        );
    }

}