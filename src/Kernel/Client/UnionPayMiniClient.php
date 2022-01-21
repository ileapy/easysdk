<?php

namespace easysdk\Kernel\Client;

use easysdk\Kernel\BaseContainer;
use easysdk\Kernel\Support\AcpService;
use easysdk\Kernel\Traits\HasHttpRequests;
use easysdk\Kernel\Traits\InteractsWithCache;

/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */
class UnionPayMiniClient
{
    use HasHttpRequests;
    use InteractsWithCache;

    /**
     * @var BaseContainer
     */
    protected $app;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var string
     */
    protected $endpoint = "https://open.95516.com/";

    /**
     * @var string
     */
    protected $requestMethod = 'POST';

    /**
     * @param BaseContainer $app
     */
    public function __construct(BaseContainer $app)
    {
        $this->app = $app;
        $this->config = $app['config']->toArray();
    }

    /**
     * @param $credentials
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    protected function send($credentials)
    {
        $contents = $this->requestToken($credentials);
        $result = !$contents && is_string($contents) ? AcpService::parseQString($contents) : json_decode($contents, JSON_UNESCAPED_UNICODE);

        if (empty($result) || !isset($result['resp']) || $result['resp'] != '00') return $result;

        return isset($result['params']) ? $result['params'] : $result;
    }
}