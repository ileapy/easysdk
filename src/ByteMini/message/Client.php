<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/20 23:44
 * Copyright: php
 */

namespace easysdk\ByteMini\message;

use easysdk\Kernel\Client\ByteMiniClient;

/**
 * Class Client
 *
 * @package easysdk\ByteMini\message
 */
class Client extends ByteMiniClient
{
    /**
     * 小程序模板消息
     * @param string $tpl_id
     * @param string $open_id
     * @param array $data
     * @param string $page
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 19:23
     */
    public function sendMessage($tpl_id, $open_id, $data, $page = '')
    {
        $app_id = $this->config['appid'];
        $this->setEndpoint("apps/subscribe_notification/developer/v1/notify");
        return $this->send($this->getCredentials(compact('tpl_id','app_id','open_id','data','page')));
    }

    /**
     * 小程序模板消息
     * @param $client_key
     * @param $ext_shop_id
     * @param $app_name
     * @param $order_detail
     * @param $order_type
     * @param $update_time
     * @param $order_status
     * @param $extra
     * @param $scene
     * @param $location
     * @param $launch_from
     * @param $payment_order_no
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 19:23
     */
    public function order($client_key, $ext_shop_id, $app_name, $order_detail, $order_type, $update_time, $order_status, $extra,$scene,$location,$launch_from ,$payment_order_no)
    {
        $app_id = $this->config['appid'];
        $access_token = $this->app->access_token->getToken()['access_token'];
        $this->setEndpoint("apps/order/v2/push");
        return $this->send($this->getCredentials(compact('tpl_id','app_id','open_id','data','page')));
    }
}
