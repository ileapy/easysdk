<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/17 23:12
 * Copyright: php
 */

namespace easysdk\UnionPayAppPayment\notify;

use Closure;
use easysdk\Kernel\Client\UnionPayAppPaymentClient;
use easysdk\Kernel\Traits\UnionPayAppPaymentNotifyHandle;

/**
 * Class Client
 * @package easysdk\UnionPayAppPayment\notify
 */
class Client extends UnionPayAppPaymentClient
{
    use UnionPayAppPaymentNotifyHandle;

    /**
     * @param Closure $closure
     * @param bool $isCheck
     * @return \Symfony\Component\HttpFoundation\Response
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/20 11:49
     * @throws \Exception
     */
    public function unit(Closure $closure, $isCheck = true)
    {
        $this->isCheck = $isCheck;
        call_user_func($closure, $this->getData(), [$this]);
        return $this->toResponse();
    }
}
