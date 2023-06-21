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
class AipImageClassify extends AipBase {

    /**
     * @var string
     */
    private $traffic_flowUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/traffic_flow';

    /**
     * @var string
     */
    private $vehicle_segUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/vehicle_seg';

    /**
     * @var string
     */
    private $vehicle_detect_highUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/vehicle_detect_high';

    /**
     * @var string
     */
    private $vehicle_attrUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/vehicle_attr';

    /**
     * 通用物体识别 advanced_general api url
     * @var string
     */
    private $advancedGeneralUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v2/advanced_general';

    /**
     * 菜品识别 dish_detect api url
     * @var string
     */
    private $dishDetectUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v2/dish';

    /**
     * 车辆识别 car_detect api url
     * @var string
     */
    private $carDetectUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/car';

    /**
     * 车辆检测 vehicle_detect api url
     * @var string
     */
    private $vehicleDetectUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/vehicle_detect';

    /**
     * 车辆外观损伤识别 vehicle_damage api url
     * @var string
     */
    private $vehicleDamageUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/vehicle_damage';

    /**
     * logo商标识别 logo_search api url
     * @var string
     */
    private $logoSearchUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v2/logo';

    /**
     * logo商标识别—添加 logo_add api url
     * @var string
     */
    private $logoAddUrl = 'https://aip.baidubce.com/rest/2.0/realtime_search/v1/logo/add';

    /**
     * logo商标识别—删除 logo_delete api url
     * @var string
     */
    private $logoDeleteUrl = 'https://aip.baidubce.com/rest/2.0/realtime_search/v1/logo/delete';

    /**
     * 动物识别 animal_detect api url
     * @var string
     */
    private $animalDetectUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/animal';

    /**
     * 植物识别 plant_detect api url
     * @var string
     */
    private $plantDetectUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/plant';

    /**
     * 图像主体检测 object_detect api url
     * @var string
     */
    private $objectDetectUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/object_detect';

    /**
     * 地标识别 landmark api url
     * @var string
     */
    private $landmarkUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/landmark';

    /**
     * 花卉识别 flower api url
     * @var string
     */
    private $flowerUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/flower';

    /**
     * 食材识别 ingredient api url
     * @var string
     */
    private $ingredientUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/classify/ingredient';

    /**
     * 红酒识别 redwine api url
     * @var string
     */
    private $redwineUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/redwine';

    /**
     * 货币识别 currency api url
     * @var string
     */
    private $currencyUrl = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/currency';

    /**
     * 菜品识别-添加
     * @var string
     */
    private $customDishAddUrl = "https://aip.baidubce.com/rest/2.0/image-classify/v1/realtime_search/dish/add";
    /**
     * 菜品识别-搜索
     * @var string
     */
    private $customDishSearchUrl = "https://aip.baidubce.com/rest/2.0/image-classify/v1/realtime_search/dish/search";
    /**
     * 菜品识别-删除
     * @var string
     */
    private $customDishDeleteUrl = "https://aip.baidubce.com/rest/2.0/image-classify/v1/realtime_search/dish/delete";
    /**
     * 多目标识别
     * @var string
     */
    private $multiObjectDetectUrl = "https://aip.baidubce.com/rest/2.0/image-classify/v1/multi_object_detect";
    /**
     * 组合接口
     * @var string
     */
    private $combinationUrl = "https://aip.baidubce.com/api/v1/solution/direct/imagerecognition/combination";

    private $redwineAddV1Url = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/realtime_search/redwine/add';
    private $redwineSearchV1Url = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/realtime_search/redwine/search';
    private $redwineDeleteV1Url = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/realtime_search/redwine/delete';
    private $redwineUpdateV1Url = 'https://aip.baidubce.com/rest/2.0/image-classify/v1/realtime_search/redwine/update';
    private $vehicleAttrClassifyV2Url = 'https://aip.baidubce.com/rest/2.0/image-classify/v2/vehicle_attr';



    /**
     * 通用物体识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   baike_num 返回百科信息的结果数，默认不返回
     * @return array
     */
    public function advancedGeneral($image, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->advancedGeneralUrl, $data);
    }

    /**
     * 菜品识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   top_num 返回预测得分top结果数，默认为5
     *   filter_threshold 默认0.95，可以通过该参数调节识别效果，降低非菜识别率.
     *   baike_num 返回百科信息的结果数，默认不返回
     * @return array
     */
    public function dishDetect($image, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->dishDetectUrl, $data);
    }

    /**
     * 车辆识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   top_num 返回预测得分top结果数，默认为5
     *   baike_num 返回百科信息的结果数，默认不返回
     * @return array
     */
    public function carDetect($image, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->carDetectUrl, $data);
    }

    /**
     * 车辆检测接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   show 是否返回结果图（含统计值和跟踪框）。选true时返回渲染后的图片(base64)，其它无效值或为空则默认false。
     *   area 只统计该区域内的车辆数，缺省时为全图统计。<br>逗号分隔，如‘x1,y1,x2,y2,x3,y3...xn,yn'，按顺序依次给出每个顶点的x、y坐标（默认尾点和首点相连），形成闭合多边形区域。<br>服务会做范围（顶点左边需在图像范围内）及个数校验（数组长度必须为偶数，且大于3个顶点）。只支持单个多边形区域，建议设置矩形框，即4个顶点。**坐标取值不能超过图像宽度和高度，比如1280的宽度，坐标值最大到1279**。
     * @return array
     */
    public function vehicleDetect($image, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->vehicleDetectUrl, $data);
    }

    /**
     * 车辆外观损伤识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function vehicleDamage($image, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->vehicleDamageUrl, $data);
    }

    /**
     * logo商标识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   custom_lib 是否只使用自定义logo库的结果，默认false：返回自定义库+默认库的识别结果
     * @return array
     */
    public function logoSearch($image, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->logoSearchUrl, $data);
    }

    /**
     * logo商标识别—添加接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param string $brief - brief，检索时带回。此处要传对应的name与code字段，name长度小于100B，code长度小于150B
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function logoAdd($image, $brief, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);
        $data['brief'] = $brief;

        $data = array_merge($data, $options);

        return $this->request($this->logoAddUrl, $data);
    }

    /**
     * logo商标识别—删除接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function logoDeleteByImage($image, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->logoDeleteUrl, $data);
    }

    /**
     * logo商标识别—删除接口
     *
     * @param string $contSign - 图片签名（和image二选一，image优先级更高）
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function logoDeleteBySign($contSign, $options=array()){

        $data = array();
        
        $data['cont_sign'] = $contSign;

        $data = array_merge($data, $options);

        return $this->request($this->logoDeleteUrl, $data);
    }

    /**
     * 动物识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   top_num 返回预测得分top结果数，默认为6
     *   baike_num 返回百科信息的结果数，默认不返回
     * @return array
     */
    public function animalDetect($image, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->animalDetectUrl, $data);
    }

    /**
     * 植物识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   baike_num 返回百科信息的结果数，默认不返回
     * @return array
     */
    public function plantDetect($image, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->plantDetectUrl, $data);
    }

    /**
     * 图像主体检测接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   with_face 如果检测主体是人，主体区域是否带上人脸部分，0-不带人脸区域，其他-带人脸区域，裁剪类需求推荐带人脸，检索/识别类需求推荐不带人脸。默认取1，带人脸。
     * @return array
     */
    public function objectDetect($image, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->objectDetectUrl, $data);
    }

    /**
     * 地标识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function landmark($image, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->landmarkUrl, $data);
    }

    /**
     * 花卉识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   top_num 返回预测得分top结果数，默认为5
     *   baike_num 返回百科信息的结果数，默认不返回
     * @return array
     */
    public function flower($image, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->flowerUrl, $data);
    }

    /**
     * 食材识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   top_num 返回预测得分top结果数，如果为空或小于等于0默认为5；如果大于20默认20
     * @return array
     */
    public function ingredient($image, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->ingredientUrl, $data);
    }

    /**
     * 红酒识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function redwine($image, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->redwineUrl, $data);
    }

    /**
     * 货币识别接口
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function currency($image, $options=array()){

        $data = array();
        
        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->currencyUrl, $data);
    }

    /**
     * 自定义菜品识别—入库
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function customDishesAddImage($image, $brief, $options=array()){

        $data = array();

        $data['image'] = base64_encode($image);

        $data['brief'] = $brief;

        $data = array_merge($data, $options);

        return $this->request($this->customDishAddUrl, $data);
    }


    /**
     * 自定义菜品识别—检索
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function customDishesSearch($image, $options=array()){

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->customDishSearchUrl, $data);
    }

    /**
     * 自定义菜品识别—删除
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function customDishesDeleteImage($image, $options=array()){

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->customDishDeleteUrl, $data);
    }



    /**
     * 自定义菜品识别—删除
     *
     * @param string $image - 图像数据签名
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function customDishesDeleteContSign($contSign, $options=array()){

        $data = array();

        $data['cont_sign'] = $contSign;

        $data = array_merge($data, $options);

        return $this->request($this->customDishDeleteUrl, $data);
    }



    /**
     * 图像多主体检测
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function multiObjectDetect($image, $options=array()){

        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->request($this->multiObjectDetectUrl, $data);
    }



    /**
     * 组合接口-image
     *
     * @param string $image - 图像数据，base64编码，要求base64编码后大小不超过4M，最短边至少15px，最长边最大4096px,支持jpg/png/bmp格式
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function combinationByImage($image, $scenes, $options=array()){

        $data = array();

        $data['image'] = base64_encode($image);
        $data['scenes'] = $scenes;

        $data = array_merge($data, $options);

        return $this->request($this->combinationUrl, json_encode($data), array('Content-Type' => 'application/json;charset=utf-8'));
    }



    /**
     * 组合接口-imageUrl
     *
     * @param string $imageURl - 图像数据url
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function combinationByImageUrl($imageUrl, $scenes, $options=array()){

        $data = array();

        $data['imgUrl'] = $imageUrl;
        $data['scenes'] = $scenes;

        $data = array_merge($data, $options);

        return $this->request($this->combinationUrl, json_encode($data), array('Content-Type' => 'application/json;charset=utf-8'));
    }




    /**
     * 车辆属性识别
     * 传入单帧图像，检测图片中所有车辆，返回每辆车的类型和坐标位置，可识别小汽车、卡车、巴士、摩托车、三轮车、自行车6大类车辆，
     *
     * @param image  二进制图像数据
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   type 是否选定某些属性输出对应的信息，可从12种输出属性中任选若干，用英文逗号分隔（例如vehicle_type,roof_rack,skylight）。默认输出全部属性
     * @return array
     */
    public function vehicleAttr($image, $options=array()){

        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->vehicle_attrUrl, $data);
    }


    /**
     * 车辆属性识别
     * 传入单帧图像，检测图片中所有车辆，返回每辆车的类型和坐标位置，可识别小汽车、卡车、巴士、摩托车、三轮车、自行车6大类车辆，
     *
     * @param url  图片完整URL
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   type 是否选定某些属性输出对应的信息，可从12种输出属性中任选若干，用英文逗号分隔（例如vehicle_type,roof_rack,skylight）。默认输出全部属性
     * @return array
     */
    public function vehicleAttrUrl($url, $options=array()){

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->vehicle_attrUrl, $data);
    }


    /**
     * 车辆检测-高空版
     * 面向高空拍摄视角（30米以上），传入单帧图像，检测图片中所有车辆，返回每辆车的坐标位置（不区分车辆类型），并进行车辆计数，支持指定矩形区域的车辆检测与数量统计。
     *
     * @param image  二进制图像数据
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   area 只统计该矩形区域内的车辆数，缺省时为全图统计。逗号分隔，如‘x1,y1,x2,y2,x3,y3...xn,yn'，按顺序依次给出每个顶点的x、y坐标（默认尾点和首点相连），形成闭合矩形区域。
     * @return array
     */
    public function vehicleDetectHigh($image, $options=array()){

        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->vehicle_detect_highUrl, $data);
    }


    /**
     * 车辆检测-高空版
     * 面向高空拍摄视角（30米以上），传入单帧图像，检测图片中所有车辆，返回每辆车的坐标位置（不区分车辆类型），并进行车辆计数，支持指定矩形区域的车辆检测与数量统计。
     *
     * @param url  图片完整URL
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   area 只统计该矩形区域内的车辆数，缺省时为全图统计。逗号分隔，如‘x1,y1,x2,y2,x3,y3...xn,yn'，按顺序依次给出每个顶点的x、y坐标（默认尾点和首点相连），形成闭合矩形区域。
     * @return array
     */
    public function vehicleDetectHighUrl($url, $options=array()){

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->vehicle_detect_highUrl, $data);
    }


    /**
     * 车型识别
     * 识别图片中车辆的具体车型，可识别常见的3000+款车型（小汽车为主），输出车辆的品牌型号、颜色、年份、位置信息；支持返回对应识别结果的百度百科词条信息，包含词条名称、百科页面链接、百科图片链接、百科内容简介。
     *
     * @param url  图片完整URL
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   top_num 返回结果top n，默认5。e
     *   baike_num 返回百科信息的结果数，默认不返回
     * @return array
     */
    public function carDetectUrl($url, $options=array()){

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->car_detectUrl, $data);
    }


    /**
     * 车辆检测
     * 入单帧图像，检测图片中所有机动车辆，返回每辆车的类型和坐标位置，可识别小汽车、卡车、巴士、摩托车、三轮车5类车辆，并对每类车辆分别计数，同时可定位小汽车、卡车、巴士的车牌位置，支持指定矩形区域的车辆检测与数量统计
     *
     * @param url  图片完整URL
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   area 只统计该矩形区域内的车辆数，缺省时为全图统计。逗号分隔，如‘x1,y1,x2,y2,x3,y3...xn,yn'，按顺序依次给出每个顶点的x、y坐标（默认尾点和首点相连），形成闭合矩形区域。
     * @return array
     */
    public function vehicleDetectUrl($url, $options=array()){

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;

        return $this->request($this->vehicle_detectUrl, $data);
    }


    /**
     * 车辆分割
     * 传入单帧图像，检测图像中的车辆，以小汽车为主，识别车辆的轮廓范围，与背景进行分离，返回分割后的二值图、灰度图，支持多个车辆、车门打开、后备箱打开、机盖打开、正面、侧面、背面等各种拍摄场景。
     *
     * @param image  二进制图像数据
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   type 可以通过设置type参数，自主设置返回哪些结果图，避免造成带宽的浪费。1）可选值说明：labelmap - 二值图像，需二次处理方能查看分割效果scoremap - 车辆前景灰度图2）type 参数值可以是可选值的组合，用逗号分隔；如果无此参数默认输出全部3类结果图
     * @return array
     */
    public function vehicleSeg($image, $options=array()){

        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);

        return $this->request($this->vehicle_segUrl, $data);
    }


    /**
     * 车流统计
     * 根据传入的连续视频图片序列，进行车辆检测和追踪，返回每个车辆的坐标位置、车辆类型（包括小汽车、卡车、巴士、摩托车、三轮车5类）。在原图中指定区域，根据车辆轨迹判断驶入/驶出区域的行为，统计各类车辆的区域进出车流量，可返回含统计值和跟踪框的渲染图。
     *
     * @param image  二进制图像数据
     * @param case_id  任务ID（通过case_id区分不同视频流，自拟，不同序列间不可重复）
     * @param case_init  每个case的初始化信号，为true时对该case下的跟踪算法进行初始化，为false时重载该case的跟踪状态。当为false且读取不到相应case的信息时，直接重新初始化
     * @param area  只统计进出该区域的车辆。逗号分隔，如‘x1,y1,x2,y2,x3,y3...xn,yn'，按顺序依次给出每个顶点的x、y坐标（默认尾点和首点相连），形成闭合多边形区域。
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   show 是否返回结果图（含统计值和跟踪框）。选true时返回渲染后的图片(base64)，其它无效值或为空则默认false。
     * @return array
     */
    public function trafficFlow($image, $case_id, $case_init, $area, $options=array()){

        $data = array();

        $data = array_merge($data, $options);
        $data['image'] = base64_encode($image);
        $data['case_id'] = $case_id;
        $data['case_init'] = $case_init;
        $data['area'] = $area;

        return $this->request($this->traffic_flowUrl, $data);
    }


    /**
     * 车流统计
     * 根据传入的连续视频图片序列，进行车辆检测和追踪，返回每个车辆的坐标位置、车辆类型（包括小汽车、卡车、巴士、摩托车、三轮车5类）。在原图中指定区域，根据车辆轨迹判断驶入/驶出区域的行为，统计各类车辆的区域进出车流量，可返回含统计值和跟踪框的渲染图。
     *
     * @param url  图片完整URL
     * @param case_id  任务ID（通过case_id区分不同视频流，自拟，不同序列间不可重复）
     * @param case_init  每个case的初始化信号，为true时对该case下的跟踪算法进行初始化，为false时重载该case的跟踪状态。当为false且读取不到相应case的信息时，直接重新初始化
     * @param area  只统计进出该区域的车辆。逗号分隔，如‘x1,y1,x2,y2,x3,y3...xn,yn'，按顺序依次给出每个顶点的x、y坐标（默认尾点和首点相连），形成闭合多边形区域。
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   show 是否返回结果图（含统计值和跟踪框）。选true时返回渲染后的图片(base64)，其它无效值或为空则默认false。
     * @return array
     */
    public function trafficFlowUrl($url, $case_id, $case_init, $area, $options=array()){

        $data = array();

        $data = array_merge($data, $options);
        $data['url'] = $url;
        $data['case_id'] = $case_id;
        $data['case_init'] = $case_init;
        $data['area'] = $area;

        return $this->request($this->traffic_flowUrl, $data);
    }

    /**
     * 自定义红酒识别--入库
     * 接口使用说明: https://ai.baidu.com/ai-doc/IMAGERECOGNITION/skh4k58o4#%E8%87%AA%E5%AE%9A%E4%B9%89%E7%BA%A2%E9%85%92-%E5%85%A5%E5%BA%93
     */
    public function redwineAddV1ByImage($image, $brief, $options=array()){
        $data = array();
        $data['image'] = base64_encode($image);
        $data['brief'] = $brief;
        $data = array_merge($data, $options);
        return $this->request($this->redwineAddV1Url, $data);
    }

    /**
     * 自定义红酒识别--入库
     * 接口使用说明: https://ai.baidu.com/ai-doc/IMAGERECOGNITION/skh4k58o4#%E8%87%AA%E5%AE%9A%E4%B9%89%E7%BA%A2%E9%85%92-%E5%85%A5%E5%BA%93
     */
    public function redwineAddV1ByUrl($url, $brief, $options=array()){
        $data = array();
        $data['url'] = $url;
        $data['brief'] = $brief;
        $data = array_merge($data, $options);
        return $this->request($this->redwineAddV1Url, $data);
    }

    /**
     * 自定义红酒识别--检索
     * 接口使用说明: https://ai.baidu.com/ai-doc/IMAGERECOGNITION/skh4k58o4#%E8%87%AA%E5%AE%9A%E4%B9%89%E7%BA%A2%E9%85%92-%E6%A3%80%E7%B4%A2
     */
    public function redwineSearchV1ByImage($image, $custom_lib, $options=array()){
        $data = array();
        $data['image'] = base64_encode($image);
        $data['custom_lib'] = $custom_lib;
        $data = array_merge($data, $options);
        return $this->request($this->redwineSearchV1Url, $data);
    }

    /**
     * 自定义红酒识别--检索
     * 接口使用说明: https://ai.baidu.com/ai-doc/IMAGERECOGNITION/skh4k58o4#%E8%87%AA%E5%AE%9A%E4%B9%89%E7%BA%A2%E9%85%92-%E6%A3%80%E7%B4%A2
     */
    public function redwineSearchV1ByUrl($url, $custom_lib, $options=array()){
        $data = array();
        $data['url'] = url;
        $data['custom_lib'] = custom_lib;
        $data = array_merge($data, $options);
        return $this->request($this->redwineSearchV1Url, $data);
    }

    /**
     * 自定义红酒识别--删除
     * 接口使用说明: https://ai.baidu.com/ai-doc/IMAGERECOGNITION/skh4k58o4#%E8%87%AA%E5%AE%9A%E4%B9%89%E7%BA%A2%E9%85%92-%E5%88%A0%E9%99%A4
     */
    public function redwineDeleteV1ByImage($image, $options=array()){
        $data = array();
        $data['image'] = base64_encode($image);
        $data = array_merge($data, $options);
        return $this->request($this->redwineDeleteV1Url, $data);
    }

    /**
     * 自定义红酒识别--删除
     * 接口使用说明: https://ai.baidu.com/ai-doc/IMAGERECOGNITION/skh4k58o4#%E8%87%AA%E5%AE%9A%E4%B9%89%E7%BA%A2%E9%85%92-%E5%88%A0%E9%99%A4
     */
    public function redwineDeleteV1BySign($sign, $options=array()){
        $data = array();
        $data['cont_sign_list'] = $sign;
        $data = array_merge($data, $options);
        return $this->request($this->redwineDeleteV1Url, $data);
    }

    /**
     * 自定义红酒识别--更新
     * 接口使用说明: https://ai.baidu.com/ai-doc/IMAGERECOGNITION/skh4k58o4#%E8%87%AA%E5%AE%9A%E4%B9%89%E7%BA%A2%E9%85%92%E6%9B%B4%E6%96%B0
     */
    public function redwineUpdateV1($image, $brief, $options=array()){
        $data = array();
        $data['image'] = base64_encode($image);
        $data['brief'] = $brief;
        $data = array_merge($data, $options);
        return $this->request($this->redwineUpdateV1Url, $data);
    }

    /**
     * 自定义红酒识别--更新
     * 接口使用说明: https://ai.baidu.com/ai-doc/IMAGERECOGNITION/skh4k58o4#%E8%87%AA%E5%AE%9A%E4%B9%89%E7%BA%A2%E9%85%92%E6%9B%B4%E6%96%B0
     */
    public function redwineUpdateV1ByImage($image, $brief, $options=array()){
        $data = array();
        $data['image'] = base64_encode($image);
        $data['brief'] = $brief;
        $data = array_merge($data, $options);
        return $this->request($this->redwineUpdateV1Url, $data);
    }

    /**
     * 自定义红酒识别--更新
     * 接口使用说明: https://ai.baidu.com/ai-doc/IMAGERECOGNITION/skh4k58o4#%E8%87%AA%E5%AE%9A%E4%B9%89%E7%BA%A2%E9%85%92%E6%9B%B4%E6%96%B0
     */
    public function redwineUpdateV1ByUrl($url, $brief, $options=array()){
        $data = array();
        $data['url'] = $url;
        $data['brief'] = $brief;
        $data = array_merge($data, $options);
        return $this->request($this->redwineUpdateV1Url, $data);
    }

    /**
     * 车辆属性识别
     * 接口使用说明: https://ai.baidu.com/ai-doc/VEHICLE/mk3hb3fde
     */
    public function vehicleAttrClassifyV2ByImage($image, $options=array()){
        $data = array();
        $data['image'] = base64_encode($image);
        $data = array_merge($data, $options);
        return $this->request($this->vehicleAttrClassifyV2Url, $data);
    }

    /**
     * 车辆属性识别
     * 接口使用说明: https://ai.baidu.com/ai-doc/VEHICLE/mk3hb3fde
     */
    public function vehicleAttrClassifyV2ByUrl($url, $options=array()){
        $data = array();
        $data['url'] = $url;
        $data = array_merge($data, $options);
        return $this->request($this->vehicleAttrClassifyV2Url, $data);
    }

}