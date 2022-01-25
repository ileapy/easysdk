<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2021/8/20 23:44
 * Copyright: php
 */

namespace easysdk\ByteMini\message;

use easysdk\Kernel\Client\ByteMiniClient;

/**
 * Class Client
 *
 * @package easysdk\ByteMini\message
 */
class Client extends ByteMiniClient
{
    /**
     * 小程序模板消息
     * @param string $tpl_id
     * @param string $open_id
     * @param array $data
     * @param string $page
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @author cfn <cfn@leapy.cn>
     * @date 2021/8/16 19:23
     */
    public function sendMessage($tpl_id, $open_id, $data, $page = '')
    {
        $app_id = $this->config['appid'];
        $this->setEndpoint("apps/subscribe_notification/developer/v1/notify");
        return $this->send($this->getCredentials(compact('tpl_id','app_id','open_id','data','page')));
    }
}
