<?php

namespace PacificDev\SocialLogin;

use Illuminate\Support\ServiceProvider;

# Todo: Update the SampleCommand and AnotherSampleCommand if needed or clean up
use PacificDev\SocialLogin\Commands\SampleCommand;
use PacificDev\SocialLogin\Commands\AnotherSampleCommand;
use Illuminate\Support\Facades\Blade;

class PacificDevServiceProvider extends ServiceProvider
{


  function register()
  {
    $this->mergeConfigFrom(
      __DIR__ . '/config/social-login.php',
      'social-login'
    );
  }
  function boot()
  {
    // Register the component
    Blade::componentNamespace('PacificDev\\View\\Components', 'pacificdev');
    // load the views from the package directory
    $this->loadViewsFrom(__DIR__ . '/resources/views', 'pacificdev');


    // todo: publish the package files by tag
    $this->publishes([
      __DIR__ . '/config/social-login.php' => config_path('social-login.php'),

    ], 'pacificdev-social-login-config');

    $this->publishes([
      __DIR__ . '/resources/views' => resource_path('views/vendor/pacificdev'),

    ], 'pacificdev-social-login-views');

    $this->publishesMigrations([
      __DIR__ . '/database/migrations' => database_path('migrations'),

    ], 'pacificdev-social-login-migrations');



    // update the environment file to add required credentials
    $this->update_env_file();

    // load routes
    $this->loadRoutes(__DIR__ . '/routes');

    // load models
    $this->loadModelsFrom(__DIR__ . '/Models');


    // load controllers
    $this->loadControllersFrom(__DIR__ . '/app/Http/Controllers');


    /**
     * Checks and registers package's artisan commands
     */
    if ($this->app->runningInConsole()) {
      $this->commands([
        SampleCommand::class, // Todo: update or remove
        AnotherSampleCommand::class // Todo: update or remove
      ]);
    }
  }



  private function loadControllersFrom($path)
  {

    if (is_null($path)) throw new Exception("Path cannot be null");

    if (File::isDirectory(base_path('app/Http/Controllers/SocialLogin'))) {
      File::copy($path . '/SocialLogin/SocialController.php', base_path('app/Http/Controllers/SocialLogin/SocialController.php'));
    } else {
      File::copyDirectory($path, base_path('/app/Http/Controllers'));
    }
  }




  /**
   * Loads package's models into the laravel application
   */
  private function loadModelsFrom($path)
  {
    File::copyDirectory(
      $path,
      base_path('/app/Models')
    );
  }




  private function loadRoutes($path)
  {
    // If the route file does not exist we copy it and append it to the end of web.php
    if (!File::exists(base_path('/routes/social-login.php'))) {
      File::copy($path . '/social-login.php', base_path('/routes/social-login.php'));
      $web_php_file = 'routes/web.php';
      $this->append_to_file($web_php_file, "require __DIR__ . '/social-login.php';");
    }
  }


  /**
   * 
   * Adds the LinkedIn app credentials variables to the .env file
   */
  private function update_env_file(): void
  {
    $env_file_path = '.env';
    $env = file_get_contents(base_path($env_file_path));
    // check if the keys are already in the .env file and append only if not already present
    if (
      !str_contains($env, 'LINKEDIN_CLIENT_ID') &&
      !str_contains($env, 'LINKEDIN_CLIENT_SECRET')
    ) {

      $this->append_to_file($env_file_path, 'LINKEDIN_CLIENT_ID=your_client_id_key_goes_here');
      $this->append_to_file($env_file_path, 'LINKEDIN_CLIENT_SECRET=your_secrets_here');
    }
  }


  private function append_to_file($file, string $contents)
  {
    $file_path = base_path($file);
    $file_contents = file_get_contents($file_path);
    $file_contents .= $contents;
    file_put_contents($file_path, $file_contents);
  }
}
