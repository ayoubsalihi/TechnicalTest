<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\{
    UserRepository,
    TaskRepository,
    UserRepositoryInterface,
    TaskRepositoryInterface
};
use App\Services\{
    AuthService,
    TaskService
};

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        
        $this->app->bind(AuthService::class, function ($app) {
            return new AuthService($app->make(UserRepositoryInterface::class));
        });
        
        $this->app->bind(TaskService::class, function ($app) {
            return new TaskService(
                $app->make(TaskRepositoryInterface::class),
                $app->make(UserRepositoryInterface::class)
            );
        });
    }
}