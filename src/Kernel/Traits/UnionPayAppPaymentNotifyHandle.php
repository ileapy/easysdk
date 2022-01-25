<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/20 9:33
 * Copyright: php
 */

namespace easysdk\Kernel\Traits;

use easysdk\Kernel\Exceptions\ValidationFailException;
use Exception;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UnionPayAppPaymentNotifyHandle
 *
 * @package unionpay\Kernel\Traits
 */
trait UnionPayAppPaymentNotifyHandle
{
    /**
     * @var string
     */
    protected $data = [];

    /**
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/20 9:34
     */
    protected function toResponse()
    {
        return new Response(json_encode(["resp" => "00"]));
    }

    /**
     * @return array|string
     * @throws ValidationFailException
     * @throws Exception
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/20 9:37
     */
    protected function getData()
    {
        if (!empty($this->data)) return $this->data;

        try {
            $param_str = strval($this->app['request']->getContent());
            parse_str($param_str,$data);
        }catch (Exception $e)
        {
            throw new Exception('Invalid request.', 400);
        }

        if (!is_array($data) || empty($data)) {
            throw new Exception('Invalid request.', 400);
        }

        if (!$this->app->signature->validate($data))
            throw new ValidationFailException('验签失败', 400);

        return $this->data = $data;
    }
}
