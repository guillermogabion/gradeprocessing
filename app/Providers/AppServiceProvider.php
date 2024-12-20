<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\View;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserOrganization;

class AppServiceProvider extends ServiceProvider
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::extend('decimal', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^\d+(\.\d{1,2})?$/', $value);
        });

        Validator::replacer('decimal', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, ':attribute must be a valid decimal number with up to two decimal places.');
        });
        // View::composer('*', function ($view) {
        //     if (auth()->check()) {
        //         $view->with('profile', Details::find(auth()->user()->id));
        //     } else {
        //         $view->with('profile', null); // or handle as needed
        //     }
        // });
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $profile = User::where('id', auth()->user()->id)->first(); // Use where to find by user_id
                $view->with('profile', $profile);

                $organization = UserOrganization::where('user_id', auth()->user()->id)
                    ->whereNotNull('organization_id')->with('userorganization_organization') // Check if organization_id is not null
                    ->first();


                $view->with('organization', $organization);
            } else {
                $view->with('profile', null);
                $view->with('organization', null);
            }
        });
    }
}
