<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/15 23:22
 * Copyright: php
 */

namespace easysdk\WechatWeb\accessToken;

use easysdk\Kernel\Client\WechatWebClient;

/**
 * Class AccessToken
 * @package easysdk\UnionPayMini\access
 */
class AccessToken extends WechatWebClient
{
    /**
     * @var string
     */
    protected $tokenKey = 'access_token';

    /**
     * @var string
     */
    protected $cachePrefix = 'easysdk.wechat.web.token.access_token.';

    /**
     * @var string
     */
    protected $code = "";

    /**
     * @param string $code
     * @param false $refresh
     * @return array|mixed
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 13:42
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getToken($code="", $refresh=false)
    {
        $this->code = $code;

        $cacheKey = $this->getCacheKey();
        $cache = $this->getCache();
        $cacheItem = $cache->getItem($cacheKey);

        if (!$refresh && $cacheItem->isHit() && $result = $cacheItem->get()) {
            return $result;
        }

        $this->requestMethod = "GET";
        $this->endpoint = "sns/oauth2/access_token?appid={$this->config['appid']}&secret={$this->config['secret']}&code={$code}&grant_type=authorization_code";
        $result = $this->send();

        if (!isset($result[$this->tokenKey])) return $result;
        $this->setToken($result,$result['expires_in'] ?: 7200);
        return $result;
    }

    /**
     * @param $token
     * @param int $lifetime
     * @return $this
     * @throws \Psr\Cache\InvalidArgumentException
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/19 10:17
     */
    protected function setToken($data, $lifetime = 7200)
    {
        $cacheKey = $this->getCacheKey();
        $cache = $this->getCache();

        $cacheItem = $cache->getItem($cacheKey);
        $cacheItem->expiresAfter($lifetime);

        $cacheItem->set(array(
            $this->tokenKey => $data[$this->tokenKey],
            'expires_in' => $data['expires_in'],
            'openId' => $data['openid'],
            'scope' => $data['scope'],
            'refresh_token'=> $data['refresh_token']
        ));

        // 保存
        $cache->save($cacheItem);

        return $this;
    }

    /**
     * @return string
     */
    protected function getCacheKey()
    {
        return $this->cachePrefix.md5(json_encode($this->getUnionKey()));
    }

    /**
     * @return array
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 11:21
     */
    protected function getUnionKey()
    {
        return [
            'appId' => $this->config['appid'],
            'secret' => $this->config['secret'],
            'code' => $this->code,
            'grantType' => 'authorization_code',
        ];
    }
}
