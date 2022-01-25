<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\BytePayment\order;

use easysdk\Kernel\Client\BytePaymentClient;

/**
 * Class Client
 * @package: easysdk\Client\order
 */
class Client extends BytePaymentClient
{
    /**
     * 创建订单
     * @param string $out_order_no 开发者侧的订单号, 同一小程序下不可重复
     * @param string $total_amount 支付价格; 接口中参数支付金额单位为[分]
     * @param string $subject 商品描述; 长度限制 128 字节，不超过 42 个汉字
     * @param string $body 商品详情
     * @param int $valid_time 订单过期时间(秒); 最小 15 分钟，最大两天
     * @param array $params 更多参数
     * cp_extra string 否 开发者自定义字段，回调原样回传
     * notify_url string 否 商户自定义回调地址
     * thirdparty_id string 否，服务商模式接入必传 第三方平台服务商 id，非服务商模式留空
     * disable_msg number 否 是否屏蔽担保支付的推送消息，1-屏蔽 0-非屏蔽，接入 POI 必传
     * msg_page string 否 担保支付消息跳转页
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function createOrder($out_order_no, $total_amount, $subject,$body,$valid_time, $params = [])
    {
        $this->setEndpoint('apps/ecpay/v1/create_order');
        $data = array_merge($this->getCredentials(compact('out_order_no','total_amount','subject','body','valid_time')),$params);
        $this->signature($data);
        return $this->send($data);
    }

    /**
     * 订单查询
     * @param string $out_order_no 开发者侧的订单号, 同一小程序下不可重复
     * @param string $thirdparty_id 第三方平台服务商 id，非服务商模式留空
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function queryOrder($out_order_no, $thirdparty_id='')
    {
        $this->setEndpoint('apps/ecpay/v1/query_order');
        $data = $this->getCredentials(compact('out_order_no','thirdparty_id'));
        $this->signature($data);
        return $this->send($data);
    }

    /**
     * 退款
     * @param string $out_order_no 商户分配订单号，标识进行退款的订单
     * @param string $out_refund_no 商户分配退款号
     * @param string $reason 退款原因
     * @param int $refund_amount 退款金额，单位[分]
     * @param array $params 更多参数
     * cp_extra string 否 开发者自定义字段，回调原样回传
     * notify_url string 否 商户自定义回调地址
     * thirdparty_id string 否，服务商模式接入必传 第三方平台服务商 id，非服务商模式留空
     * disable_msg number 否 是否屏蔽担保支付的推送消息，1-屏蔽 0-非屏蔽，接入 POI 必传
     * msg_page string 否 担保支付消息跳转页
     * all_settle number 否 是否为分账后退款，1-分账后退款；0-分账前退款。分账后退款会扣减可提现金额，请保证余额充足
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function createRefund($out_order_no, $out_refund_no, $reason,$refund_amount, $params = [])
    {
        $this->setEndpoint('apps/ecpay/v1/create_refund');
        $data = array_merge($this->getCredentials(compact('out_order_no','out_refund_no','reason','refund_amount')),$params);
        $this->signature($data);
        return $this->send($data);
    }

    /**
     * 查询退款
     * @param string $out_order_no 开发者侧的订单号, 同一小程序下不可重复
     * @param string $thirdparty_id 第三方平台服务商 id，非服务商模式留空
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function queryRefund($out_order_no, $thirdparty_id='')
    {
        $this->setEndpoint('apps/ecpay/v1/query_refund');
        $data = $this->getCredentials(compact('out_order_no','thirdparty_id'));
        $this->signature($data);
        return $this->send($data);
    }

    /**
     * 结算
     * @param string $out_settle_no 开发者侧的结算号, 不可重复
     * @param string $out_order_no 商户分配订单号，标识进行结算的订单
     * @param string $settle_desc 结算描述，长度限制 80 个字符
     * @param array $paramas 更多参数
     * settle_params string 否 其他分账方信息，分账分配参数 SettleParameter 数组序列化后生成的 json 格式字符串
     * cp_extra string 否 开发者自定义字段，回调原样回传
     * notify_url string 否 商户自定义回调地址
     * thirdparty_id string 否，服务商模式接入必传 第三方平台服务商 id，非服务商模式留空
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function settle($out_settle_no, $out_order_no, $settle_desc, $paramas=[])
    {
        $this->setEndpoint('apps/ecpay/v1/settle');
        $data = $this->getCredentials(compact('out_order_no','thirdparty_id'));
        $this->signature($data);
        return $this->send($data);
    }

    /**
     * 查询分账
     * @param string $out_settle_no 开发者侧的分账号
     * @param string $thirdparty_id 第三方平台服务商 id，非服务商模式留空
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function querySettle($out_settle_no, $thirdparty_id='')
    {
        $this->setEndpoint('apps/ecpay/v1/query_settle');
        $data = $this->getCredentials(compact('out_settle_no','thirdparty_id'));
        $this->signature($data);
        return $this->send($data);
    }

    /**
     * @param string $start_date 开始时间，格式：20210603
     * @param string $end_date 结束时间，格式：20210603
     * @param string $seller 商户号
     * @param string $bill_type 账单类型，包括 payment:支付账单, settle:分账账单, refund:退款账单
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function bill($start_date, $end_date, $seller, $bill_type)
    {
        $this->setEndpoint('apps/bill');
        $data = $this->getCredentials(compact('start_date','seller','end_date','bill_type'));
        $this->signature($data);
        return $this->send($data);
    }
}
