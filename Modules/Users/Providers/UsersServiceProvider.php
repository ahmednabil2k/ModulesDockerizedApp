<?php

namespace Modules\Users\Providers;


use Modules\Base\Providers\BaseServiceProvider;

class UsersServiceProvider extends BaseServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Users';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'users';

    protected $routeServiceProvider = RouteServiceProvider::class;
}
