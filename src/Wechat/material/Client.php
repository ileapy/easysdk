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
    public function uploadMedia($file, $type)
    {
        if (!file_exists($file)) throw new InvalidArgumentException('文件不存在！');
        if (!is_readable($file)) throw new InvalidArgumentException('文件不可读！');
        $this->setEndpoint('cgi-bin/media/upload');
        return $this->uploadFile(['multipart'=>[
            ['name' => 'type', 'contents' => $type],
            ['name' => 'media', 'contents' => fopen($file, 'r')],
        ]]);
    }

    /**
     * 上传临时素材
     * @param string $media_id 	媒体文件ID
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function getMedia($media_id)
    {
        $this->requestMethod = 'GET';
        $this->setEndpoint('cgi-bin/media/get',compact('media_id'));
        return $this->send();
    }

    /**
     * 上传图文消息内的图片获取URL
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function uploadImg($file)
    {
        if (!file_exists($file)) throw new InvalidArgumentException('文件不存在！');
        if (!is_readable($file)) throw new InvalidArgumentException('文件不可读！');
        $this->setEndpoint('cgi-bin/media/uploadimg');
        return $this->uploadFile(['multipart'=>[
            ['name' => 'media', 'contents' => fopen($file, 'r')],
        ]]);
    }

    /**
     * 永久素材上传
     * @param string $file 文件的绝对地址
     * @param string $type 媒体文件类型[image|voice|video|thumb]
     * @param string $title
     * @param string $introduction
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function addMaterial($file, $type, $title='', $introduction='')
    {
        if (!file_exists($file)) throw new InvalidArgumentException('文件不存在！');
        if (!is_readable($file)) throw new InvalidArgumentException('文件不可读！');
        $this->setEndpoint('cgi-bin/material/add_material');

        $data['multipart'] = [
            ['name' => 'type', 'contents' => $type],
            ['name' => 'media', 'contents' => fopen($file, 'r')]
        ];

        // 视频素材
        if ($type == 'video')
            $data['multipart'][] = ['name' => 'description', 'contents' => json_encode(compact('title','introduction'),JSON_UNESCAPED_UNICODE)];

        return $this->uploadFile($data);
    }

    /**
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function getMaterial($media_id)
    {
        $this->setEndpoint('cgi-bin/material/get_material');
        return $this->send(self::getCredentials(compact('media_id')));
    }

    /**
     * @param $media_id
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function delMaterial($media_id)
    {
        $this->setEndpoint('cgi-bin/material/del_material');
        return $this->send(self::getCredentials(compact('media_id')));
    }

    /**
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function getMaterialCount()
    {
        $this->requestMethod = 'GET';
        $this->setEndpoint('cgi-bin/material/get_materialcount');
        return $this->send();
    }

    /**
     * @param string $type 素材的类型，图片（image）、视频（video）、语音 （voice）、图文（news）
     * @param int $offset 从全部素材的该偏移位置开始返回，0表示从第一个素材 返回
     * @param int $count 返回素材的数量，取值在1到20之间
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function batchGetMaterial($type, $offset = 0, $count = 20)
    {
        $this->setEndpoint('cgi-bin/material/batchget_material');
        return $this->send($this->getCredentials(compact('type','offset','count')));
    }

    /**
     * 新政图文信息
     * @param array $articles 图文素材
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function addNews($articles)
    {
        $this->setEndpoint('cgi-bin/material/add_news');
        return $this->send($articles);
    }

    /**
     * 更新图文信息
     * @param string $media_id 要修改的图文消息的id
     * @param array $article 要更新的文章在图文消息中的位置（多图文消息时，此字段才有意义），第一篇为0
     * @param int $index
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function updateNews($media_id, $article, $index = 0)
    {
        $this->setEndpoint('cgi-bin/material/update_news');
        return $this->send(compact('media_id','article','index'));
    }
}
