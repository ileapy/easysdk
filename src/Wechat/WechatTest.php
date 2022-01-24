<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */

namespace easysdk\Wechat;

use easysdk\Factory;
use PHPUnit\Framework\TestCase;

/**
 * Class WechatTest
 * @package: easysdk
 */
class WechatTest extends TestCase
{
    /**
     * @var Application|null
     */
    protected $app = null;

    /**
     * @var array
     */
    public $options = [
        'appid' => 'wx035fd07c314ed3f7',
        'secret' => 'bd8b503c9d97c34e522f38c17b4f9351'
    ];

    /**
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->app = Factory::Wechat($this->options);
    }

    /**
     * token测试
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Psr\Cache\InvalidArgumentException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/22
     */
    public function testToken()
    {
        $result = $this->app->access_token->getToken(false);
        print_r($result);
        $this->assertArrayHasKey('access_token',$result);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function testBase()
    {
        $result = $this->app->base->getApiDomainIp();
        print_r($result);
        $this->assertArrayHasKey('ip_list',$result);
    }

    /**
     * 用户管理
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function testUser()
    {
        $result = $this->app->user->getUser();
        print_r($result);
        $this->assertArrayHasKey('count',$result);

        $result = $this->app->user->userInfo('o5bZq53AKZnAoQd9avKYEFcm1X3c');
        print_r($result);
        $this->assertArrayHasKey('openid',$result);

        $result = $this->app->user->updateRemark('o5bZq53AKZnAoQd9avKYEFcm1X3c','测试备注');
        print_r($result);
        $this->assertArrayHasKey('errcode',$result);
        $this->assertEquals(0,$result['errcode']);

        $result = $this->app->user->tagUser(2);
        print_r($result);
        $this->assertArrayHasKey('count',$result);
    }

    /**
     * 用户标签管理
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function testTags()
    {
        $result = $this->app->tags->get();
        print_r($result);
        $this->assertArrayHasKey('tags',$result);

        $result = $this->app->tags->create('测试标签');
        print_r($result);
        $this->assertArrayHasKey('tag',$result);

        $result = $this->app->tags->update(100,'期望客户');
        print_r($result);
        $this->assertArrayHasKey('errcode',$result);
        $this->assertEquals(0,$result['errcode']);

        $result = $this->app->tags->delete(100);
        print_r($result);
        $this->assertArrayHasKey('errcode',$result);
        $this->assertEquals(0,$result['errcode']);

        $result = $this->app->tags->getidlist('o5bZq53AKZnAoQd9avKYEFcm1X3c');
        print_r($result);
        $this->assertArrayHasKey('tagid_list',$result);

        $result = $this->app->tags->batchtagging(2,['o5bZq53AKZnAoQd9avKYEFcm1X3c']);
        print_r($result);
        $this->assertArrayHasKey('errcode',$result);
        $this->assertEquals(0,$result['errcode']);

        $result = $this->app->tags->batchuntagging(2,['o5bZq53AKZnAoQd9avKYEFcm1X3c']);
        print_r($result);
        $this->assertArrayHasKey('errcode',$result);
        $this->assertEquals(0,$result['errcode']);
    }

    /**
     * 微信二维码
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function testQrcode()
    {
        $result = $this->app->qrcode->create(1);
        print_r($result);
        $this->assertArrayHasKey('url',$result);

        $result = $this->app->qrcode->showqrcode($result['ticket']);
        print_r($result);

        $result = $this->app->qrcode->shorten('0239sRJ4BSdGD1NUwK1x1M');
        print_r($result);
        $this->assertArrayHasKey('short_key',$result);

        $result = $this->app->qrcode->fetchShorten('Agir6RJNDvNruwk');
        print_r($result);
        $this->assertArrayHasKey('errcode',$result);
    }

    /**
     * 公众号菜单
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function testMenu()
    {
        $menu = [
            'button' => array(
                array(
                    'name' => '商户',
                    'sub_button' => array(
                        array(
                            'name' => '商户登录',
                            'type' => 'view',
                            'url' => 'https://wechat.esw235.com/wechat/login/authLogin.html?redirect=http://wechat.esw235.com/MerchantImpower'
                        ),
                        array(
                            'name' => '门店登录',
                            'type' => 'view',
                            'url' => 'https://wechat.esw235.com/wechat/login/authLogin.html?redirect=http://wechat.esw235.com/StoreImpower'
                        )
                    )
                ),
                array(
                    'name' => '代理',
                    'sub_button' => array(
                        array(
                            'name' => '代理登录',
                            'type' => 'view',
                            'url' => 'https://wechat.esw235.com/AgentImpower'
                        ),
                        array(
                            'name' => '业务员登录',
                            'type' => 'view',
                            'url' => 'https://wechat.esw235.com/SalesmanLogin'
                        ),
                        array(
                            'name' => '卡券广场',
                            'type' => 'view',
                            'url' => 'https://wechat.esw235.com/coupon'
                        ),
                    )
                ),
                array(
                    'name' => '收款APP下载',
                    'type' => 'view',
                    'url' => 'https://www.esw235.com/index/app_download/index'
                )
            )
        ];
        $result = $this->app->menu->create($menu);
        print_r($result);
        $this->assertArrayHasKey('errcode',$result);

        $result = $this->app->menu->query();
        print_r($result);
        $this->assertArrayHasKey('selfmenu_info',$result);

        $result = $this->app->menu->delete();
        print_r($result);
        $this->assertArrayHasKey('errcode',$result);

        $menu = [
            'button' => array(
                array(
                    'name' => '商户',
                    'sub_button' => array(
                        array(
                            'name' => '商户登录',
                            'type' => 'view',
                            'url' => 'https://wechat.esw235.com/wechat/login/authLogin.html?redirect=http://wechat.esw235.com/MerchantImpower'
                        ),
                        array(
                            'name' => '门店登录',
                            'type' => 'view',
                            'url' => 'https://wechat.esw235.com/wechat/login/authLogin.html?redirect=http://wechat.esw235.com/StoreImpower'
                        )
                    )
                ),
                array(
                    'name' => '代理',
                    'sub_button' => array(
                        array(
                            'name' => '代理登录',
                            'type' => 'view',
                            'url' => 'https://wechat.esw235.com/AgentImpower'
                        ),
                        array(
                            'name' => '业务员登录',
                            'type' => 'view',
                            'url' => 'https://wechat.esw235.com/SalesmanLogin'
                        ),
                        array(
                            'name' => '卡券广场',
                            'type' => 'view',
                            'url' => 'https://wechat.esw235.com/coupon'
                        ),
                    )
                ),
                array(
                    'name' => '收款APP下载',
                    'type' => 'view',
                    'url' => 'https://www.esw235.com/index/app_download/index'
                )
            ),
            "matchrule" => array(
                "tag_id"=> "2",
            )
        ];

        $result = $this->app->menu->addconditional($menu);
        print_r($result);
        $this->assertArrayHasKey('menuid',$result);

        $result = $this->app->menu->delConditional('443695672');
        print_r($result);
        $this->assertArrayHasKey('errcode',$result);

        $result = $this->app->menu->tryMatch('o5bZq53AKZnAoQd9avKYEFcm1X3c');
        print_r($result);
        $this->assertArrayHasKey('menu',$result);
    }

    /**
     * 素材管理
     * @throws \GuzzleHttp\Exception\GuzzleException
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/24
     */
    public function testMaterial()
    {
        $result = $this->app->material->uploadMedia('D:\\1.jpg','image');
        print_r($result);
        $this->assertArrayHasKey('media_id',$result);

        $result = $this->app->material->getMedia('yUJH83D-ZJXHbX4l0DViigMGEiDlYtpaPDda101m7bxp6jtK3uSoRnih3M_7GmmR');
        print_r($result);

        $result = $this->app->material->uploadImg('D:\\1.jpg');
        print_r($result);
        $this->assertArrayHasKey('url',$result);

        $result = $this->app->material->addMaterial('D:\\1.mp4','video','测试视频','搞笑视频测试');
        print_r($result);
        $this->assertArrayHasKey('media_id',$result);

        $result = $this->app->material->getMaterial('JV623HV_LTDSEJsN0YLtre7q4Mk_FvL4FLKpmTXvSbo');
        print_r($result);

        $result = $this->app->material->delMaterial('JV623HV_LTDSEJsN0YLtre7q4Mk_FvL4FLKpmTXvSbo');
        print_r($result);
        $this->assertArrayHasKey('errcode',$result);

        $result = $this->app->material->getMaterialCount();
        print_r($result);
        $this->assertArrayHasKey('voice_count',$result);
        $this->assertArrayHasKey('video_count',$result);
        $this->assertArrayHasKey('image_count',$result);
        $this->assertArrayHasKey('news_count',$result);

        $result = $this->app->material->batchGetMaterial('video');
        print_r($result);
        $this->assertArrayHasKey('total_count',$result);

        $result = $this->app->material->addNews([]);
        print_r($result);

        $result = $this->app->material->updateNews('',[],0);
        print_r($result);
    }
}