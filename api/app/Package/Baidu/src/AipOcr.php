<?php
/*
* Copyright (c) 2017 Baidu.com, Inc. All Rights Reserved
*
* Licensed under the Apache License, Version 2.0 (the "License"); you may not
* use this file except in compliance with the License. You may obtain a copy of
* the License at
*
* Http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
* WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
* License for the specific language governing permissions and limitations under
* the License.
*/
namespace App\Package\Baidu\src;


use App\Package\Baidu\src\lib\AipBase;

class AipOcr extends AipBase
{
    /**
     * @var string
     */
    private $medical_detailUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/medical_detail';

    /**
     * @var string
     */
    private $weight_noteUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/weight_note';

    /**
     * @var string
     */
    private $online_taxi_itineraryUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/online_taxi_itinerary';


    /**
     * 通用文字识别 general_basic api url
     * @var string
     */
    private $generalBasicUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/general_basic';

    /**
     * 通用文字识别（高精度版） accurate_basic api url
     * @var string
     */
    private $accurateBasicUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/accurate_basic';

    /**
     * 通用文字识别（含位置信息版） general api url
     * @var string
     */
    private $generalUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/general';

    /**
     * 通用文字识别（含位置高精度版） accurate api url
     * @var string
     */
    private $accurateUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/accurate';

    /**
     * 通用文字识别（含生僻字版） general_enhanced api url
     * @var string
     */
    private $generalEnhancedUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/general_enhanced';

    /**
     * 网络图片文字识别 web_image api url
     * @var string
     */
    private $webImageUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/webimage';

    /**
     * 身份证识别 idcard api url
     * @var string
     */
    private $idcardUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/idcard';

    /**
     * 银行卡识别 bankcard api url
     * @var string
     */
    private $bankcardUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/bankcard';

    /**
     * 驾驶证识别 driving_license api url
     * @var string
     */
    private $drivingLicenseUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/driving_license';

    /**
     * 行驶证识别 vehicle_license api url
     * @var string
     */
    private $vehicleLicenseUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/vehicle_license';

    /**
     * 车牌识别 license_plate api url
     * @var string
     */
    private $licensePlateUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/license_plate';

    /**
     * 营业执照识别 business_license api url
     * @var string
     */
    private $businessLicenseUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/business_license';

    /**
     * 通用票据识别 receipt api url
     * @var string
     */
    private $receiptUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/receipt';

    /**
     * 火车票识别 train_ticket api url
     * @var string
     */
    private $trainTicketUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/train_ticket';

    /**
     * 出租车票识别 taxi_receipt api url
     * @var string
     */
    private $taxiReceiptUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/taxi_receipt';

    /**
     * 表格文字识别同步接口 form api url
     * @var string
     */
    private $formUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/form';

    /**
     * 表格文字识别 table_recognize api url
     * @var string
     */
    private $tableRecognizeUrl = 'https://aip.baidubce.com/rest/2.0/solution/v1/form_ocr/request';

    /**
     * 表格识别结果 table_result_get api url
     * @var string
     */
    private $tableResultGetUrl = 'https://aip.baidubce.com/rest/2.0/solution/v1/form_ocr/get_request_result';

    /**
     * VIN码识别 vin_code api url
     * @var string
     */
    private $vinCodeUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/vin_code';

    /**
     * 定额发票识别 quota_invoice api url
     * @var string
     */
    private $quotaInvoiceUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/quota_invoice';

    /**
     * 户口本识别 household_register api url
     * @var string
     */
    private $householdRegisterUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/household_register';

    /**
     * 港澳通行证识别 HK_Macau_exitentrypermit api url
     * @var string
     */
    private $HKMacauExitentrypermitUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/HK_Macau_exitentrypermit';

    /**
     * 台湾通行证识别 taiwan_exitentrypermit api url
     * @var string
     */
    private $taiwanExitentrypermitUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/taiwan_exitentrypermit';

    /**
     * 出生医学证明识别 birth_certificate api url
     * @var string
     */
    private $birthCertificateUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/birth_certificate';

    /**
     * 机动车销售发票识别 vehicle_invoice api url
     * @var string
     */
    private $vehicleInvoiceUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/vehicle_invoice';

    /**
     * 车辆合格证识别 vehicle_certificate api url
     * @var string
     */
    private $vehicleCertificateUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/vehicle_certificate';

    /**
     * 税务局通用机打发票识别 invoice api url
     * @var string
     */
    private $invoiceUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/invoice';

    /**
     * 行程单识别 air_ticket api url
     * @var string
     */
    private $airTicketUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/air_ticket';

    /**
     * 保单识别 insurance_documents api url
     * @var string
     */
    private $insuranceDocumentsUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/insurance_documents';

    /**
     * 增值税发票识别 vat_invoice api url
     * @var string
     */
    private $vatInvoiceUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/vat_invoice';

    /**
     * 二维码识别 qrcode api url
     * @var string
     */
    private $qrcodeUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/qrcode';

    /**
     * 数字识别 numbers api url
     * @var string
     */
    private $numbersUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/numbers';

    /**
     * 彩票识别 lottery api url
     * @var string
     */
    private $lotteryUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/lottery';

    /**
     * 护照识别 passport api url
     * @var string
     */
    private $passportUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/passport';

    /**
     * 名片识别 business_card api url
     * @var string
     */
    private $businessCardUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/business_card';

    /**
     * 手写文字识别 handwriting api url
     * @var string
     */
    private $handwritingUrl = 'https://aip.baidubce.com/rest/2.0/ocr/v1/handwriting';

    /**
     * 自定义模板文字识别 custom api url
     * @var string
     */
    private $customUrl = 'https://aip.baidubce.com/rest/2.0/solution/v1/iocr/recognise';

    /**
     * 文档版面分析与识别
     * @var string
     */
    private $docAnalysis = "https://aip.baidubce.com/rest/2.0/ocr/v1/doc_analysis";

    /**
     * 仪器仪表盘读数识别
     * @var string
     */
    private $meter = "https://aip.baidubce.com/rest/2.0/ocr/v1/meter";

    /**
     * 网络图片文字识别（含位置版）
     * @var string
     */
    private $webimageLoc = "https://aip.baidubce.com/rest/2.0/ocr/v1/webimage_loc";

    /**
     * @var string 印章识别
     */
    private $sealRecognizeUrl = "https://aip.baidubce.com/rest/2.0/ocr/v1/seal";

    /**
     * @var string 办公文档识别
     */
    private $docAnalysisOfficeUrl = "https://aip.baidubce.com/rest/2.0/ocr/v1/doc_analysis_office";

    /**
     * @var string IOCE财会版
     */
    private $iOcrRecogniseFinanceV1Url = "https://aip.baidubce.com/rest/2.0/solution/v1/iocr/recognise/finance";

    /**
     * @var string 汽车票识别
     */
    private $busTicketV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/bus_ticket";

    /**
     * @var string 过路过桥费发票识别
     */
    private $tollInvoiceV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/toll_invoice";

    /**
     * @var string 多卡证类别检测
     */
    private $multiCardClassifyV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/multi_card_classify";

    /**
     * @var string 智能结构化识别
     */
    private $intelligentOcrV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/intelligent_ocr";

    /**
     * @var string 病案首页识别
     */
    private $medicalRecordV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/medical_record";

    /**
     * @var string 医疗费用结算单识别
     */
    private $medicalStatementV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/medical_statement";


    /**
     * @var string 船票识别
     */
    private $ferryTicketV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/ferry_ticket";

    /**
     * @var string 二手车销售发票识别
     */
    private $usedVehicleInvoiceV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/used_vehicle_invoice";

    /**
     * @var string 身份证混贴识别
     */
    private $multiIdcardV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/multi_idcard";


    /**
     * @var string 通信行程卡识别
     */
    private $travelCardV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/travel_card";

    /**
     * @var string 社保卡识别
     */
    private $socialSecurityCardV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/social_security_card";

    /**
     * @var string 医疗检验报告单识别
     */
    private $medicalReportDetectionV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/medical_report_detection";


    /**
     * @var string 医疗票据类别检测
     */
    private $medicalReciptsClassifyV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/medical_recipts_classify";

    /**
     * @var string 快递面单识别
     */
    private $waybillV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/waybill";

    /**
     * @var string 出院小结识别
     */
    private $medicalSummaryV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/medical_summary";

    /**
     * @var string 购物小票识别
     */
    private $shoppingReceiptV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/shopping_receipt";


    /**
     * @var string 道路运输证识别
     */
    private $roadTransportCertificateV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/road_transport_certificate";

    /**
     * @var string 表格文字识别V2
     */
    private $tableV1Url = "https://aip.baidubce.com/rest/2.0/ocr/v1/table";

    /**
     * @var string 文档去手写
     */
    private $removeHandwritingUrl = "https://aip.baidubce.com/rest/2.0/ocr/v1/remove_handwriting";

    /**
     * @var string 文档矫正增强
     */
    private $docCropEnhanceUrl = "https://aip.baidubce.com/rest/2.0/ocr/v1/doc_crop_enhance";

    /**
     * @var string 健康码识别
     */
    private $healthCodeUrl = "https://aip.baidubce.com/rest/2.0/ocr/v1/health_code";

    /**
     * @var string 核酸证明识别
     */
    private $covidTestUrl = "https://aip.baidubce.com/rest/2.0/ocr/v1/covid_test";

    /**
     * @var string 处方笺识别
     */
    private $medicalPrescriptionUrl = "https://aip.baidubce.com/rest/2.0/ocr/v1/medical_prescription";

    /**
     * @var string 门诊病历识别
     */
    private $medicalOutpatientUrl = "https://aip.baidubce.com/rest/2.0/ocr/v1/medical_outpatient";

    /**
     * @var string 诊断证明识别
     */
    private $medicalSummaryDiagnosisUrl = "https://aip.baidubce.com/rest/2.0/ocr/v1/medical_summary_diagnosis";

    /**
     * @var string 医疗诊断报告单识别
     */
    private $healthReportUrl = "https://aip.baidubce.com/rest/2.0/ocr/v1/health_report";

    /**
     * 通用文字识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   language_type 识别语言类型，默认为CHN_ENG。可选值包括：<br>- CHN_ENG：中英文混合；<br>- ENG：英文；<br>- POR：葡萄牙语；<br>- FRE：法语；<br>- GER：德语；<br>- ITA：意大利语；<br>- SPA：西班牙语；<br>- RUS：俄语；<br>- JAP：日语；<br>- KOR：韩语；
     *   detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:<br>- true：检测朝向；<br>- false：不检测朝向。
     *   detect_language 是否检测语言，默认不检测。当前支持（中文、英语、日语、韩语）
     *   probability 是否返回识别结果中每一行的置信度
     * @return array
     */
    public function basicGeneral($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->generalBasicUrl, $data);
    }

    /**
     * 通用文字识别接口
     *
     * @param string $url - 图片完整URL，URL长度不超过1024字节，URL对应的图片base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式，当image字段存在时url字段失效
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   language_type 识别语言类型，默认为CHN_ENG。可选值包括：<br>- CHN_ENG：中英文混合；<br>- ENG：英文；<br>- POR：葡萄牙语；<br>- FRE：法语；<br>- GER：德语；<br>- ITA：意大利语；<br>- SPA：西班牙语；<br>- RUS：俄语；<br>- JAP：日语；<br>- KOR：韩语；
     *   detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:<br>- true：检测朝向；<br>- false：不检测朝向。
     *   detect_language 是否检测语言，默认不检测。当前支持（中文、英语、日语、韩语）
     *   probability 是否返回识别结果中每一行的置信度
     * @return array
     */
    public function basicGeneralUrl($url, $options = array())
    {

        $data = array();

        $data['url'] = $url;

        $data = array_merge($data, $options);

        return $this->request($this->generalBasicUrl, $data);
    }

    /**
     * 通用文字识别（高精度版）接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:<br>- true：检测朝向；<br>- false：不检测朝向。
     *   probability 是否返回识别结果中每一行的置信度
     * @return array
     */
    public function basicAccurate($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->accurateBasicUrl, $data);
    }

    /**
     * 通用文字识别（含位置信息版）接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   recognize_granularity 是否定位单字符位置，big：不定位单字符位置，默认值；small：定位单字符位置
     *   language_type 识别语言类型，默认为CHN_ENG。可选值包括：<br>- CHN_ENG：中英文混合；<br>- ENG：英文；<br>- POR：葡萄牙语；<br>- FRE：法语；<br>- GER：德语；<br>- ITA：意大利语；<br>- SPA：西班牙语；<br>- RUS：俄语；<br>- JAP：日语；<br>- KOR：韩语；
     *   detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:<br>- true：检测朝向；<br>- false：不检测朝向。
     *   detect_language 是否检测语言，默认不检测。当前支持（中文、英语、日语、韩语）
     *   vertexes_location 是否返回文字外接多边形顶点位置，不支持单字位置。默认为false
     *   probability 是否返回识别结果中每一行的置信度
     * @return array
     */
    public function general($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->generalUrl, $data);
    }

    /**
     * 通用文字识别（含位置信息版）接口
     *
     * @param string $url - 图片完整URL，URL长度不超过1024字节，URL对应的图片base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式，当image字段存在时url字段失效
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   recognize_granularity 是否定位单字符位置，big：不定位单字符位置，默认值；small：定位单字符位置
     *   language_type 识别语言类型，默认为CHN_ENG。可选值包括：<br>- CHN_ENG：中英文混合；<br>- ENG：英文；<br>- POR：葡萄牙语；<br>- FRE：法语；<br>- GER：德语；<br>- ITA：意大利语；<br>- SPA：西班牙语；<br>- RUS：俄语；<br>- JAP：日语；<br>- KOR：韩语；
     *   detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:<br>- true：检测朝向；<br>- false：不检测朝向。
     *   detect_language 是否检测语言，默认不检测。当前支持（中文、英语、日语、韩语）
     *   vertexes_location 是否返回文字外接多边形顶点位置，不支持单字位置。默认为false
     *   probability 是否返回识别结果中每一行的置信度
     * @return array
     */
    public function generalUrl($url, $options = array())
    {

        $data = array();

        $data['url'] = $url;

        $data = array_merge($data, $options);

        return $this->request($this->generalUrl, $data);
    }

    /**
     * 通用文字识别（含位置高精度版）接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   recognize_granularity 是否定位单字符位置，big：不定位单字符位置，默认值；small：定位单字符位置
     *   detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:<br>- true：检测朝向；<br>- false：不检测朝向。
     *   vertexes_location 是否返回文字外接多边形顶点位置，不支持单字位置。默认为false
     *   probability 是否返回识别结果中每一行的置信度
     * @return array
     */
    public function accurate($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->accurateUrl, $data);
    }

    /**
     * 通用文字识别（含生僻字版）接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   language_type 识别语言类型，默认为CHN_ENG。可选值包括：<br>- CHN_ENG：中英文混合；<br>- ENG：英文；<br>- POR：葡萄牙语；<br>- FRE：法语；<br>- GER：德语；<br>- ITA：意大利语；<br>- SPA：西班牙语；<br>- RUS：俄语；<br>- JAP：日语；<br>- KOR：韩语；
     *   detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:<br>- true：检测朝向；<br>- false：不检测朝向。
     *   detect_language 是否检测语言，默认不检测。当前支持（中文、英语、日语、韩语）
     *   probability 是否返回识别结果中每一行的置信度
     * @return array
     */
    public function enhancedGeneral($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->generalEnhancedUrl, $data);
    }

    /**
     * 通用文字识别（含生僻字版）接口
     *
     * @param string $url - 图片完整URL，URL长度不超过1024字节，URL对应的图片base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式，当image字段存在时url字段失效
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   language_type 识别语言类型，默认为CHN_ENG。可选值包括：<br>- CHN_ENG：中英文混合；<br>- ENG：英文；<br>- POR：葡萄牙语；<br>- FRE：法语；<br>- GER：德语；<br>- ITA：意大利语；<br>- SPA：西班牙语；<br>- RUS：俄语；<br>- JAP：日语；<br>- KOR：韩语；
     *   detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:<br>- true：检测朝向；<br>- false：不检测朝向。
     *   detect_language 是否检测语言，默认不检测。当前支持（中文、英语、日语、韩语）
     *   probability 是否返回识别结果中每一行的置信度
     * @return array
     */
    public function enhancedGeneralUrl($url, $options = array())
    {

        $data = array();

        $data['url'] = $url;

        $data = array_merge($data, $options);

        return $this->request($this->generalEnhancedUrl, $data);
    }

    /**
     * 网络图片文字识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:<br>- true：检测朝向；<br>- false：不检测朝向。
     *   detect_language 是否检测语言，默认不检测。当前支持（中文、英语、日语、韩语）
     * @return array
     */
    public function webImage($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->webImageUrl, $data);
    }

    /**
     * 网络图片文字识别接口
     *
     * @param string $url - 图片完整URL，URL长度不超过1024字节，URL对应的图片base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式，当image字段存在时url字段失效
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:<br>- true：检测朝向；<br>- false：不检测朝向。
     *   detect_language 是否检测语言，默认不检测。当前支持（中文、英语、日语、韩语）
     * @return array
     */
    public function webImageUrl($url, $options = array())
    {

        $data = array();

        $data['url'] = $url;

        $data = array_merge($data, $options);

        return $this->request($this->webImageUrl, $data);
    }

    /**
     * 身份证识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param string $idCardSide - front：身份证含照片的一面；back：身份证带国徽的一面
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:<br>- true：检测朝向；<br>- false：不检测朝向。
     *   detect_risk 是否开启身份证风险类型(身份证复印件、临时身份证、身份证翻拍、修改过的身份证)功能，默认不开启，即：false。可选值:true-开启；false-不开启
     * @return array
     */
    public function idcard($image, $idCardSide, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);
        $data['id_card_side'] = $idCardSide;

        $data = array_merge($data, $options);

        return $this->request($this->idcardUrl, $data);
    }

    /**
     * 银行卡识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function bankcard($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->bankcardUrl, $data);
    }

    /**
     * 驾驶证识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:<br>- true：检测朝向；<br>- false：不检测朝向。
     * @return array
     */
    public function drivingLicense($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->drivingLicenseUrl, $data);
    }

    /**
     * 行驶证识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:<br>- true：检测朝向；<br>- false：不检测朝向。
     *   accuracy normal 使用快速服务，1200ms左右时延；缺省或其它值使用高精度服务，1600ms左右时延
     * @return array
     */
    public function vehicleLicense($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->vehicleLicenseUrl, $data);
    }

    /**
     * 车牌识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   multi_detect 是否检测多张车牌，默认为false，当置为true的时候可以对一张图片内的多张车牌进行识别
     * @return array
     */
    public function licensePlate($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->licensePlateUrl, $data);
    }

    /**
     * 营业执照识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function businessLicense($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->businessLicenseUrl, $data);
    }

    /**
     * 通用票据识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   recognize_granularity 是否定位单字符位置，big：不定位单字符位置，默认值；small：定位单字符位置
     *   probability 是否返回识别结果中每一行的置信度
     *   accuracy normal 使用快速服务，1200ms左右时延；缺省或其它值使用高精度服务，1600ms左右时延
     *   detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:<br>- true：检测朝向；<br>- false：不检测朝向。
     * @return array
     */
    public function receipt($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->receiptUrl, $data);
    }

    /**
     * 火车票识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function trainTicket($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->trainTicketUrl, $data);
    }

    /**
     * 火车票识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function trainTicketUrl($image, $options = array())
    {

        $data = array();

        $data['url'] = $image;

        $data = array_merge($data, $options);

        return $this->request($this->trainTicketUrl, $data);
    }

    /**
     * 出租车票识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function taxiReceipt($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->taxiReceiptUrl, $data);
    }

    /**
     * 出租车票识别接口
     *
     * @param string $url - 图片完整URL，URL长度不超过1024字节，URL对应的图片base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式，当image字段存在时url字段失效
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function taxiReceiptUrl($image, $options = array())
    {

        $data = array();

        $data['url'] = $image;

        $data = array_merge($data, $options);

        return $this->request($this->taxiReceiptUrl, $data);
    }

    /**
     * 表格文字识别同步接口接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function form($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->formUrl, $data);
    }

    /**
     * 表格文字识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function tableRecognitionAsync($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->tableRecognizeUrl, $data);
    }

    /**
     * 表格识别结果接口
     *
     * @param string $requestId - 发送表格文字识别请求时返回的request id
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   result_type 期望获取结果的类型，取值为“excel”时返回xls文件的地址，取值为“json”时返回json格式的字符串,默认为”excel”
     * @return array
     */
    public function getTableRecognitionResult($requestId, $options = array())
    {

        $data = array();

        $data['request_id'] = $requestId;

        $data = array_merge($data, $options);

        return $this->request($this->tableResultGetUrl, $data);
    }

    /**
     * VIN码识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function vinCode($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->vinCodeUrl, $data);
    }

    /**
     * VIN码识别接口
     * @param string $url - 图片完整URL，URL长度不超过1024字节，URL对应的图片base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式，当image字段存在时url字段失效
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function vinCodeUrl($image, $options = array())
    {

        $data = array();

        $data['url'] = $image;

        $data = array_merge($data, $options);

        return $this->request($this->vinCodeUrl, $data);
    }

    /**
     * 定额发票识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function quotaInvoice($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->quotaInvoiceUrl, $data);
    }

    /**
     * 户口本识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function householdRegister($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->householdRegisterUrl, $data);
    }

    /**
     * 港澳通行证识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function HKMacauExitentrypermit($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->HKMacauExitentrypermitUrl, $data);
    }

    /**
     * 台湾通行证识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function taiwanExitentrypermit($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->taiwanExitentrypermitUrl, $data);
    }

    /**
     * 出生医学证明识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function birthCertificate($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->birthCertificateUrl, $data);
    }

    /**
     * 机动车销售发票识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function vehicleInvoice($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->vehicleInvoiceUrl, $data);
    }

    /**
     * 车辆合格证识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function vehicleCertificate($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->vehicleCertificateUrl, $data);
    }

    /**
     * 税务局通用机打发票识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   location 是否输出位置信息，true：输出位置信息，false：不输出位置信息，默认false
     * @return array
     */
    public function invoice($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->invoiceUrl, $data);
    }

    /**
     * 行程单识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   location 是否输出位置信息，true：输出位置信息，false：不输出位置信息，默认false
     * @return array
     */
    public function airTicket($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->airTicketUrl, $data);
    }

    /**
     * 保单识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   rkv_business 是否进行商业逻辑处理，rue：进行商业逻辑处理，false：不进行商业逻辑处理，默认true
     * @return array
     */
    public function insuranceDocuments($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->insuranceDocumentsUrl, $data);
    }

    /**
     * 增值税发票识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function vatInvoice($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->vatInvoiceUrl, $data);
    }

    /**
     * 增值税发票识别接口
     *
     * @param string $url - 图片完整URL，URL长度不超过1024字节，URL对应的图片base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式，当image字段存在时url字段失效
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   string type 进行识别的增值税发票类型，默认为 normal，可缺省
     *           - normal：可识别增值税普票、专票、电子发票
     *           - roll：可识别增值税卷票
     * @return array
     */
    public function vatInvoiceUrl($url, $options = array())
    {

        $data = array();

        $data['url'] = $url;

        $data = array_merge($data, $options);

        return $this->request($this->vatInvoiceUrl, $data);
    }

    /**
     * 增值税发票识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表
     *   string type 进行识别的增值税发票类型，默认为 normal，可缺省
     *           - normal：可识别增值税普票、专票、电子发票
     *           - roll：可识别增值税卷票
     * @return array
     */
    public function vatInvoicePdf($pdfFile, $options = array())
    {

        $data = array();

        $data['pdf_file'] = base64_encode($pdfFile);

        $data = array_merge($data, $options);

        return $this->request($this->vatInvoiceUrl, $data);
    }

    /**
     * 二维码识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function qrcode($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->qrcodeUrl, $data);
    }

    /**
     * 数字识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   recognize_granularity 是否定位单字符位置，big：不定位单字符位置，默认值；small：定位单字符位置
     *   detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:<br>- true：检测朝向；<br>- false：不检测朝向。
     * @return array
     */
    public function numbers($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->numbersUrl, $data);
    }

    /**
     * 彩票识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   recognize_granularity 是否定位单字符位置，big：不定位单字符位置，默认值；small：定位单字符位置
     * @return array
     */
    public function lottery($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->lotteryUrl, $data);
    }

    /**
     * 护照识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function passport($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->passportUrl, $data);
    }

    /**
     * 名片识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function businessCard($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->businessCardUrl, $data);
    }

    /**
     * 手写文字识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   recognize_granularity 是否定位单字符位置，big：不定位单字符位置，默认值；small：定位单字符位置
     * @return array
     */
    public function handwriting($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->handwritingUrl, $data);
    }

    /**
     * 自定义模板文字识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   templateSign 您在自定义文字识别平台制作的模板的ID
     *   classifierId 分类器Id。这个参数和templateSign至少存在一个，优先使用templateSign。存在templateSign时，表示使用指定模板；如果没有templateSign而有classifierId，表示使用分类器去判断使用哪个模板
     * @return array
     */
    public function custom($image, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->customUrl, $data);
    }

    /**
     * 同步请求
     * @param string $image 图像读取
     * @param options 接口可选参数
     * @return array
     */
    public function tableRecognition($image, $options = array(), $timeout = 10000)
    {
        $result = $this->tableRecognitionAsync($image);
        if (isset($result['error_code'])) {
            return $result;
        }
        $requestId = $result['result'][0]['request_id'];
        $count = ceil($timeout / 1000);
        for ($i = 0; $i < $count; $i++) {
            $result = $this->getTableRecognitionResult($requestId, $options);
            // 完成
            if ($result['result']['ret_code'] == 3) {
                break;
            }
            sleep(1);
        }
        return $result;
    }

    /**
     * 文档版面分析与识别
     *
     * @param string $image
     * @param string $languageType
     * @param string $resultType
     * @param bool $detectDirection
     * @param bool $lineProbability
     * @param null $wordsType
     * @param null $layoutAnalysis
     * @param array $options
     * @return bool|mix|mixed|string|string[]
     */
    public function docAnalysis($image, $languageType, $resultType, $options = array())
    {

        $data = array();

        $data['image'] = base64_encode($image);

        if ($languageType == null || in_array($languageType, array('CHN_ENG', 'ENG')) <> 1) {
            return "please provide correct param: language_type ";
        }
        $data['language_type'] = $languageType;

        if ($resultType == null || in_array($resultType, array('big', 'small')) <> 1) {
            return "please provide correct param: result_type ";
        }
        $data['result_type'] = $resultType;

        $data = array_merge($data, $options);

        return $this->request($this->docAnalysis, $data);
    }

    /**
     * 仪器仪表盘读数识别
     *
     * @param string $image
     * @param bool $probability
     * @param bool $polyLocation
     * @param array|options $
     * @return bool|mix|mixed|string[]
     */
    public function meter($image, $options = array())
    {
        $data = array();
        $data['image'] = base64_encode($image);
        $data = array_merge($data, $options);
        return $this->request($this->meter, $data);
    }

    /**
     * 网络图片文字识别（含位置版）
     *
     * @param string $image
     * @param bool $detect_direction
     * @param bool $probability
     * @param bool $poly_location
     * @param null $recognize_granularity
     * @param array $options
     * @return string
     */
    public function webimageLoc($image, $options = array())
    {
        $data = array();
        $data['image'] = base64_encode($image);
        $data = array_merge($data, $options);
        return $this->request($this->webimageLoc, $data);
    }

    /**
     * 二维码识别
     * 对图片中的二维码、条形码进行检测和识别，返回存储的文字信息
     *
     * @param url  图片完整URL
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function qrcodeUrl($url, $options = array())
    {

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->qrcodeUrl, $data);
    }


    /**
     * 试卷分析与识别
     * 支持对车辆合格证的个关键字段进行结构化识别
     *
     * @param url  图片完整URL
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   multi_detect 控制是否开启多航班信息识别功能,默认值：false
     * @return array
     */
    public function docAnalysisUrl($url, $options = array())
    {

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->docAnalysis, $data);
    }


    /**
     * 机动车销售发票
     * 支持对机动车销售发票的个关键字段进行结构化识别，
     *
     * @param url  图片完整URL
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function vehicleInvoiceUrl($url, $options = array())
    {

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->vehicleInvoiceUrl, $data);
    }


    /**
     * 车辆合格证
     * 支持对车辆合格证的个关键字段进行结构化识别，包括合格证编号、发证日期、车辆制造企业名、车辆品牌、车辆名称、车辆型号、车架号、
     * 车身颜色、发动机型号、发动机号、燃料种类、排量、功率、排放标准、轮胎数、轴距、轴数、转向形式、总质量、整备质量、驾驶室准乘人数、
     * 最高设计车速、车辆制造日期
     *
     * @param url  图片完整URL
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   language_type 识别语言类型，默认为CHN_ENG
     *   result_type 返回识别结果是按单行结果返回，还是按单字结果返回，默认为big
     *   detect_direction 是否检测图像朝向，默认不检测，即：false
     *   line_probability 是否返回每行识别结果的置信度。默认为false
     *   words_type 文字类型。
     * @return array
     */
    public function vehicleCertificateUrl($url, $options = array())
    {

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->vehicleCertificateUrl, $data);
    }


    /**
     * 户口本识别
     * 支持对户口本内常住人口登记卡的全部  个字段进行结构化识别，
     *
     * @param url  图片完整URL
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function householdRegisterUrl($url, $options = array())
    {

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->householdRegisterUrl, $data);
    }


    /**
     * 手写文字识别
     * 支持对图片中的手写中文、手写数字进行检测和识别，
     *
     * @param url  图片完整URL
     * 0         * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   recognize_granularity 是否定位单字符位置，
     *   probability 是否返回识别结果中每一行的置信度，默认为false，不返回置信度
     *   detect_direction 是否检测图像朝向，默认不检测，即：false
     * @return array
     */
    public function handwritingUrl($url, $options = array())
    {

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->handwritingUrl, $data);
    }


    /**
     * 飞机行程单识别
     * 支持对飞机行程单的个字段进行结构化识别，包括电子客票号、印刷序号、姓名、始发站、目的站、航班号、日期、时间、票价、身份证号、
     * 承运人、民航发展基金、保险费、燃油附加费、其他税费、合计金额、填开日期、订票渠道、客票级别、座位等级、销售单位号、签注、免费行李、
     * 验证码。 同时，支持单张行程单上的多航班信息识别。
     *
     * @param url  图片完整URL
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   multi_detect 控制是否开启多航班信息识别功能,默认值：false
     * @return array
     */
    public function airTicketUrl($url, $options = array())
    {

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->airTicketUrl, $data);
    }


    /**
     * 通用机打发票
     * 支持对图片中的手写中文、手写数字进行检测和识别，
     *
     * @param url  图片完整URL
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   location 是否输出位置信息，true：输出位置信息，false：不输出位置信息，默认false
     * @return array
     */
    public function invoiceUrl($url, $options = array())
    {

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->invoiceUrl, $data);
    }


    /**
     * 护照识别
     * 支持对图片中的手写中文、手写数字进行检测和识别，
     *
     * @param url  图片完整URL
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function passportUrl($url, $options = array())
    {

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->passportUrl, $data);
    }

    /**
     * 网约车行程单识别
     * 对各大主要服务商的网约车行程单进行结构化识别，包括滴滴打车、花小猪打车、高德地图、曹操出行、阳光出行，支持识别服务商、
        行程开始时间、行程结束时间、车型、总金额等16 个关键字段。
    
     *
     * @param image  二进制图像数据
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   pdf_file_num 需要识别的PDF文件的对应页码，当 pdf_file 参数有效时，识别传入页码的对应页面内容，若不传入，则默认识别第 1 页
     * @return array
     */
    public function onlineTaxiItinerary($image){

        $data = array();

        $data['image'] = base64_encode($image);

        return $this->request($this->online_taxi_itineraryUrl, $data);
    }


    /**
     * 网约车行程单识别
     * 对各大主要服务商的网约车行程单进行结构化识别，包括滴滴打车、花小猪打车、高德地图、曹操出行、阳光出行，支持识别服务商、
        行程开始时间、行程结束时间、车型、总金额等16 个关键字段。
    
     *
     * @param url  图片完整URL路径
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   pdf_file_num 需要识别的PDF文件的对应页码，当 pdf_file 参数有效时，识别传入页码的对应页面内容，若不传入，则默认识别第 1 页
     * @return array
     */
    public function onlineTaxiItineraryUrl($url){

        $data = array();

        $data['url'] = $url;

        return $this->request($this->online_taxi_itineraryUrl, $data);
    }


    /**
     * 网约车行程单识别
     * 对各大主要服务商的网约车行程单进行结构化识别，包括滴滴打车、花小猪打车、高德地图、曹操出行、阳光出行，支持识别服务商、
        行程开始时间、行程结束时间、车型、总金额等16 个关键字段。
    
     *
     * @param pdf_file  pdf文件二进制数据
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   pdf_file_num 需要识别的PDF文件的对应页码，当 pdf_file 参数有效时，识别传入页码的对应页面内容，若不传入，则默认识别第 1 页
     * @return array
     */
    public function onlineTaxiItineraryPdf($pdf_file, $options=array()){

        $data = array();

        $data = array_merge($data, $options);
        $data['pdf_file'] = base64_encode($pdf_file);

        return $this->request($this->online_taxi_itineraryUrl, $data);
    }


    /**
     * 磅单识别
     * 结构化识别磅单的车牌号、打印时间、毛重、皮重、净重、发货单位、收货单位、单号8个关键字段，现阶段仅支持识别印刷体磅单
     *
     * @param image  二进制图像数据
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   pdf_file_num 需要识别的PDF文件的对应页码，当 pdf_file 参数有效时，识别传入页码的对应页面内容，若不传入，则默认识别第 1 页
     *   probability 是否返回字段识别结果的置信度，默认为 false，可缺省
                - false：不返回字段识别结果的置信度
                - true：返回字段识别结果的置信度，包括字段识别结果中各字符置信度的平均值（average）和最小值（min）
            
     * @return array
     */
    public function weightNote($image, $options=array()){

        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->weight_noteUrl, $data);
    }


    /**
     * 磅单识别
     * 结构化识别磅单的车牌号、打印时间、毛重、皮重、净重、发货单位、收货单位、单号8个关键字段，现阶段仅支持识别印刷体磅单
     *
     * @param url  图片完整URL路径
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   pdf_file_num 需要识别的PDF文件的对应页码，当 pdf_file 参数有效时，识别传入页码的对应页面内容，若不传入，则默认识别第 1 页
     *   probability 是否返回字段识别结果的置信度，默认为 false，可缺省
                - false：不返回字段识别结果的置信度
                - true：返回字段识别结果的置信度，包括字段识别结果中各字符置信度的平均值（average）和最小值（min）
     * @return array
     */
    public function weightNoteUrl($url, $options=array()){

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->weight_noteUrl, $data);
    }


    /**
     * 磅单识别
     * 结构化识别磅单的车牌号、打印时间、毛重、皮重、净重、发货单位、收货单位、单号8个关键字段，现阶段仅支持识别印刷体磅单
     * @param pdf_file  图片完整URL路径
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   pdf_file_num 需要识别的PDF文件的对应页码，当 pdf_file 参数有效时，识别传入页码的对应页面内容，若不传入，则默认识别第 1 页
     *   probability 是否返回字段识别结果的置信度，默认为 false，可缺省
                - false：不返回字段识别结果的置信度
                - true：返回字段识别结果的置信度，包括字段识别结果中各字符置信度的平均值（average）和最小值（min）
     * @return array
     */
    public function weightNotePdf($pdf_file, $options=array()){

        $data = array();

        $data = array_merge($data, $options);
        $data['pdf_file'] = base64_encode($pdf_file);

        return $this->request($this->weight_noteUrl, $data);
    }


    /**
     * 医疗费用明细识别
     * 支持识别全国医疗费用明细的姓名、日期、病人ID、总金额等关键字段，支持识别费用明细项目清单，包含项目类型、项目名称、
        单价、数量、规格、金额，其中北京地区识别效果最佳。
     * @param image  二进制图像数据
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   location 是否返回字段的位置信息，默认为 false，可缺省
                - false：不返回字段位置信息
                - true：返回字段的位置信息，包括上边距（top）、左边距（left）、宽度（width）、高度（height）
     *   probability 是否返回字段识别结果的置信度，默认为 false，可缺省
                - false：不返回字段识别结果的置信度
                - true：返回字段识别结果的置信度，包括字段识别结果中各字符置信度的平均值（average）和最小值（min）
     * @return array
     */
    public function medicalDetail($image, $options=array()){

        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->medical_detailUrl, $data);
    }


    /**
     * 医疗费用明细识别
     * 支持识别全国医疗费用明细的姓名、日期、病人ID、总金额等关键字段，支持识别费用明细项目清单，包含项目类型、项目名称、
        单价、数量、规格、金额，其中北京地区识别效果最佳。
     * @param url  图片完整URL路径
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   location 是否返回字段的位置信息，默认为 false，可缺省
                - false：不返回字段位置信息
                - true：返回字段的位置信息，包括上边距（top）、左边距（left）、宽度（width）、高度（height）
     *   probability 是否返回字段识别结果的置信度，默认为 false，可缺省
                - false：不返回字段识别结果的置信度
                - true：返回字段识别结果的置信度，包括字段识别结果中各字符置信度的平均值（average）和最小值（min）
     * @return array
     */
    public function medicalDetailUrl($url, $options=array()){

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->medical_detailUrl, $data);
    }


    /**
     * 印章识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return array
     */
    public function sealRecognize($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->sealRecognizeUrl, $data);
    }

    /**
     * 印章识别
     * @param $url: 图片完整URL路径
     * @param $options: 可选参数对象，key: value都为string类型
     * @return array
     */
    public function sealRecognizeUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->sealRecognizeUrl, $data);
    }


    /**
     * 印章识别
     * @param $pdfFile: pdf
     * @param $options: 可选参数对象，key: value都为string类型
     * @return array
     */
    public function sealRecognizePdf($pdfFile, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['pdf_file'] = base64_encode($pdfFile);

        return $this->request($this->sealRecognizeUrl, $data);
    }

    /**
     * 办公文档识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function docAnalysisOffice($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->docAnalysisOfficeUrl, $data);
    }

    /**
     * 办公文档识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function docAnalysisOfficeUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->docAnalysisOfficeUrl, $data);
    }

    /**
     * 办公文档识别
     * @param $pdf: pdf
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function docAnalysisOfficePdf($pdfFile, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['pdf_file'] = base64_encode($pdfFile);

        return $this->request($this->docAnalysisOfficeUrl, $data);
    }

    /**
     * iocr财会版
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function customFinance($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->iOcrRecogniseFinanceV1Url, $data);
    }

    /**
     * iocr财会版
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function customFinanceUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->iOcrRecogniseFinanceV1Url, $data);
    }

    /**
     * iocr财会版
     * @param $pdf: pdf
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function customFinancePdf($pdfFile, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['pdf_file'] = base64_encode($pdfFile);

        return $this->request($this->iOcrRecogniseFinanceV1Url, $data);
    }

    /**
     * 汽车票识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function busTicket($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->busTicketV1Url, $data);
    }

    /**
     * 汽车票识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function busTicketUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->busTicketV1Url, $data);
    }

    /**
     * 过路过桥费发票识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function tollInvoice($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->tollInvoiceV1Url, $data);
    }

    /**
     * 过路过桥费发票识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function tollInvoiceUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->tollInvoiceV1Url, $data);
    }

    /**
     * 多卡证类别检测
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function multiCardClassify($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->multiCardClassifyV1Url, $data);
    }

    /**
     * 多卡证类别检测
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function multiCardClassifyUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->multiCardClassifyV1Url, $data);
    }

    /**
     * 智能结构化识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function intelligentOcr($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->intelligentOcrV1Url, $data);
    }

    /**
     * 智能结构化识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function intelligentOcrUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->intelligentOcrV1Url, $data);
    }

    /**
     * 病案首页识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalRecord($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->medicalRecordV1Url, $data);
    }

    /**
     * 病案首页识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalRecordUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->medicalRecordV1Url, $data);
    }

    /**
     * 医疗费用结算单识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalStatement($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->medicalStatementV1Url, $data);
    }

    /**
     * 医疗费用结算单识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalStatementUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->medicalStatementV1Url, $data);
    }

    /**
     * 船票识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function ferryTicket($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->ferryTicketV1Url, $data);
    }

    /**
     * 船票识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function ferryTicketUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->ferryTicketV1Url, $data);
    }

    /**
     * 二手车销售发票识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function usedVehicleInvoice($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->usedVehicleInvoiceV1Url, $data);
    }

    /**
     * 二手车销售发票识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function usedVehicleInvoiceUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->usedVehicleInvoiceV1Url, $data);
    }

    /**
     * 身份证混贴识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function multiIdcard($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->multiIdcardV1Url, $data);
    }

    /**
     * 身份证混贴识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function multiIdcardUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->multiIdcardV1Url, $data);
    }

    /**
     * 通信行程卡识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function travelCard($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->travelCardV1Url, $data);
    }

    /**
     * 社保卡识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function socialSecurityCard($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->socialSecurityCardV1Url, $data);
    }

    /**
     * 社保卡识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function socialSecurityCardUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->socialSecurityCardV1Url, $data);
    }

    /**
     * 医疗检验报告单识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalReportDetection($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->medicalReportDetectionV1Url, $data);
    }

    /**
     * 医疗检验报告单识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalReportDetectionUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->medicalReportDetectionV1Url, $data);
    }

    /**
     * 医疗票据类别检测
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalReciptsClassify($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->medicalReciptsClassifyV1Url, $data);
    }

    /**
     * 医疗票据类别检测
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalReciptsClassifyUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->medicalReciptsClassifyV1Url, $data);
    }

    /**
     * 快递面单识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function waybill($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->waybillV1Url, $data);
    }

    /**
     * 快递面单识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function waybillUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->waybillV1Url, $data);
    }

    /**
     * 出院小结识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalSummary($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->medicalSummaryV1Url, $data);
    }

    /**
     * 出院小结识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalSummaryUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->medicalSummaryV1Url, $data);
    }


    /**
     * 购物小票识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function shoppingReceipt($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->shoppingReceiptV1Url, $data);
    }

    /**
     * 购物小票识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function shoppingReceiptUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->shoppingReceiptV1Url, $data);
    }

    /**
     * 购物小票识别
     * @param $pdf: pdf
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function shoppingReceiptPdf($pdfFile, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['pdf_file'] = base64_encode($pdfFile);

        return $this->request($this->shoppingReceiptV1Url, $data);
    }

    /**
     * 道路运输证识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function roadTransportCertificate($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->roadTransportCertificateV1Url, $data);
    }

    /**
     * 道路运输证识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function roadTransportCertificateUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->roadTransportCertificateV1Url, $data);
    }

    /**
     * 道路运输证识别
     * @param $pdf: pdf
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function roadTransportCertificatePdf($pdfFile, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['pdf_file'] = base64_encode($pdfFile);

        return $this->request($this->roadTransportCertificateV1Url, $data);
    }

    /**
     * 表格文字识别V2
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function table($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->tableV1Url, $data);
    }

    /**
     * 表格文字识别V2
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function tableUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->tableV1Url, $data);
    }

    /**
     * 表格文字识别V2
     * @param $pdf: pdf
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function tablePdf($pdfFile, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['pdf_file'] = base64_encode($pdfFile);

        return $this->request($this->tableV1Url, $data);
    }

    /**
     * 文档去手写
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function removeHandwriting($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->removeHandwritingUrl, $data);
    }

    /**
     * 文档去手写
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function removeHandwritingUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->removeHandwritingUrl, $data);
    }

    /**
     * 文档去手写
     * @param $pdf: pdf
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function removeHandwritingPdf($pdfFile, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['pdf_file'] = base64_encode($pdfFile);

        return $this->request($this->removeHandwritingUrl, $data);
    }

    /**
     * 文档矫正增强
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function docCropEnhance($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->docCropEnhanceUrl, $data);
    }

    /**
     * 文档矫正增强
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function docCropEnhanceUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->docCropEnhanceUrl, $data);
    }

    /**
     * 文档矫正增强
     * @param $pdf: pdf
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function docCropEnhancePdf($pdfFile, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['pdf_file'] = base64_encode($pdfFile);

        return $this->request($this->docCropEnhanceUrl, $data);
    }

    /**
     * 健康码识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function healthCode($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->healthCodeUrl, $data);
    }

    /**
     * 核酸证明识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function covidTest($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->covidTestUrl, $data);
    }

    /**
     * 处方笺识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalPrescription($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->medicalPrescriptionUrl, $data);
    }

    /**
     * 处方笺识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalPrescriptionUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->medicalPrescriptionUrl, $data);
    }

    /**
     * 门诊病历识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalOutpatient($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->medicalOutpatientUrl, $data);
    }

    /**
     * 门诊病历识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalOutpatientUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->medicalOutpatientUrl, $data);
    }

    /**
     * 诊断证明识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalSummaryDiagnosis($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->medicalSummaryDiagnosisUrl, $data);
    }

    /**
     * 诊断证明识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function medicalSummaryDiagnosisUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->medicalSummaryDiagnosisUrl, $data);
    }

    /**
     * 医疗诊断报告单识别
     * @param $image: 二进制图像数据
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function healthReport($image, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->healthReportUrl, $data);
    }

    /**
     * 医疗诊断报告单识别
     * @param $url: 图像url
     * @param $options: 可选参数对象，key: value都为string类型
     * @return void
     */
    public function healthReportUrl($url, $options=array()) {
        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->healthReportUrl, $data);
    }
}