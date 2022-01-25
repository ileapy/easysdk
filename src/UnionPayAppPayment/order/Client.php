<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 21:35
 * Copyright: php
 */

namespace easysdk\UnionPayAppPayment\order;

use easysdk\Kernel\Client\UnionPayAppPaymentClient;
use easysdk\Kernel\Exceptions\InvalidArgumentException;
use easysdk\Kernel\Exceptions\ValidationFailException;

/**
 * Class Client
 *
 * @package easysdk\UnionPayAppPayment\order
 */
class Client extends UnionPayAppPaymentClient
{
    /**
     * 支付
     * @param $params
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws InvalidArgumentException|ValidationFailException
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 19:23
     */
    public function pay($params)
    {
        // 地址
        $this->setEndpoint("appTransReq.do");

        // 固定数据
        $base = [
            // 产品类型
            'bizType'          =>      '000201',
            // 订单发送时间，格式为YYYYMMDDhhmmss，取北京时间
            'txnTime'        =>        date('YmdHis'),
            // 交易类型
            'txnType'        =>        '01',
            // 交易子类
            'txnSubType'     =>        '01',
            // 商户代码，请改自己的商户号
            'merId'          =>        $this->config['merId']
        ];

        // 合并
        $data = array_replace_recursive($this->config['payConfig'], $base, $params);

        // 必填项校验
        if (!isset($data['orderId']) || !isset($data['txnAmt']))
            throw new InvalidArgumentException("商户订单号[orderId]和订单金额[txnAmt]必传");

        // 签名
        $this->app->signature->sign($data);

        // 验签
        $result = $this->send($data);
        if (!$this->app->signature->validate($result)) throw new ValidationFailException('验签失败');
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
        $this->setEndpoint("backTransReq.do");

        $base = [
            // 产品类型
            'bizType'          =>      '000201',
            // 订单发送时间，格式为YYYYMMDDhhmmss，取北京时间
            'txnTime'        =>        date('YmdHis'),
            // 交易类型
            'txnType'        =>        '31',
            // 交易子类
            'txnSubType'     =>        '00',
            // 商户代码，请改自己的商户号
            'merId'          =>        $this->config['merId']
        ];

        $data = array_replace_recursive($this->config['payConfig'], $base, $params);

        // 必填项校验
        if (!isset($data['txnAmt']) || !isset($data['orderId']) || !isset($data['origQryId']))
            throw new InvalidArgumentException("商户订单号(重新生成，相当于退款单号)[orderId]和订单金额（和原订单金额一样）[txnAmt]和原交易查询流水号（支付成功后返回的）[origQryId]必传");

        // 签名
        $this->app->signature->sign($data);

        // 验签
        $result = $this->send($data);
        if (!$this->app->signature->validate($result)) throw new ValidationFailException('验签失败');
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
        $this->setEndpoint("backTransReq.do");

        $base = [
            // 产品类型
            'bizType'          =>      '000201',
            // 订单发送时间，格式为YYYYMMDDhhmmss，取北京时间
            'txnTime'        =>        date('YmdHis'),
            // 交易类型
            'txnType'        =>        '04',
            // 交易子类
            'txnSubType'     =>        '00',
            // 商户代码，请改自己的商户号
            'merId'          =>        $this->config['merId']
        ];

        $data = array_replace_recursive($this->config['payConfig'], $base, $params);

        // 必填项校验
        if (!isset($data['txnAmt']) || !isset($data['orderId']) || !isset($data['origQryId']))
            throw new InvalidArgumentException("商户订单号(重新生成，相当于退款单号)[orderId]和订单金额（退货总金额需要小于等于原消费）[txnAmt]和原交易查询流水号（支付成功后返回的）[origQryId]必传");

        // 签名
        $this->app->signature->sign($data);

        // 验签
        $result = $this->send($data);
        if (!$this->app->signature->validate($result)) throw new ValidationFailException('验签失败');
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
        $this->setEndpoint("queryTrans.do");

        $base = [
            // 产品类型
            'bizType'          =>      '000000',
            // 订单发送时间，格式为YYYYMMDDhhmmss，取北京时间
            'txnTime'        =>        date('YmdHis'),
            // 交易类型
            'txnType'        =>        '00',
            // 交易子类
            'txnSubType'     =>        '00',
            // 商户代码，请改自己的商户号
            'merId'          =>        $this->config['merId']
        ];
        $data = array_replace_recursive($this->config['payConfig'], $base, $params);

        // 必填项校验
        if (!isset($data['orderId']))
            throw new InvalidArgumentException("商户订单号[orderId]必传");

        // 签名
        $this->app->signature->sign($data);

        // 验签
        $result = $this->send($data);
        if (!$this->app->signature->validate($result)) throw new ValidationFailException('验签失败');
        return $result;
    }
}
