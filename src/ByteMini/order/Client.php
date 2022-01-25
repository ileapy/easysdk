<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\ByteMini\order;

use easysdk\Kernel\Client\ByteMiniClient;

/**
 * 拍抖音黑白名单管理能力
 * Class Client
 * @package: easysdk\ByteMini\auth
 */
class Client extends ByteMiniClient
{
    /**
     * 小程序模板消息
     * @param string $client_key 生活服务订单必传	第三方在开放平台申请的 ClientKey
     * @param string $ext_shop_id 生活服务订单必传	生活服务外部商户 id，购买店铺 id
     * @param string $app_name 做订单展示的字节系 app 名称，取值枚举： 抖音-douyin
     * @param string $open_id 根据不同订单类型有不同的结构体，序列化后的字符串
     * @param string $order_detail 根据不同订单类型有不同的结构体，序列化后的字符串
     * @param int $order_type 订单类型
     * @param int $update_time 订单信息变更时间，13 位毫秒级时间戳
     * @param string $order_status 订单状态
     * @param array $params 更多参数
     * extra	string	选传	自定义字段，用于关联具体业务场景下的特殊参数
     * scene	string	选传	小程序场景值
     * location	string	选传	小程序场景值
     * launch_from	string	选传	小程序场景值
     * payment_order_no	string	接入担保支付小程序必传	订单对应担保支付平台订单号
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 19:23
     */
    public function push($client_key, $ext_shop_id, $app_name, $open_id, $order_detail, $order_type, $update_time, $order_status, $params=[])
    {
        $this->setEndpoint("apps/order/v2/push");
        $data = $this->getCredentials(array_merge(compact('client_key','ext_shop_id','app_name','open_id','order_detail','order_type','order_status','update_time'), $params));
        return $this->send($data);
    }
}
