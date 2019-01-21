<?php namespace Jc91715\Jwt;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Jc91715\Jwt\Http\Middleware\RefreshToken;

class ServiceProvider extends LaravelServiceProvider {

    /**
     * The middleware aliases.
     *
     * @var array
     */
    protected $middlewareAliases = [
        'refresh.token' => RefreshToken::class,
    ];
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {

        $this->aliasMiddleware();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {

        $this->registerCommand();

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {

        return [];
    }


    public function registerCommand()
    {
        $this->app->singleton('command.make.jwt', function ($app) {
            return $app['Jc91715\Jwt\Console\JwtCommand'];
        });

        $this->commands('command.make.jwt');
    }

    /**
     * Alias the middleware.
     *
     * @return void
     */
    protected function aliasMiddleware()
    {
        $router = $this->app['router'];

        $method = method_exists($router, 'aliasMiddleware') ? 'aliasMiddleware' : 'middleware';

        foreach ($this->middlewareAliases as $alias => $middleware) {
            $router->$method($alias, $middleware);
        }
    }

}
