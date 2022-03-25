<?php
/**
 * User: cfn <cfn@leapy.cn>
 * Datetime: 2022/1/26
 * Copyright: easysdk
 */

namespace easysdk\Kernel\Support;

/**
 * Class Xml
 * @package: easysdk\Kernel\Support
 */
class Xml
{
    /**
     * xml转数组
     * @param $xml
     * @return array|mixed
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/26
     */
    public static function xmlToArr($xml)
    {
        if (empty($xml)) return [];
        $obj = simplexml_load_string($xml,"SimpleXMLElement", LIBXML_NOCDATA);
        return json_decode(json_encode($obj),true);
    }

    /**
     * 数组转xml
     * @param $arr
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/26
     */
    public static function arrToXml($arr)
    {
        if (!is_array($arr)) return '';
        $xml  ='<xml>';
        $xml .= self::toXml($arr);
        $xml .= '</xml>';
        return $xml;
    }

    /**
     * @param $arr
     * @return string
     * Author cfn <cfn@leapy.cn>
     * Date 2022/1/26
     */
    protected static function toXml($arr)
    {
        $string = "";
        foreach($arr as $k=>$v){
            $string .="<".$k.">";
            if(is_array($v) || is_object($v)){
                $string .= self::toXml($v);
            }else{
                $string .=$v;
            }
            $string .="</".$k.">";
        }
        return $string;
    }
}