<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Firebase\JWT\JWT;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            $token = $request->bearerToken();
            try {
                $decoded = JWT::decode($token, env("APP_KEY"), array('HS256'));
                return $decoded;
            } catch (\Exception $e) {
                return null;
            }
        });
    }
}
