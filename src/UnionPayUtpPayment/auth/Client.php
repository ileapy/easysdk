<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 21:35
 * Copyright: php
 */

namespace easysdk\UnionPayUtpPayment\auth;

use easysdk\Kernel\Client\UnionPayUtpPaymentClient;

/**
 * Class Client
 * Author: cfn <cfn@leapy.cn>
 * Date 2022/4/20
 */
class Client extends UnionPayUtpPaymentClient
{
    /**
     * redirectUrl 跳转地址
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/4/20
     * @param $url
     * @return string
     */
    public function redirectUrl($url)
    {
        return "https://qr.95516.com/qrcGtwWeb-web/api/userAuth?version=1.0.2&redirectUrl=" . urlencode($url);
    }

    /**
     * userId 获取用户id
     * Author: cfn <cfn@leapy.cn>
     * Date 2022/4/20
     * @param string $user_auth_code 银联授权码
     * @param string $transTp 银联支付标识收款方识别
     * @param string $subTransTp
     * @param string $app_up_identifier
     * @return array|mixed
     */
    public function userId($user_auth_code, $transTp='01', $subTransTp='0162',  $app_up_identifier = "UnionPay/1.0 CloudPay")
    {
        $data = [
            'svcApi' => 'up.fpsd.trade.utp.userid.get',
            'transTp' => $transTp,
            'subTransTp' => $subTransTp,
            'user_auth_code' => $user_auth_code,
            'app_up_identifier' => $app_up_identifier
        ];
        $res = $this->send($data);
        if (!$this->verify($res)) return ['code'=>1,'msg'=>'验签失败'];
        return $res;
    }
}
