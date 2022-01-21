<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/20 10:10
 * Copyright: php
 */

namespace easysdk\Kernel\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestProvider
 * @package: easysdk\Kernel\Providers
 */
class RequestProvider implements ServiceProviderInterface
{
    /**
     * @param Container $pimple
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    public function register(Container $pimple)
    {
        !isset($pimple['request']) && $pimple['request'] = function () {
            return Request::createFromGlobals();
        };
    }
}
