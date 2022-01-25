<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/20 23:45
 * Copyright: php
 */

namespace easysdk\ByteMini\secure;

use easysdk\Kernel\Client\ByteMiniClient;
use GuzzleHttp\Exception\InvalidArgumentException;

/**
 * Class Client
 *
 * @package easysdk\ByteMini\secure
 */
class Client extends ByteMiniClient
{
    /**
     * @param array $contents 检测的文本内容数组
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function text($contents)
    {
        $tasks = [];
        if (empty($contents) || !is_array($contents)) throw new InvalidArgumentException('参数必须是非空数组！');
        foreach ($contents as $content) $tasks[] = compact('content');
        $this->setHeaders(['X-Token'=>$this->app->access_token->getToken()['access_token']]);
        $this->setEndpoint('v2/tags/text/antidirt');
        return $this->send(compact('tasks'));
    }

    /**
     * @param string $image 检测的图片链接|图片数据的 base64 格式
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function image($image)
    {
        $app_id = $this->config['appid'];
        $image_data = '';
        $pattern = "/http[s]?:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is";
        if (!preg_match($pattern,$image))
        {
            $image_data = $image;
            $image = '';
        }
        $this->setEndpoint('apps/censor/image');
        return $this->send($this->getCredentials(compact('app_id','image','image_data')));
    }
}
