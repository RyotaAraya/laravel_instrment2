<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        //商用環境以外だった場合SQLログを出力する
        if(config('app.env') !== 'production'){
            \DB::listen(function ($query){
                \Log::info("Query Time:{$query->time}s] $query->sql");
            });
        }
        //開発環境であればfalseでhttp接続
        //本番環境であればtrueでhttps接続とする
        $is_production = env('APP_ENV') === 'production' ? true : false;
        View::share('is_production',$is_production);
    }
}
