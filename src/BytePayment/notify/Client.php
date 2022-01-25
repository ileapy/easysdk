<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/20 23:44
 * Copyright: php
 */

namespace easysdk\BytePayment\notify;

use Closure;
use easysdk\Kernel\Client\BytePaymentClient;
use easysdk\Kernel\Traits\BytePaymentNotifyHandle;

/**
 * Class Client
 *
 * @package easysdk\BytePayment\notify
 */
class Client extends BytePaymentClient
{
    use BytePaymentNotifyHandle;

    /**
     * @param Closure $closure
     * @return \Symfony\Component\HttpFoundation\Response
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/20 11:49
     * @throws \Exception
     */
    public function unit(Closure $closure)
    {
        \call_user_func($closure, $this->getData(), [$this]);
        return $this->toResponse();
    }
}
