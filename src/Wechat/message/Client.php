<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\Wechat\message;

use easysdk\Kernel\Client\WechatClient;
use easysdk\Kernel\Support\Xml;

/**
 * Class Config
 *
 * @package easysdk\UnionPayMini\config
 */
class Client extends WechatClient
{
    /**
     * 文本信息
     * @param $openid
     * @param string $content 消息内容
     * @return string
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/26
     */
    public function text($openid, $content)
    {
        return Xml::arrToXml([
            'ToUserName' => $openid,
            'FromUserName' => $this->config['wechat_id'],
            'CreateTime' => time(),
            'MsgType' => 'text',
            'Content' => $content
        ]);
    }

    /**
     * 图片信息
     * @param $openid
     * @param $media_id
     * @return string
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/26
     */
    public function image($openid, $media_id)
    {
        return Xml::arrToXml([
            'ToUserName' => $openid,
            'FromUserName' => $this->config['wechat_id'],
            'CreateTime' => time(),
            'MsgType' => 'image',
            'Image' => [
                'MediaId' => $media_id
            ]
        ]);
    }

    /**
     * 语音消息
     * @param $openid
     * @param $media_id
     * @return string
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/26
     */
    public function voice($openid, $media_id)
    {
        return Xml::arrToXml([
            'ToUserName' => $openid,
            'FromUserName' => $this->config['wechat_id'],
            'CreateTime' => time(),
            'MsgType' => 'voice',
            'Voice' => [
                'MediaId' => $media_id
            ]
        ]);
    }

    /**
     * 音乐消息
     * @param string $openid
     * @param string $ThumbMediaId
     * @param string $title
     * @param string $description
     * @param string $musicURL
     * @param string $HQMusicUrl
     * @return string
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/26
     */
    public function music($openid, $ThumbMediaId, $title='', $description='', $musicURL='', $HQMusicUrl='')
    {
        return Xml::arrToXml([
            'ToUserName' => $openid,
            'FromUserName' => $this->config['wechat_id'],
            'CreateTime' => time(),
            'MsgType' => 'music',
            'Music' => [
                'Title' => $title,
                'Description' => $description,
                'MusicURL' => $musicURL,
                'HQMusicUrl' => $HQMusicUrl,
                'ThumbMediaId' => $ThumbMediaId,
            ]
        ]);
    }

    /**
     * 视频信息
     * @param $openid
     * @param $media_id
     * @param $title
     * @param $description
     * @return string
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/26
     */
    public function video($openid, $media_id, $title='', $description='')
    {
        return Xml::arrToXml([
            'ToUserName' => $openid,
            'FromUserName' => $this->config['wechat_id'],
            'CreateTime' => time(),
            'MsgType' => 'video',
            'Video' => [
                'MediaId' => $media_id,
                'Title' => $title,
                'Description' => $description
            ]
        ]);
    }

    /**
     * 视频信息
     * @param $openid
     * @param string $title
     * @param string $description
     * @param string $picUrl
     * @param string $url
     * @param int $articleCount
     * @return string
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/26
     */
    public function news($openid, $title, $description, $picUrl, $url, $articleCount=1)
    {
        return Xml::arrToXml([
            'ToUserName' => $openid,
            'FromUserName' => $this->config['wechat_id'],
            'CreateTime' => time(),
            'MsgType' => 'news',
            'ArticleCount' => $articleCount,
            'Articles' => [
                'item' => [
                    'Title' => $title,
                    'Description' => $description,
                    'PicUrl' => $picUrl,
                    'Url' => $url
                ]
            ]
        ]);
    }
}
