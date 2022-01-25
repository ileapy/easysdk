<?php

namespace easysdk\ByteMini\other;

use Pimple\Container;
use Pimple\ServiceProviderInterface;


/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $pimple
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    public function register(Container $pimple)
    {
        !isset($pimple['other']) && $pimple['other'] = function ($pimple) {
            return new Client($pimple);
        };
    }
}