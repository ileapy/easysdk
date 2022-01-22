<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/15 23:22
 * Copyright: php
 */

namespace easysdk\UnionPayMini\token;

use easysdk\Kernel\Client\UnionPayMiniClient;
use easysdk\Kernel\Support\Str;

/**
 * Class FrontToken
 * @package easysdk\UnionPayMini\access
 */
class FrontToken extends UnionPayMiniClient
{
    /**
     * @var string
     */
    protected $endpoint = "1.0/frontToken";

    /**
     * @var array
     */
    protected $token;

    /**
     * @var string
     */
    protected $tokenKey = 'frontToken';

    /**
     * @var string
     */
    protected $cachePrefix = 'easysdk.miniprogram.access.front_token.';

    /**
     * @param false $refresh
     * @return array|mixed
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 19:19
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

        $result = $this->send($this->getCredentials());

        if (!isset($result[$this->tokenKey])) return $result;

        $this->setToken($result[$this->tokenKey], $result['expiresIn'] ?: 0);
        return $cacheItem->get();
    }

    /**
     * @param string $token
     * @param int $lifetime
     * @return $this
     * @throws \Exception|\Psr\Cache\InvalidArgumentException
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 10:35
     */
    protected function setToken($token, $lifetime = 7200)
    {
        $cacheKey = $this->getCacheKey();
        $cache = $this->getCache();

        $cacheItem = $cache->getItem($cacheKey);
        $cacheItem->expiresAfter($lifetime);

        $cacheItem->set(array(
            $this->tokenKey => $token,
            'expiresIn' => $lifetime
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
        return $this->cachePrefix.md5(json_encode($this->config));
    }

    /**
     * @return array
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 11:21
     */
    protected function getCredentials()
    {
        $nonceStr = Str::nonceStr();
        $timestamp = time();
        return [
            'appId' => $this->config['appid'],
            'nonceStr' => $nonceStr,
            'timestamp' => $timestamp,
            'signature' => Str::signature(['appId' => $this->config['appid'], 'nonceStr' => $nonceStr, 'secret' => $this->config['secret'], 'timestamp' => $timestamp])
        ];
    }
}
