<?php

namespace easysdk\UnionPayMini\token;

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

        !isset($pimple['backend_token']) && $pimple['backend_token'] = function ($pimple) {
            return new BackendToken($pimple);
        };

        !isset($pimple['front_token']) && $pimple['front_token'] = function ($pimple) {
            return new FrontToken($pimple);
        };
    }
}