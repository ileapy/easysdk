<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\Wechat\material;

use easysdk\Kernel\Client\WechatClient;
use GuzzleHttp\Exception\InvalidArgumentException;

/**
 * Class Config
 *
 * @package easysdk\UnionPayMini\config
 */
class Client extends WechatClient
{
    /**
     * 临时素材上传
     * @param string $file 文件的绝对地址
     * @param string $type 媒体文件类型[image|voice|video|thumb]
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function upload($file, $type)
    {
        if (!file_exists($file)) throw new InvalidArgumentException('文件不存在！');
        if (!is_readable($file)) throw new InvalidArgumentException('文件不可读！');
        $this->setEndpoint('cgi-bin/media/upload');
        return $this->uploadFile(['multipart'=>[
            ['name' => 'type', 'contents' => $type],
            ['name' => 'media', 'contents' => fopen($file, 'r')],
        ]]);
    }
}
