<?php

namespace easysdk\Kernel\Providers;

use GuzzleHttp\Client;
use Pimple\ServiceProviderInterface;

/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */
class HttpProvider implements ServiceProviderInterface
{
    /**
     * @param \Pimple\Container $pimple
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    public function register(\Pimple\Container $pimple)
    {
        !isset($pimple['http']) && $pimple['http'] = function ($app) {
            return new Client($app['config']->get('http', []));
        };
    }
}