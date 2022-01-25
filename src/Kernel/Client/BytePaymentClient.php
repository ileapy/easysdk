<?php

namespace easysdk\Kernel\Client;

use easysdk\Kernel\BaseContainer;
use easysdk\Kernel\Traits\HasHttpRequests;
use easysdk\Kernel\Traits\InteractsWithCache;

/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */
class BytePaymentClient
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
    protected $endpoint = "https://developer.toutiao.com/api/";

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
     * @param null $credentials 数据
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    protected function send($credentials=null)
    {
        $contents = $this->requestToken($credentials);
        $contents = $contents ? json_decode($contents, JSON_UNESCAPED_UNICODE) ?: $contents : [];
        return isset($contents['err_no']) && $contents['err_no'] == 0 && isset($contents['data']) ? $contents['data'] : $contents;
    }

    /**
     * @param $data
     * @return mixed
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    protected function getCredentials($data)
    {
        $data['app_id'] = $this->config['appid'];
        return array_filter($data);
    }

    /**
     * @param $uri
     * @param $data
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    protected function setEndpoint($uri, $data = [])
    {
        $this->endpoint = $uri . "?" . http_build_query(array_filter($data));
    }

    /**
     * @param $data
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    protected function signature(&$data)
    {
        $rList = array();
        foreach($data as $k =>$v) {
            if ($k == "other_settle_params" || $k == "app_id" || $k == "sign" || $k == "thirdparty_id")
                continue;
            $value = trim(strval($v));
            $len = strlen($value);
            if ($len > 1 && substr($value, 0,1)=="\"" && substr($value,$len, $len-1)=="\"")
                $value = substr($value,1, $len-1);
            $value = trim($value);
            if ($value == "" || $value == "null")
                continue;
            array_push($rList, $value);
        }
        array_push($rList, $this->config['salt']);
        sort($rList, 2);
        $data['sign'] = md5(implode('&', $rList));
    }

    /**
     * 验签
     * @param $data
     * @return bool
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    protected function validate($data)
    {
        $signature = $data['signature'];
        $str = $this->config['token'] . $data['timestamp'] . $data['nonce'] . $data['msg'];
        return $signature == sha1($str);
    }
}