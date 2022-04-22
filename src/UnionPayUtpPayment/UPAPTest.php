<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/21
 * Copyright: easysdk
 */

namespace easysdk\UnionPayUtpPayment;

use easysdk\Factory;
use easysdk\Kernel\Support\CertUtil;
use PHPUnit\Framework\TestCase;

/**
 * Class Test
 * @package: easysdk
 */
class UPAPTest extends TestCase
{
    /**
     * @var Application|null
     */
    protected $app = null;

    /**
     * @var array
     */
    public $options = [
        'svcId' => 'A47290439980002', // 商户编号
        'serId' => '', // 服务商Id
        'pubKey' => '',
        'priKey' => '-----BEGIN PRIVATE KEY-----
MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQDJ70Sp8SYU7Xry
T+W2ayeOwToadbzOqgt+WhzlELx+G95dZTUrwr/rgPujpjHGVjn0AoGGJj2Srbun
T0ULRAC4ztPlhLjWxxfSdWTvtvLoOhJL/3eFWlpcZhfQ2FdrIi+WKyZKiOCLgZsX
Tn/GV82vl1ibZh6Jy7XoaFC5TWvHvY0FGuULgQcArtzfJYcVtNtxTrQheQsiJ5/8
44uIYqg8988OrIDSHJQMeWNToeIWC5WcVeauGcQS3UBgvXqaK/aL4bkzy95YISjs
/ZmYrrdbWj4HcK6Xb8o0s52m6gZWpfwfh4Ao537bh5jTfsz+gG8b+nItwSEjL6+8
63y879kVAgMBAAECggEBAIL2KRrp6V+zMIRL6temoO4FRPB6ISwKvg+A07J/ay+C
VXFOvPAXiq5qZUiZ9TgDHeyxX10oGdCx2bzFPSr0PF+ey2/T5qhsUHfOaNrKVLjl
SI5/LP2QPoAkOhfY5sD1V9VVQK0gHjh7oqC36UgyE5RoXC/UR8PoGJ6UYJ38pwTP
M7twVaDtgyx9WC04HojLlxNQUexjktINGt0rDDeDJlyEA8PQSSaxpoOYhGWWN4MN
VdNdgOGitxIDVw7H+UW1ad+wCuvXlLTE4uVG3UU8JH8hu5lAJE9Fme/fxWvE0iNO
N+/xxVpyj5tlKJRbWBHsV8bylPYjoWPiWCRwY2NnP3UCgYEA6zm9VwF3muUSJNhT
jZ5zCfIPZpW+pup72KwfzEaymZIU7A0jNU1LhlUzCC++n6eHD21oYQcdzFqY0diR
UutKxueb7DLc0GmzXTfK26WSgwC65Q5VdrIh4Bairy0ecTu0dWhwY1d4OYC5biXI
kDkqZjLxmhH6UUrd4x1cUxWtvrsCgYEA28TZGbB3ZDrI3sahVVfBaZ3+Kuoq2PvO
za4luof2jW6J3RMD2nQGgFidk55C75gmeV+8sPg4ZKlMJBLWEQOaPhKLTcKfLDai
5b6k1ZiDoPwsOsX4w0en+guyiqz6Zo1KOh5PWsImBgvOxnN09Ndg+X1I+o5qtBHB
6D2SefkDEm8CgYEAgzbMRdKNs5wAyQjbYu52YZ/js2fo2BeJSk6J1lvBmSUCAsM5
VqxtatvwAasQfOLo1lRDm4xqtOn8wWI7frO+HMJqGhItVxz/bwqGYIw19Fnd55Rd
XD714pj92xYiGywg+DVwLBpI+Fq0FZuCC+G3oxbb6wQITHyk1eI09Cvtpa0CgYBA
IgjM419kA3ec81AfbJWHsdB7S4ynd4xZH2npLkY37bsTpbnpJRTEnZeWfYfBDaCk
qNiSuE0UqwcKO+j2XBvF43l9fr8eku8kpmbJ4lD/SLfLivxWWHHfmUxIBcSo6rBv
l2rG7INWHloANa86yCOHixUh8S+YTtpMYLN/HrjTxwKBgQDB4N1bCjCJBQaJz2hl
VQOqMX3qARSjmMa5WMgDCBEBjh7B+95U4TSKAaTPNYw0c4pug9hipN8CzXBa579k
y0iwP++vZHOjuMUaHumVMUmk0Ydilb5Hv3mmg38MveDM7W1Fqja0cGXsjDmLtvaA
Pt/qaqZnBOeXQj6U7WMEdQ/BfQ==
-----END PRIVATE KEY-----
',
        'debug' => true, // 支付模式，true为测试环境，false为生产环境，默认false
    ];

    /**
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->app = Factory::UnionPayUtpPayment($this->options);
    }

    /**
     * 订单
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/25
     */
    public function testUserId()
    {
//        $result = $this->app->auth->redirectUrl("https://www.baidu.com/");
//        $this->assertEquals("https://qr.95516.com/qrcGtwWeb-web/api/userAuth?version=1.0.2&redirectUrl=https%3A%2F%2Fwww.baidu.com%2F",$result);

        $result = $this->app->auth->userId("123213");
        var_dump($result);
    }
}
