<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/20 23:44
 * Copyright: php
 */

namespace easysdk\Wechat\notify;

use Closure;
use easysdk\Kernel\Client\UnionPayMiniClient;
use easysdk\Kernel\Client\WechatClient;
use easysdk\Kernel\Traits\WechatNotifyHandle;

/**
 * Class Client
 *
 * @package easysdk\UnionPayMini\notify
 */
class Client extends WechatClient
{
    use WechatNotifyHandle;

    /**
     * @param Closure $closure
     * @return \Symfony\Component\HttpFoundation\Response
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/20 11:49
     * @throws \Exception
     */
    public function unit(Closure $closure)
    {
        $response = \call_user_func($closure, $this->getData(), [$this]);
        $this->setResponse($response);
        return $this->toResponse()->send();
    }
}
