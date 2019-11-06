<?php

namespace ThemisMin\LaravelPaginate;

use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use ThemisMin\LaravelPaginate\Pagination\CustomPaginator;

class LaravelServiceProvider extends ServiceProvider
{
    /**
     * Boot the provider.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the provider.
     */
    public function register()
    {

        /** 自定义分页数据 */
        Builder::macro('customPaginator', function ($items, $total, $perPage, $currentPage, $options) {
            return Container::getInstance()->makeWith(CustomPaginator::class, compact(
                'items', 'total', 'perPage', 'currentPage', 'options'
            ));
        });

        /** 自定义分页 */
        Builder::macro('customPaginate', function ($custom = null, $perPage = 15, $columns = ['*'], $pageName = 'page', $page = null) {
            $page = $page ?: Paginator::resolveCurrentPage($pageName);
            $perPage = $perPage ?: $this->model->getPerPage();
            $results = ($total = $this->toBase()->getCountForPagination())
                ? $this->forPage($page, $perPage)->get($columns)
                : $this->model->newCollection();

            return $this->customPaginator($results, $total, $perPage, $page, [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,
                'custom' => $custom,
            ]);
        });
    }
}
