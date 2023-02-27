<?php

namespace Modules\Auth\Providers;

use Illuminate\Database\Eloquent\Factory;
use Modules\Base\Providers\BaseServiceProvider;

class AuthServiceProvider extends BaseServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Auth';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'auth';

    /**
     * @var string $routeServiceProvider
     */
    protected $routeServiceProvider = RouteServiceProvider::class;

}
