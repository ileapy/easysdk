<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/15 23:22
 * Copyright: php
 */

namespace easysdk\UnionPayMini\token;

use easysdk\Kernel\Client\UnionPayMiniClient;

/**
 * Class AccessToken
 * @package easysdk\UnionPayMini\access
 */
class AccessToken extends UnionPayMiniClient
{
    /**
     * @var string
     */
    protected $endpoint = "1.0/token";

    /**
     * @var array
     */
    protected $token;

    /**
     * @var string
     */
    protected $tokenKey = 'accessToken';

    /**
     * @var string
     */
    protected $cachePrefix = 'easysdk.unionpaymini.token.access_token.';

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
    public function getToken($code = "", $refresh = false)
    {
        $this->code = $code;
        $cacheKey = $this->getCacheKey();
        $cache = $this->getCache();

        $cacheItem = $cache->getItem($cacheKey);

        if (!$refresh && $cacheItem->isHit() && $result = $cacheItem->get()) {
            return $result;
        }

        $result = $this->send($this->getCredentials());

        if (!isset($result[$this->tokenKey])) return $result;

        $this->setToken($result[$this->tokenKey], $result['openId'], $result['scope'], $result['unionId'],$result['expiresIn'] ?: 7200);

        return $result;
    }

    /**
     * @param $token
     * @param $openId
     * @param $scope
     * @param $unionId
     * @param int $lifetime
     * @return $this
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/19 10:17
     * @throws \Psr\Cache\InvalidArgumentException
     */
    protected function setToken($token, $openId, $scope, $unionId, $lifetime = 7200)
    {
        $cacheKey = $this->getCacheKey();
        $cache = $this->getCache();

        $cacheItem = $cache->getItem($cacheKey);
        $cacheItem->expiresAfter($lifetime);

        $cacheItem->set(array(
            $this->tokenKey => $token,
            'openId' => $openId,
            'scope' => $scope,
            'unionId' => $unionId,
            'expiresIn' => $lifetime
        ));

        // 保存
        $cache->save($cacheItem);

        // 保存code缓存
        $this->setCacheCode($openId, $lifetime);

        return $this;
    }

    /**
     * code缓存起来
     * @param $openId
     * @param $lifetime
     * @return $this
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 19:58
     * @throws \Psr\Cache\InvalidArgumentException
     */
    protected function setCacheCode($openId, $lifetime)
    {
        $cache = $this->getCache();

        $cacheItem = $cache->getItem(md5($openId));
        $cacheItem->expiresAfter($lifetime);

        $cacheItem->set(array(
            'code' => $this->code,
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
        return $this->cachePrefix.md5(json_encode($this->getCredentials()));
    }

    /**
     * @return array
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 11:21
     */
    protected function getCredentials()
    {
        return [
            'appId' => $this->config['appid'],
            'backendToken' => $this->app->backend_token->getToken()['backendToken'],
            'code' => $this->code,
            'grantType' => 'authorization_code',
        ];
    }
}
