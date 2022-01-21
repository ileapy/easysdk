<?php

namespace easysdk\Kernel;

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
    protected $defaultConfig = [];

    /**
     * @var array
     */
    protected $userConfig = [];

    /**
     * Constructor.
     */
    public function __construct(array $config = [])
    {
        $this->userConfig = $config;
        parent::__construct();
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $baseConfig = [
            'http' => [
                'timeout' => 30.0,
                'verify' => false,
            ],
            'cache' => [
                'type' => 'File',
            ]
        ];
        return array_replace_recursive($baseConfig, $this->defaultConfig, $this->userConfig);
    }
}