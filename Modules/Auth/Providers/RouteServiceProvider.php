<?php

namespace Modules\Auth\Providers;

use Illuminate\Support\Facades\Route;
use Modules\Base\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Auth';

    /**
     * The module namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $moduleNamespace = 'Modules\Auth\Http\Controllers';

}
