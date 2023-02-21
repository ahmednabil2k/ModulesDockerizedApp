<?php

namespace Modules\Roles\Providers;

use Modules\Base\Providers\BaseServiceProvider;

class RolesServiceProvider extends BaseServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Roles';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'roles';

    /**
     * @var string $routeServiceProvider
     */
    protected $routeServiceProvider = RouteServiceProvider::class;

}
