<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\WechatMini\qrcode;

use easysdk\Kernel\Client\WechatMiniClient;

/**
 * Class Client
 * @package: easysdk\WechatMini\auth
 */
class Client extends WechatMiniClient
{
    /**
     * @param $path
     * @param string $width
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function createQRCode($path, $width = '')
    {
        $this->requestMethod = 'POST';
        $this->setEndpoint('cgi-bin/wxaapp/createwxaqrcode');
        return $this->send($this->getCredentials(compact('path','width')));
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

    /**
     * @param $data
     * @param bool $need_access_token
     * @return mixed
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    protected function getCredentials($data, $need_access_token = true)
    {
        $need_access_token == true && $data['access_token'] = $this->app->access_token->getToken()['access_token'];
        return array_filter($data);
    }
}
