<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
  public function register()
  {
    // Daftarkan Interface and Repository disni
    // Letakkan Interface paling atas
    // Kalau tidak, Repository tidak bisa terbaca
    $this->app->bind(
      'App\Interfaces\UserInterface',
      'App\Repositories\UserRepository'
    );
    $this->app->bind(
      'App\Interfaces\PostInterface',
      'App\Repositories\PostRepository'
    );

    //Jika mau mendaftarkan Interface dan Repository baru
    // Register another new interface and repository
    // $this->app->bind(
    //   'App\Interfaces\NewInterfaceExampleName',
    //   'App\Repositories\NewRepositoryExampleName'
    // );

    // $this->app->bind(
    //   'App\Interfaces\AnotherNewInterfaceExampleName',
    //   'App\Repositories\AnotherNewRepositoryExampleName'
    // );
  }
}
