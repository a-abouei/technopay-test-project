<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class FilterServiceProvider extends ServiceProvider
{

    protected array $filters = [];

    /**
     * Register services.
     *
     * Discover and register filters from filter service.
     */
    public function register(): void
    {
        $this->app->singleton('filter.classes', function () {
            $filterPath = app_path('Services/FilterService');
            $files = File::allFiles($filterPath);

            foreach ($files as $file) {
                $class = 'App\Services\FilterService\Filters\\' . Str::replaceLast('.php', '', $file->getFilename());
                if (class_exists($class)){
                    $fileInterface = new $class;
                    if (method_exists($fileInterface, 'apply')) {
                        $filterName = Str::snake(Str::replaceLast('Filter', '', class_basename($class)));
                        $this->filters[$filterName] = $class;
                    }
                }
            }
            return $this->filters;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
