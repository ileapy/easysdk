<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/15 23:22
 * Copyright: php
 */

namespace easysdk\ByteMini\token;

use easysdk\Kernel\Client\ByteMiniClient;

/**
 * Class AccessToken
 * @package easysdk\UnionPayMini\access
 */
class AccessToken extends ByteMiniClient
{
    /**
     * @var string
     */
    protected $endpoint = "apps/v2/token";

    /**
     * @var string
     */
    protected $tokenKey = 'access_token';

    /**
     * @var string
     */
    protected $cachePrefix = 'easysdk.bytemini.token.access_token.';

    /**
     * @param false $refresh
     * @return array|mixed
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 13:42
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function getToken($refresh = false)
    {
        $cacheKey = $this->getCacheKey();
        $cache = $this->getCache();
        $cacheItem = $cache->getItem($cacheKey);

        if (!$refresh && $cacheItem->isHit() && $result = $cacheItem->get()) {
            return $result;
        }

        $result = $this->send($this->getData());

        if (!isset($result[$this->tokenKey])) return $result;
        $this->setToken($result[$this->tokenKey],$result['expires_in'] ?: 7200);
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
    protected function setToken($token, $lifetime = 7200)
    {
        $cacheKey = $this->getCacheKey();
        $cache = $this->getCache();

        $cacheItem = $cache->getItem($cacheKey);
        $cacheItem->expiresAfter($lifetime);

        $cacheItem->set(array(
            $this->tokenKey => $token,
            'expires_in' => $lifetime
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
        return $this->cachePrefix.md5(json_encode($this->getData()));
    }

    /**
     * @return array
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 11:21
     */
    protected function getData()
    {
        return [
            'appId' => $this->config['appid'],
            'secret' => $this->config['secret'],
            'grant_type' => 'client_credential',
        ];
    }
}
