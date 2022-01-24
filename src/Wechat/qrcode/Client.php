<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\Wechat\qrcode;

use easysdk\Kernel\Client\WechatClient;

/**
 * Class Config
 *
 * @package easysdk\UnionPayMini\config
 */
class Client extends WechatClient
{
    /**
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function create()
    {
        $this->requestMethod = 'GET';
        $this->setEndpoint('cgi-bin/get_api_domain_ip');
        return $this->send();
    }
}
