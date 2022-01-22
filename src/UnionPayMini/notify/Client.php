<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/20 23:44
 * Copyright: php
 */

namespace easysdk\UnionPayMini\notify;

use Closure;
use easysdk\Kernel\Client\UnionPayMiniClient;
use easysdk\Kernel\Traits\MiniProgramNotifyHandle;

/**
 * Class Client
 *
 * @package easysdk\UnionPayMini\notify
 */
class Client extends UnionPayMiniClient
{
    use MiniProgramNotifyHandle;

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
        \call_user_func($closure, $this->getData(), [$this]);
        return $this->toResponse();
    }
}
