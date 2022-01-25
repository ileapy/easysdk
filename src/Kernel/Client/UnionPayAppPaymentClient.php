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
class UnionPayAppPaymentClient
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
    protected $endpoint = "https://gateway.95516.com/";

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
        return $contents ? AcpService::parseQString($contents) : [];
    }

    /**
     * @param string $uri
     * @param bool $download
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    protected function setEndpoint($uri = '', $download = false)
    {
        $base_uri = $this->config['debug'] ?
            ($download ? $this->config['test_file_uri'] : $this->config['test_base_uri']) :
            ($download ? $this->config['file_uri'] : $this->config['base_uri']);

        $this->endpoint = $base_uri . $uri;
    }
}