<?php

namespace App\Traits;

use App\Constants\REG;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\ApplicationContext;
use function Taoran\HyperfPackage\Helpers\get_msectime;

class Util
{

    /**
     * 构建get请求参数
     *
     * @param $params
     * @return string
     */
    public static function buildGetParams($params)
    {
        $buildParams = '';
        foreach ($params as $key => $val) {
            if ($key == 'word') {
                $val = urlencode($val);
            }
            $buildParams .= $key . '=' . $val . '&';
        }
        return trim($buildParams, '&');
    }

    /**
     * 查询指定时间范围内的所有日期，月份，季度，年份.
     *
     * @param $startDate   指定开始时间，Y-m-d格式
     * @param $endDate     指定结束时间，Y-m-d格式
     * @param $type        类型，day 天，month 月份，quarter 季度，year 年份
     * @return array
     */
    public static function getDateByInterval($startDate, $endDate, $type)
    {
        if (date('Y-m-d', strtotime($startDate)) != $startDate || date('Y-m-d', strtotime($endDate)) != $endDate) {
            return '';
        }

        $tempDate = $startDate;
        $returnData = [];
        $i = 0;
        if ($type == 'day') {    // 查询所有日期
            if (strtotime($tempDate) == strtotime($endDate)) {
                $returnData[] =  $startDate;
            } else {
                while (strtotime($tempDate) < strtotime($endDate)) {
                    $tempDate = date('Y-m-d', strtotime('+' . $i . ' day', strtotime($startDate)));
                    $returnData[] = $tempDate;
                    ++$i;
                }
            }
        } elseif ($type == 'week') { //查询所有周
            while (strtotime($tempDate) < strtotime($endDate)) {
                $temp = [];
                $idx = strftime('%u', strtotime($startDate . '+' . $i . 'day'));
                $mon_idx = $idx - 1;
                $sun_idx = $idx - 7;
                $startDate_idx = strtotime($startDate . '+' . $i . 'day') - $mon_idx * 86400 > strtotime($startDate) ? strtotime($startDate . '+' . $i . 'day') - $mon_idx * 86400 : strtotime($startDate);
                $endDate_idx = strtotime($startDate . '+' . $i . 'day') - $sun_idx * 86400 < strtotime($endDate) ? strtotime($startDate . '+' . $i . 'day') - $sun_idx * 86400 : strtotime($endDate);
                $temp['startDate'] = strftime('%Y-%m-%d', $startDate_idx);
                $temp['endDate'] = strftime('%Y-%m-%d', $endDate_idx);
                $tempDate = $temp['endDate'];
                $returnData[] = $temp;
                $i = $i + 7;
            }
        } elseif ($type == 'month') {    // 查询所有月份以及开始结束时间
            while (strtotime($tempDate) < strtotime($endDate)) {
                $temp = [];
                $month = strtotime('+' . $i . ' month', strtotime($startDate));
                $temp['name'] = date('Y-m', $month);
                $startDate_month = strtotime(date('Y-m-01', $month)) > strtotime($startDate) ? date('Y-m-01', $month) : $startDate;
                $endDate_month = strtotime(date('Y-m-t', $month)) < strtotime($endDate) ? date('Y-m-t', $month) : $endDate;
                $temp['startDate'] = $startDate_month;
                $temp['endDate'] = $endDate_month;
                $tempDate = $temp['endDate'];
                $returnData[] = $temp;
                ++$i;
            }
        } elseif ($type == 'quarter') {    // 查询所有季度以及开始结束时间
            while (strtotime($tempDate) < strtotime($endDate)) {
                $temp = [];
                $quarter = strtotime('+' . $i . ' month', strtotime($startDate));
                $q = ceil(date('n', $quarter) / 3);
                $temp['name'] = date('Y', $quarter) . '第' . $q . '季度';
                $temp['startDate'] = date('Y-m-01', mktime((int) 0, (int) 0, (int) 0, (int) ($q * 3 - 3 + 1), (int) 1, (int) (date('Y', $quarter))));
                $temp['endDate'] = date('Y-m-t', mktime((int) 23, (int) 59, (int) 59, (int) ($q * 3), (int) 1, (int) (date('Y', $quarter))));
                $tempDate = $temp['endDate'];
                $returnData[] = $temp;
                $i = $i + 3;
            }
        } elseif ($type == 'year') {    // 查询所有年份以及开始结束时间
            while (strtotime($tempDate) < strtotime($endDate)) {
                $temp = [];
                $year = strtotime('+' . $i . ' year', strtotime($startDate));
                $temp['name'] = date('Y', $year) . '年';
                $startDate_year = strtotime(date('Y-01-01', $year)) > strtotime($startDate) ? date('Y-01-01', $year) : $startDate;
                $endDate_year = strtotime(date('Y-12-31', $year)) < strtotime($endDate) ? date('Y-12-31', $year) : $endDate;
                $temp['startDate'] = $startDate_year;
                $temp['endDate'] = $endDate_year;
                $tempDate = $temp['endDate'];
                $returnData[] = $temp;
                ++$i;
            }
        }
        return $returnData;
    }

    /**
     * http请求
     *
     * @param $url
     * @param string $method
     * @param false $params
     * @return bool|string
     */
    public static function httpRequest($url, $method = 'get', $params = false, $option = false)
    {
        $httpInfo = array();
        //初始化
        $ch = curl_init();
        /*CURL_HTTP_VERSION_NONE (默认值，让 cURL 自己判断使用哪个版本)，CURL_HTTP_VERSION_1_0 (强制使用 HTTP/1.0)或CURL_HTTP_VERSION_1_1 (强制使用 HTTP/1.1)。
        */
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // 判断php版本 如果5.6+ 则含有CURLFILE 这个类 ，如果5.6-则设置如下，为解决php不同版本的问题
        if (class_exists('\CURLFile')) {
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        } else {
            if (defined('CURLOPT_SAFE_UPLOAD')) {
                curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
            }
        }

        //cookie
        if (isset($option['cookie'])) {
            curl_setopt ($ch, CURLOPT_COOKIE , $option['cookie'] );
        }

        //header
        if (isset($option['header'])) {
            $header = [];
            foreach ($option['header'] as $key => $val) {
                $headerStr = "{$key}:{$val}";
                $header[] = $headerStr;
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

//        var_dump(123123);exit;
        //在HTTP请求中包含一个"User-Agent: "头的字符串。
        curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36' );
        //尝试连接等待的时间，以毫秒为单位。设置为0，则无限等待。 如果 libcurl 编译时使用系统标准的名称解析器（ standard system name resolver），那部分的连接仍旧使用以秒计的超时解决方案，最小超时时间还是一秒钟。
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        // 允许 cURL 函数执行的最长秒数。
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        //TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //TRUE 时将会根据服务器返回 HTTP 头中的 "Location: " 重定向。（注意：这是递归的，"Location: " 发送几次就重定向几次，除非设置了 CURLOPT_MAXREDIRS，限制最大重定向次数。）。
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        //FALSE 禁止 cURL 验证对等证书（peer's certificate）。
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //设置为 1 是检查服务器SSL证书中是否存在一个公用名(common name)。译者注：公用名(Common Name)一般来讲就是填写你将要申请SSL证书的域名 (domain)或子域名(sub domain)。 设置成 2，会检查公用名是否存在，并且是否与提供的主机名匹配。 0 为不检查名称。 在生产环境中，这个值应该是 2（默认值）。
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //设置编码格式，为空表示支持所有格式的编码
        curl_setopt($ch, CURLOPT_ENCODING, '');
        if ($method == 'post') {
            // TRUE 时会发送 POST 请求，类型为：application/x-www-form-urlencoded，是 HTML 表单提交时最常见的一种。
            curl_setopt($ch, CURLOPT_POST, true);


//            $fn = fopen(trim($params['image'], '@'), 'r');
//            $fcre = curl_file_create($params['image']);
//            $params['image'] = $fcre;

            //全部数据使用HTTP协议中的 "POST" 操作来发送
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            //需要获取的 URL 地址，也可以在curl_init() 初始化会话的时候。
            curl_setopt($ch, CURLOPT_URL, $url);

//            curl_setopt($ch, CURLOPT_INFILE, $fn);
//            curl_setopt($ch, CURLOPT_INFILESIZE, 4096000);
        } else {
            if ($params) {
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }

        $response = curl_exec($ch);

        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }

    /**
     * xml to array 转换.
     * @param type $xml
     * @return type
     */
    public static function xml2array($xml)
    {
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

    /**
     * 获取客户端ip
     *
     * @param RequestInterface $request
     * @return mixed|string
     */
    public static function getClientIp()
    {
        $request = ApplicationContext::getContainer()->get(RequestInterface::class);
        $headers = $request->getHeaders();
        if(isset($headers['x-forwarded-for'][0]) && !empty($headers['x-forwarded-for'][0])) {
            return $headers['x-forwarded-for'][0];
        } elseif (isset($headers['x-real-ip'][0]) && !empty($headers['x-real-ip'][0])) {
            return $headers['x-real-ip'][0];
        }
        $serverParams = $request->getServerParams();
        return $serverParams['remote_addr'] ?? '';
    }

    /**
     * 是否手机号
     */
    public static function isPhone($phone)
    {
        return (bool)preg_match(REG::PHONE, $phone);
    }

    /**
     * 生成验证码
     * @return int
     */
    public static function getCode()
    {
        return rand(100000, 999999);
    }
}
