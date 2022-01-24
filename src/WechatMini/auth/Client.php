<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\WechatMini\auth;

use easysdk\Kernel\Client\WechatMiniClient;

/**
 * Class Client
 * @package: easysdk\WechatMini\auth
 */
class Client extends WechatMiniClient
{
    /**
     * @param $code
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function code2Session($code)
    {
        $this->requestMethod = 'GET';
        $this->endpoint = "sns/jscode2session?appid={$this->config['appid']}&secret={$this->config['secret']}&js_code={$code}&grant_type=authorization_code";
        return $this->send();
    }

    /**
     * 检查加密数据
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function checkEncryptedData($encrypted_msg_hash)
    {
        $this->setEndpoint('wxa/business/checkencryptedmsg',[]);
        return $this->send(compact('encrypted_msg_hash'));
    }

    /**
     * @param $openid
     * @param string $transaction_id
     * @param string $mch_id
     * @param string $out_trade_no
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function getPaidUnionId($openid, $transaction_id = '', $mch_id = '', $out_trade_no = '')
    {
        $this->requestMethod = 'GET';
        $this->setEndpoint('wxa/getpaidunionid',compact('openid','mch_id','out_trade_no','transaction_id'));
        return $this->send();
    }

    /**
     * @param $uri
     * @param $data
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    protected function setEndpoint($uri, $data = [])
    {
        $data['access_token'] = $this->app->access_token->getToken()['access_token'];
        $this->endpoint = $uri . "?" . http_build_query(array_filter($data));
    }
}
