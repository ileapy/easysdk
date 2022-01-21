<?php

namespace easysdk\Kernel;

use easysdk\Kernel\Providers\ConfigProvider;
use easysdk\Kernel\Providers\HttpProvider;
use easysdk\Kernel\Providers\RequestProvider;
use Pimple\Container;

/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 *
 */
class BaseContainer extends Container
{
    /**
     * @var array
     */
    protected $providers = [];

    /**
     * @var array
     */
    protected $defaultConfig = [];

    /**
     * @var array
     */
    protected $userConfig = [];

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct();
        $this->userConfig = $config;
        $this->registerProviders($this->getProviders());
        $this->inject();
    }

    /**
     * @return array|HttpProvider[]
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    public function getProviders()
    {
        return array_merge([
            HttpProvider::class, // guzzlehttp/guzzle
            ConfigProvider::class,
            RequestProvider::class
        ], $this->providers);
    }

    /**
     * @return array
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    public function getConfig()
    {
        $baseConfig = [
            'http' => [
                'timeout' => 30.0,
                'verify' => false,
            ],
            'cache' => [
                'type' => 'File', // 默认文件缓存
            ]
        ];
        return array_replace_recursive($baseConfig, $this->defaultConfig, $this->userConfig);
    }

    /**
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    protected function inject()
    {
        foreach ($this->getConfig() as $key => $value) {
            $this['config']->set($key, $value);
        }
    }

    /**
     * @param array $providers
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/21
     */
    private function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }
}