<?php
namespace xcesaralejandro\requeststorer\Providers;

use App\Http\Middleware\StoreOnArrival;
use App\Http\Middleware\StoreOnResponse;
use Illuminate\Support\ServiceProvider;

class RequestStorerServiceProvider extends ServiceProvider {

    public function boot(){
        $this->publishes([
            $this->packageBasePath('database/migrations') => database_path('migrations')
        ], 'xcesaralejandro-requeststorer-migrations');
        $this->publishes([
            $this->packageBasePath('Http/Middleware') => base_path('app/Http/Middleware')
        ], 'xcesaralejandro-requeststorer-middlewares');
    }

    public function register(){
        $router = $this->app['router'];
        $router->aliasMiddleware('store.on.arrival', 'App\\Http\\Middleware\\StoreOnArrival::class');
        $router->aliasMiddleware('store.on.response', 'App\\Http\\Middleware\\StoreOnResponse::class');
        $this->app->singleton(StoreOnResponse::class);
        $this->loadMigrationsFrom($this->packageBasePath('database/migrations'));
    }

    protected function packageBasePath($path){
        return __DIR__."/../../$path";
    }
}
