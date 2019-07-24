<?php
namespace Chendujin\Bitcoin;
use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;
use Chendujin\Bitcoin\Lib\Bitcoin;

class BitcoinServiceProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap the application services.
     * 在注册后进行服务的启动
     *
     * @return void
     */
    public function boot()
    {
        $dist = __DIR__.'/../config/bitcoin.php';
        if (function_exists('config_path')) {
            // Publishes config File. 发布到项目的配置文件(即config)下
            $this->publishes([
                $dist => config_path('bitcoin.php'),
            ]);
        }
        $this->mergeConfigFrom($dist, 'bitcoin');
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Bitcoin::class, function ($app) {
            return $this->createInstance($app['config']);
        });
    }
    public function provides()
    {
        return [Bitcoin::class];
    }
    protected function createInstance(Repository $config)
    {
        // Check for bitcoin config file.
        if (! $this->hasConfigSection()) {
            $this->raiseRunTimeException('Missing bitcoin configuration section.');
        }
        // Check for username.
        if ($this->configHasNo('user')) {
            $this->raiseRunTimeException('Missing bitcoin configuration: "user".');
        }
        // Check for secret.
        if ($this->configHasNo('secret')) {
            $this->raiseRunTimeException('Missing bitcoin configuration: "secret".');
        }
        // Check for host.
        if ($this->configHasNo('host')) {
            $this->raiseRunTimeException('Missing bitcoin configuration: "host".');
        }
        // check the password
        if ($this->configHasNo('port')) {
            $this->raiseRunTimeException('Missing bitcoin configuration: "port".');
        }
        // dd($config);
        return new Bitcoin($config->get('bitcoin.user'),$config->get('bitcoin.secret'),$config->get('bitcoin.host'), $config->get('bitcoin.port'));
    }
    /**
     * Checks if has global bitcoin configuration section.
     *
     * @return bool
     */
    protected function hasConfigSection()
    {
        return $this->app->make(Repository::class)
            ->has('bitcoin');
    }
    /**
     * Checks if Nexmo config does not
     * have a value for the given key.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function configHasNo($key)
    {
        return ! $this->configHas($key);
    }
    /**
     * Checks if bitcoin config has value for the
     * given key.
     *
     * @param string $key
     *
     * @return bool
     */
    protected function configHas($key)
    {
        /** @var Config $config */
        $config = $this->app->make(Repository::class);
        // Check for bitcoin config file.
        if (! $config->has('bitcoin')) {
            return false;
        }
        return
            $config->has('bitcoin.'.$key) &&
            ! is_null($config->get('bitcoin.'.$key)) &&
            ! empty($config->get('bitcoin.'.$key));
    }
    /**
     * Raises Runtime exception.
     *
     * @param string $message
     *
     * @throws \RuntimeException
     */
    protected function raiseRunTimeException($message)
    {
        throw new \RuntimeException($message);
    }
}