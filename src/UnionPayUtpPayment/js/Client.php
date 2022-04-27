<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 21:35
 * Copyright: php
 */

namespace easysdk\UnionPayUtpPayment\js;

use easysdk\Kernel\Client\UnionPayUtpPaymentClient;
use easysdk\Kernel\Exceptions\InvalidArgumentException;
use easysdk\Kernel\Exceptions\ValidationFailException;

/**
 * Class Client
 *
 * @package easysdk\UnionPayAppPayment\order
 */
class Client extends UnionPayUtpPaymentClient
{
    /**
     * pay 支付
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/4/21
     * @param $params
     * @return array|mixed
     * @throws ValidationFailException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function pay($params)
    {
        $data = [
            'svcApi' => 'up.fpsd.trade.utp.pay.js',
        ];
        $data = array_merge_recursive($data, $params);
        // 验签
        $result = $this->send($data);

        var_dump($result);
        if (!$this->verify($result)) throw new ValidationFailException('验签失败');
        return $result;
    }

    /**
     * 订单撤销
     * @param $params
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws InvalidArgumentException|ValidationFailException
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/19 22:14
     */
    public function cancel($params)
    {
        $data = [
            'svcApi' => 'up.fpsd.trade.utp.cancel',
        ];
        $data = array_merge_recursive($data, $params);
        // 验签
        $result = $this->send($data);

        if (!$this->verify($result)) throw new ValidationFailException('验签失败');
        return $result;
    }

    /**
     * 订单退货
     * @param $params
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws InvalidArgumentException|ValidationFailException
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/19 22:15
     */
    public function refund($params)
    {
        $data = [
            'svcApi' => 'up.fpsd.trade.utp.refund',
        ];
        $data = array_merge_recursive($data, $params);
        // 验签
        $result = $this->send($data);

        if (!$this->verify($result)) throw new ValidationFailException('验签失败');
        return $result;
    }

    /**
     * 订单查询
     * @param $params
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException*@throws InvalidArgumentException
     * @throws InvalidArgumentException
     * @throws ValidationFailException
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/19 22:17
     */
    public function query($params)
    {
        $data = [
            'svcApi' => 'up.fpsd.trade.utp.query',
        ];
        $data = array_merge_recursive($data, $params);
        // 验签
        $result = $this->send($data);

        if (!$this->verify($result)) throw new ValidationFailException('验签失败');
        return $result;
    }
}
