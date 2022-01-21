<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */

namespace easysdk\Kernel\Providers;

use easysdk\Kernel\Support\Collection;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ConfigProvider
 * @package: easysdk\Kernel\Providers
 */
class ConfigProvider implements ServiceProviderInterface
{
    /**
     * @param Container $pimple
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    public function register(Container $pimple)
    {
        !isset($pimple['config']) && $pimple['config'] = function ($app) {
            return new Collection($app->getConfig());
        };
    }
}