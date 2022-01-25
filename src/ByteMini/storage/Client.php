<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\ByteMini\storage;

use easysdk\Kernel\Client\ByteMiniClient;

/**
 * Class Client
 * @package: easysdk\ByteMini\auth
 */
class Client extends ByteMiniClient
{
    /**
     * 以 key-value 形式存储用户数据到小程序平台的云存储服务。若开发者无内部存储服务则可接入，免费且无需申请。一般情况下只存储用户的基本信息，禁止写入大量不相干信息。
     * @param string $openid 登录用户唯一标识
     * @param array $kv_list (body 中) 要设置的用户数据
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function setUserStorage($openid, $session_key, $kv_list)
    {
        $sig_method = 'hmac_sha256';
        $signature = $this->app->crypto->signature(compact('kv_list'), $session_key);
        $access_token = $this->app->access_token->getToken()['access_token'];

        $this->setEndpoint('apps/set_user_storage',compact('openid','sig_method','signature','access_token'));

        return $this->send(compact('kv_list'));
    }

    /**
     * @param string $openid 登录用户唯一标识
     * @param array $key (body 中) 要删除的用户数据的 key list
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function removeUserStorage($openid, $session_key, $key)
    {
        $sig_method = 'hmac_sha256';
        $signature = $this->app->crypto->signature(compact('key'), $session_key);
        $access_token = $this->app->access_token->getToken()['access_token'];

        $this->setEndpoint('apps/set_user_storage',compact('openid','sig_method','signature','access_token'));

        return $this->send(compact('key'));
    }
}
