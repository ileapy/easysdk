<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/19 11:35
 * Copyright: php
 */

namespace easysdk\ByteMini\qrcode;

use easysdk\Kernel\Client\ByteMiniClient;

/**
 * Class Client
 * @package: easysdk\ByteMini\auth
 */
class Client extends ByteMiniClient
{
    /**
     * @param string $appname 打开二维码的字节系 app 名称
     * @param string $path 小程序/小游戏启动参数，小程序则格式为 encode({path}?{query})，小游戏则格式为 JSON 字符串，默认为空
     * @param string $width 二维码宽度，单位 px，最小 280px，最大 1280px，默认为 430px
     * @param string $line_color 二维码线条颜色，默认为黑色
     * @param string $background 二维码背景颜色，默认为白色
     * @param string $set_icon 是否展示小程序/小游戏 icon，默认不展示
     * @return array|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function create($appname='', $path='', $width = '', $line_color='', $background='', $set_icon='')
    {
        $this->setEndpoint('apps/qrcode');
        return $this->send($this->getCredentials(compact('appname','path','width','line_color','background','set_icon')));
    }
}
