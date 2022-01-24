<?php

namespace easysdk\ByteMini\token;

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
        !isset($pimple['access_token']) && $pimple['access_token'] = function ($pimple) {
            return new AccessToken($pimple);
        };
    }
}