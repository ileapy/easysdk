<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 9:16
 * Copyright: php
 */

namespace easysdk\ByteMini\secure;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 *
 * @package easysdk\ByteMini\contract
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 19:49
     */
    public function register(Container $app)
    {
        $app['secure'] = function ($app) {
            return new Client($app);
        };
    }
}
