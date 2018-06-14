<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $config=$this->getConfig();
        view()->share('config',$config);
     }
     private function getConfig()
    {
        try{
            $config=DB::table('hbb_system_config')->first();
            return $config;
        }
        catch (\Exception $e)
        {
            return view('404');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
