<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\ByteMini\auth;

use easysdk\Kernel\Client\ByteMiniClient;

/**
 * Class Client
 * @package: easysdk\ByteMini\auth
 */
class Client extends ByteMiniClient
{
    /**
     * @param string $code login 接口返回的登录凭证
     * @param string $anonymous_code login 接口返回的匿名登录凭证
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function code2Session($code='', $anonymous_code='')
    {
        $this->endpoint = "apps/v2/jscode2session";
        $appid = $this->config['appid'];
        $secret = $this->config['secret'];
        return $this->send($this->getCredentials(compact('code','anonymous_code','appid','secret')));
    }
}
