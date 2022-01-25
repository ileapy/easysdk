<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\ByteMini\other;

use easysdk\Kernel\Client\ByteMiniClient;

/**
 * 拍抖音黑白名单管理能力
 * Class Client
 * @package: easysdk\ByteMini\auth
 */
class Client extends ByteMiniClient
{
    /**
     * @param string $uniq_id 用户抖音号
     * @param int $type 1 黑名单增加用户 2 白名单增加用户 3 黑名单删除用户 4 白名单删除用户
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function shareConfig($uniq_id, $type)
    {
        $app_id = $this->config['appid'];
        $this->setEndpoint('apps/share_config');
        return $this->send($this->getCredentials(compact('app_id','uniq_id','type')));
    }

    /**
     * 数据获取能力
     * @param array $video_ids 要转换的 videoId 列表，最长为 100 个
     * @param string $access_key 访问密钥
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function videoIdToOpenItemId($video_ids, $access_key)
    {
        $app_id = $this->config['appid'];
        $this->setEndpoint('apps/convert_video_id/video_id_to_open_item_id');
        return $this->send($this->getCredentials(compact('app_id','video_ids','access_key')));
    }

    /**
     * 视频使用能力
     * @param array $video_ids 要转换的 item_id 列表，最长为 100 个
     * @param string $access_key 访问密钥
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function openItemIdToEncryptId($video_ids, $access_key)
    {
        $app_id = $this->config['appid'];
        $this->setEndpoint('apps/convert_video_id/open_item_id_to_encrypt_id');
        return $this->send($this->getCredentials(compact('app_id','video_ids','access_key')));
    }
}
