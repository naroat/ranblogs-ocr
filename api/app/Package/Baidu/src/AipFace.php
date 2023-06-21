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
class AipFace extends AipBase {
    /**
     * @var string
     */
    private $onlinePictureLiveUrlV4 = 'https://aip.baidubce.com/rest/2.0/face/v4/faceverify';

    /**
     * @var string
     */
    private $faceMatchV4Url = 'https://aip.baidubce.com/rest/2.0/face/v4/mingjing/match';

    /**
     * @var string
     */
    private $verifyUrl = 'https://aip.baidubce.com/rest/2.0/face/v4/mingjing/verify';


    /**
     * 人脸检测 detect api url
     * @var string
     */
    private $detectUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/detect';

    /**
     * 人脸搜索 search api url
     * @var string
     */
    private $searchUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/search';

    /**
     * 人脸搜索 M:N 识别 multi_search api url
     * @var string
     */
    private $multiSearchUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/multi-search';

    /**
     * 人脸注册 user_add api url
     * @var string
     */
    private $userAddUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/user/add';

    /**
     * 人脸更新 user_update api url
     * @var string
     */
    private $userUpdateUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/user/update';

    /**
     * 人脸删除 face_delete api url
     * @var string
     */
    private $faceDeleteUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/face/delete';

    /**
     * 用户信息查询 user_get api url
     * @var string
     */
    private $userGetUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/user/get';

    /**
     * 获取用户人脸列表 face_getlist api url
     * @var string
     */
    private $faceGetlistUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/face/getlist';

    /**
     * 获取用户列表 group_getusers api url
     * @var string
     */
    private $groupGetusersUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/group/getusers';

    /**
     * 复制用户 user_copy api url
     * @var string
     */
    private $userCopyUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/user/copy';

    /**
     * 删除用户 user_delete api url
     * @var string
     */
    private $userDeleteUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/user/delete';

    /**
     * 创建用户组 group_add api url
     * @var string
     */
    private $groupAddUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/group/add';

    /**
     * 删除用户组 group_delete api url
     * @var string
     */
    private $groupDeleteUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/group/delete';

    /**
     * 组列表查询 group_getlist api url
     * @var string
     */
    private $groupGetlistUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/faceset/group/getlist';

    /**
     * 身份验证 person_verify api url
     * @var string
     */
    private $personVerifyUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/person/verify';

    /**
     * 语音校验码接口 video_sessioncode api url
     * @var string
     */
    private $videoSessioncodeUrl = 'https://aip.baidubce.com/rest/2.0/face/v1/faceliveness/sessioncode';

    private $facelivenessVerifyV1Url = 'https://aip.baidubce.com/rest/2.0/face/v1/faceliveness/verify';


    private $facePersonIdmatchV3Url = 'https://aip.baidubce.com/rest/2.0/face/v3/person/idmatch';
    private $faceMergeV1Url = 'https://aip.baidubce.com/rest/2.0/face/v1/merge';
    private $faceSkinSmoothV1Url = 'https://aip.baidubce.com/rest/2.0/face/v1/editattr';
    private $faceLandmarkV1Url = 'https://aip.baidubce.com/rest/2.0/face/v1/landmark';
    private $faceSceneFacesetUserAddUrl = 'https://aip.baidubce.com/rest/2.0/face/scene/faceset/user/add';
    private $faceSceneFacesetUserUpdateUrl = 'https://aip.baidubce.com/rest/2.0/face/scene/faceset/user/update';
    private $faceSceneFacesetGroupAddUrl = 'https://aip.baidubce.com/rest/2.0/face/scene/faceset/group/add';
    private $faceCaptureSearchUrl = 'https://aip.baidubce.com/rest/2.0/face/capture/search';
    private $faceIdmatchDateV4Url = 'https://aip.baidubce.com/rest/2.0/face/v4/idmatch_date';
    private $faceVerifyDateV4Url = 'https://aip.baidubce.com/rest/2.0/face/v4/verify_date';

    
    /**
     * 人脸检测接口
     *
     * @param string $image - 图片信息(**总数据大小应小于10M**)，图片上传方式根据image_type来判断
     * @param string $imageType - 图片类型     <br> **BASE64**:图片的base64值，base64编码后的图片数据，编码后的图片大小不超过2M； <br>**URL**:图片的 URL地址( 可能由于网络等原因导致下载图片时间过长)； <br>**FACE_TOKEN**: 人脸图片的唯一标识，调用人脸检测接口时，会为每个人脸图片赋予一个唯一的FACE_TOKEN，同一张图片多次检测得到的FACE_TOKEN是同一个。
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   face_field 包括**age,beauty,expression,face_shape,gender,glasses,landmark,landmark72，landmark150，race,quality,eye_status,emotion,face_type信息**  <br> 逗号分隔. 默认只返回face_token、人脸框、概率和旋转角度
     *   max_face_num 最多处理人脸的数目，默认值为1，仅检测图片中面积最大的那个人脸；**最大值10**，检测图片中面积最大的几张人脸。
     *   face_type 人脸的类型 **LIVE**表示生活照：通常为手机、相机拍摄的人像图片、或从网络获取的人像图片等**IDCARD**表示身份证芯片照：二代身份证内置芯片中的人像照片 **WATERMARK**表示带水印证件照：一般为带水印的小图，如公安网小图 **CERT**表示证件照片：如拍摄的身份证、工卡、护照、学生证等证件图片 默认**LIVE**
     *   liveness_control 活体检测控制  **NONE**: 不进行控制 **LOW**:较低的活体要求(高通过率 低攻击拒绝率) **NORMAL**: 一般的活体要求(平衡的攻击拒绝率, 通过率) **HIGH**: 较高的活体要求(高攻击拒绝率 低通过率) **默认NONE**
     * @return array
     */
    public function detect($image, $imageType, $options=array()){

        $data = array();
        
        $data['image'] = $image;
        $data['image_type'] = $imageType;

        $data = array_merge($data, $options);
        return $this->request($this->detectUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 人脸搜索接口
     *
     * @param string $image - 图片信息(**总数据大小应小于10M**)，图片上传方式根据image_type来判断
     * @param string $imageType - 图片类型     <br> **BASE64**:图片的base64值，base64编码后的图片数据，编码后的图片大小不超过2M； <br>**URL**:图片的 URL地址( 可能由于网络等原因导致下载图片时间过长)； <br>**FACE_TOKEN**: 人脸图片的唯一标识，调用人脸检测接口时，会为每个人脸图片赋予一个唯一的FACE_TOKEN，同一张图片多次检测得到的FACE_TOKEN是同一个。
     * @param string $groupIdList - 从指定的group中进行查找 用逗号分隔，**上限20个**
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   max_face_num 最多处理人脸的数目<br>**默认值为1(仅检测图片中面积最大的那个人脸)** **最大值10**
     *   match_threshold 匹配阈值（设置阈值后，score低于此阈值的用户信息将不会返回） 最大100 最小0 默认80 <br>**此阈值设置得越高，检索速度将会越快，推荐使用默认阈值`80`**
     *   quality_control 图片质量控制  **NONE**: 不进行控制 **LOW**:较低的质量要求 **NORMAL**: 一般的质量要求 **HIGH**: 较高的质量要求 **默认 NONE**
     *   liveness_control 活体检测控制  **NONE**: 不进行控制 **LOW**:较低的活体要求(高通过率 低攻击拒绝率) **NORMAL**: 一般的活体要求(平衡的攻击拒绝率, 通过率) **HIGH**: 较高的活体要求(高攻击拒绝率 低通过率) **默认NONE**
     *   user_id 当需要对特定用户进行比对时，指定user_id进行比对。即人脸认证功能。
     *   max_user_num 查找后返回的用户数量。返回相似度最高的几个用户，默认为1，最多返回50个。
     * @return array
     */
    public function search($image, $imageType, $groupIdList, $options=array()){

        $data = array();
        
        $data['image'] = $image;
        $data['image_type'] = $imageType;
        $data['group_id_list'] = $groupIdList;

        $data = array_merge($data, $options);
        return $this->request($this->searchUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 人脸搜索 M:N 识别接口
     *
     * @param string $image - 图片信息(**总数据大小应小于10M**)，图片上传方式根据image_type来判断
     * @param string $imageType - 图片类型     <br> **BASE64**:图片的base64值，base64编码后的图片数据，编码后的图片大小不超过2M； <br>**URL**:图片的 URL地址( 可能由于网络等原因导致下载图片时间过长)； <br>**FACE_TOKEN**: 人脸图片的唯一标识，调用人脸检测接口时，会为每个人脸图片赋予一个唯一的FACE_TOKEN，同一张图片多次检测得到的FACE_TOKEN是同一个。
     * @param string $groupIdList - 从指定的group中进行查找 用逗号分隔，**上限20个**
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   max_face_num 最多处理人脸的数目<br>**默认值为1(仅检测图片中面积最大的那个人脸)** **最大值10**
     *   match_threshold 匹配阈值（设置阈值后，score低于此阈值的用户信息将不会返回） 最大100 最小0 默认80 <br>**此阈值设置得越高，检索速度将会越快，推荐使用默认阈值`80`**
     *   quality_control 图片质量控制  **NONE**: 不进行控制 **LOW**:较低的质量要求 **NORMAL**: 一般的质量要求 **HIGH**: 较高的质量要求 **默认 NONE**
     *   liveness_control 活体检测控制  **NONE**: 不进行控制 **LOW**:较低的活体要求(高通过率 低攻击拒绝率) **NORMAL**: 一般的活体要求(平衡的攻击拒绝率, 通过率) **HIGH**: 较高的活体要求(高攻击拒绝率 低通过率) **默认NONE**
     *   max_user_num 查找后返回的用户数量。返回相似度最高的几个用户，默认为1，最多返回50个。
     * @return array
     */
    public function multiSearch($image, $imageType, $groupIdList, $options=array()){

        $data = array();
        
        $data['image'] = $image;
        $data['image_type'] = $imageType;
        $data['group_id_list'] = $groupIdList;

        $data = array_merge($data, $options);
        return $this->request($this->multiSearchUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 人脸注册接口
     *
     * @param string $image - 图片信息(总数据大小应小于10M)，图片上传方式根据image_type来判断。注：组内每个uid下的人脸图片数目上限为20张
     * @param string $imageType - 图片类型     <br> **BASE64**:图片的base64值，base64编码后的图片数据，编码后的图片大小不超过2M； <br>**URL**:图片的 URL地址( 可能由于网络等原因导致下载图片时间过长)； <br>**FACE_TOKEN**: 人脸图片的唯一标识，调用人脸检测接口时，会为每个人脸图片赋予一个唯一的FACE_TOKEN，同一张图片多次检测得到的FACE_TOKEN是同一个。
     * @param string $groupId - 用户组id（由数字、字母、下划线组成），长度限制128B
     * @param string $userId - 用户id（由数字、字母、下划线组成），长度限制128B
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   user_info 用户资料，长度限制256B
     *   quality_control 图片质量控制  **NONE**: 不进行控制 **LOW**:较低的质量要求 **NORMAL**: 一般的质量要求 **HIGH**: 较高的质量要求 **默认 NONE**
     *   liveness_control 活体检测控制  **NONE**: 不进行控制 **LOW**:较低的活体要求(高通过率 低攻击拒绝率) **NORMAL**: 一般的活体要求(平衡的攻击拒绝率, 通过率) **HIGH**: 较高的活体要求(高攻击拒绝率 低通过率) **默认NONE**
     *   action_type 操作方式  APPEND: 当user_id在库中已经存在时，对此user_id重复注册时，新注册的图片默认会追加到该user_id下,REPLACE : 当对此user_id重复注册时,则会用新图替换库中该user_id下所有图片,默认使用APPEND
     * @return array
     */
    public function addUser($image, $imageType, $groupId, $userId, $options=array()){

        $data = array();
        
        $data['image'] = $image;
        $data['image_type'] = $imageType;
        $data['group_id'] = $groupId;
        $data['user_id'] = $userId;

        $data = array_merge($data, $options);
        return $this->request($this->userAddUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 人脸更新接口
     *
     * @param string $image - 图片信息(**总数据大小应小于10M**)，图片上传方式根据image_type来判断
     * @param string $imageType - 图片类型     <br> **BASE64**:图片的base64值，base64编码后的图片数据，编码后的图片大小不超过2M； <br>**URL**:图片的 URL地址( 可能由于网络等原因导致下载图片时间过长)； <br>**FACE_TOKEN**: 人脸图片的唯一标识，调用人脸检测接口时，会为每个人脸图片赋予一个唯一的FACE_TOKEN，同一张图片多次检测得到的FACE_TOKEN是同一个。
     * @param string $groupId - 更新指定groupid下uid对应的信息
     * @param string $userId - 用户id（由数字、字母、下划线组成），长度限制128B
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   user_info 用户资料，长度限制256B
     *   quality_control 图片质量控制  **NONE**: 不进行控制 **LOW**:较低的质量要求 **NORMAL**: 一般的质量要求 **HIGH**: 较高的质量要求 **默认 NONE**
     *   liveness_control 活体检测控制  **NONE**: 不进行控制 **LOW**:较低的活体要求(高通过率 低攻击拒绝率) **NORMAL**: 一般的活体要求(平衡的攻击拒绝率, 通过率) **HIGH**: 较高的活体要求(高攻击拒绝率 低通过率) **默认NONE**
     *   action_type 操作方式  APPEND: 当user_id在库中已经存在时，对此user_id重复注册时，新注册的图片默认会追加到该user_id下,REPLACE : 当对此user_id重复注册时,则会用新图替换库中该user_id下所有图片,默认使用APPEND
     * @return array
     */
    public function updateUser($image, $imageType, $groupId, $userId, $options=array()){

        $data = array();
        
        $data['image'] = $image;
        $data['image_type'] = $imageType;
        $data['group_id'] = $groupId;
        $data['user_id'] = $userId;

        $data = array_merge($data, $options);
        return $this->request($this->userUpdateUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 人脸删除接口
     *
     * @param string $userId - 用户id（由数字、字母、下划线组成），长度限制128B
     * @param string $groupId - 用户组id（由数字、字母、下划线组成），长度限制128B
     * @param string $faceToken - 需要删除的人脸图片token，（由数字、字母、下划线组成）长度限制64B
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function faceDelete($userId, $groupId, $faceToken, $options=array()){

        $data = array();
        
        $data['user_id'] = $userId;
        $data['group_id'] = $groupId;
        $data['face_token'] = $faceToken;

        $data = array_merge($data, $options);
        return $this->request($this->faceDeleteUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 用户信息查询接口
     *
     * @param string $userId - 用户id（由数字、字母、下划线组成），长度限制128B
     * @param string $groupId - 用户组id（由数字、字母、下划线组成），长度限制128B
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function getUser($userId, $groupId, $options=array()){

        $data = array();
        
        $data['user_id'] = $userId;
        $data['group_id'] = $groupId;

        $data = array_merge($data, $options);
        return $this->request($this->userGetUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 获取用户人脸列表接口
     *
     * @param string $userId - 用户id（由数字、字母、下划线组成），长度限制128B
     * @param string $groupId - 用户组id（由数字、字母、下划线组成），长度限制128B
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function faceGetlist($userId, $groupId, $options=array()){

        $data = array();
        
        $data['user_id'] = $userId;
        $data['group_id'] = $groupId;

        $data = array_merge($data, $options);
        return $this->request($this->faceGetlistUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 获取用户列表接口
     *
     * @param string $groupId - 用户组id（由数字、字母、下划线组成），长度限制128B
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   start 默认值0，起始序号
     *   length 返回数量，默认值100，最大值1000
     * @return array
     */
    public function getGroupUsers($groupId, $options=array()){

        $data = array();
        
        $data['group_id'] = $groupId;

        $data = array_merge($data, $options);
        return $this->request($this->groupGetusersUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 复制用户接口
     *
     * @param string $userId - 用户id（由数字、字母、下划线组成），长度限制128B
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   src_group_id 从指定组里复制信息
     *   dst_group_id 需要添加用户的组id
     * @return array
     */
    public function userCopy($userId, $options=array()){

        $data = array();
        
        $data['user_id'] = $userId;

        $data = array_merge($data, $options);
        return $this->request($this->userCopyUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 删除用户接口
     *
     * @param string $groupId - 用户组id（由数字、字母、下划线组成），长度限制128B
     * @param string $userId - 用户id（由数字、字母、下划线组成），长度限制128B
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function deleteUser($groupId, $userId, $options=array()){

        $data = array();
        
        $data['group_id'] = $groupId;
        $data['user_id'] = $userId;

        $data = array_merge($data, $options);
        return $this->request($this->userDeleteUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 创建用户组接口
     *
     * @param string $groupId - 用户组id（由数字、字母、下划线组成），长度限制128B
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function groupAdd($groupId, $options=array()){

        $data = array();
        
        $data['group_id'] = $groupId;

        $data = array_merge($data, $options);
        return $this->request($this->groupAddUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 删除用户组接口
     *
     * @param string $groupId - 用户组id（由数字、字母、下划线组成），长度限制128B
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function groupDelete($groupId, $options=array()){

        $data = array();
        
        $data['group_id'] = $groupId;

        $data = array_merge($data, $options);
        return $this->request($this->groupDeleteUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 组列表查询接口
     *
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   start 默认值0，起始序号
     *   length 返回数量，默认值100，最大值1000
     * @return array
     */
    public function getGroupList($options=array()){

        $data = array();
        

        $data = array_merge($data, $options);
        return $this->request($this->groupGetlistUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 身份验证接口
     *
     * @param string $image - 图片信息(**总数据大小应小于10M**)，图片上传方式根据image_type来判断
     * @param string $imageType - 图片类型     <br> **BASE64**:图片的base64值，base64编码后的图片数据，编码后的图片大小不超过2M； <br>**URL**:图片的 URL地址( 可能由于网络等原因导致下载图片时间过长)； <br>**FACE_TOKEN**: 人脸图片的唯一标识，调用人脸检测接口时，会为每个人脸图片赋予一个唯一的FACE_TOKEN，同一张图片多次检测得到的FACE_TOKEN是同一个。
     * @param string $idCardNumber - 身份证号（真实身份证号号码）
     * @param string $name - utf8，姓名（真实姓名，和身份证号匹配）
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   quality_control 图片质量控制  **NONE**: 不进行控制 **LOW**:较低的质量要求 **NORMAL**: 一般的质量要求 **HIGH**: 较高的质量要求 **默认 NONE**
     *   liveness_control 活体检测控制  **NONE**: 不进行控制 **LOW**:较低的活体要求(高通过率 低攻击拒绝率) **NORMAL**: 一般的活体要求(平衡的攻击拒绝率, 通过率) **HIGH**: 较高的活体要求(高攻击拒绝率 低通过率) **默认NONE**
     * @return array
     */
    public function personVerify($image, $imageType, $idCardNumber, $name, $options=array()){

        $data = array();
        
        $data['image'] = $image;
        $data['image_type'] = $imageType;
        $data['id_card_number'] = $idCardNumber;
        $data['name'] = $name;

        $data = array_merge($data, $options);
        return $this->request($this->personVerifyUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 语音校验码接口接口
     *
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   appid 百度云创建应用时的唯一标识ID
     * @return array
     */
    public function videoSessioncode($options=array()){

        $data = array();
        

        $data = array_merge($data, $options);
        return $this->request($this->videoSessioncodeUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }
    /**
     * 在线活体检测 faceverify api url
     * @var string
     */
    private $faceverifyUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/faceverify';

    /**
     * 在线活体检测接口
     *
     * @param array $images
     * @return array
     */
    public function faceverify($images){

        return $this->request($this->faceverifyUrl, json_encode($images), array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 人脸比对 match api url
     * @var string
     */
    private $matchUrl = 'https://aip.baidubce.com/rest/2.0/face/v3/match';

    /**
     * 人脸比对接口
     *
     * @param array $images
     * @return array
     */
    public function match($images){

        return $this->request($this->matchUrl, json_encode($images), array(
            'Content-Type' => 'application/json',
        ));
    }


    /**
     * 人脸 - 人脸实名认证V4
     * 基于姓名和身份证号，调取公安权威数据源人脸图，将当前获取的人脸图片，与此公安数据源人脸图进行对比，得出比对分数，并基于此进行业务判断是否为同一人
     * @param idCardNumber  身份证件号
     * @param name  姓名(需要是 utf8 编码)
     * @param image  图片信息(数据大小应小于10M 分辨率应小于1920*1080)，5.2版本SDK请求时已包含在加密数据data中，无需额外传入
     * @param array $options - 可选参数对象，key: value都为string类型
     * @return array
     */
    public function faceMingJingVerify($idCardNumber, $name, $image, $options=array()){

        $data = array();
        if ($options != null) {
            $data = array_merge($data, $options);
        }

        $data['id_card_number'] = $idCardNumber;
        $data['name'] = $name;
        $data['image'] = $image;

        return $this->request($this->verifyUrl, json_encode($data), array('Content-Type' => 'application/json;charset=utf-8'));
    }


    /**
     * 人脸 - 人脸对比V4
     * 用于比对多张图片中的人脸相似度并返回两两比对的得分，可用于判断两张脸是否是同一人的可能性大小
     * @param image  图片信息(数据大小应小于10M 分辨率应小于1920*1080)，5.2版本SDK请求时已包含在加密数据data中，无需额外传入
     * @param imageType  图片类型
     * @param registerImage  图片信息(总数据大小应小于10M)，图片上传方式根据image_type来判断。本图片特指客户服务器上传图片，非加密图片Base64值   
     * @param registerImageType  图片类型             
     * @param array $options - 可选参数对象，key: value都为string类型
     * @return array
     */
    public function faceMingJingMatch($image, $imageType, $registerImage, $registerImageType, $options=array()){

        $data = array();
        if ($options != null) {
            $data = array_merge($data, $options);
        }

        $data['image'] = $image;
        $data['image_type'] = $imageType;
        $data['register_image'] = $registerImage;
        $data['register_image_type'] = $registerImageType;

        return $this->request($this->faceMatchV4Url, json_encode($data), array('Content-Type' => 'application/json;charset=utf-8'));
    }


    /**
     * 人脸 - 在线图片活体V4
     * 基于单张图片，判断图片中的人脸是否为二次翻拍
     * @param sdkVersion  sdk版本
     * @param array $options - 可选参数对象，key: value都为string类型
     * @return array
     */
    public function onlinePictureLiveV4($sdkVersion, $options=array()){

        $data = array();
        if ($options != null) {
            $data = array_merge($data, $options);
        }

        $data['sdk_version'] = $sdkVersion;

        return $this->request($this->onlinePictureLiveUrlV4, json_encode($data), array('Content-Type' => 'application/json;charset=utf-8'));
    }

    /**
     * H5视频活体检测
     * 接口使用文档: https://ai.baidu.com/ai-doc/FACE/lk37c1tag#12-%E8%A7%86%E9%A2%91%E6%B4%BB%E4%BD%93%E6%A3%80%E6%B5%8B%E6%8E%A5%E5%8F%A3
     */
    public function facelivenessVerifyV1($videoBase64, $options=array()) {
        $data = array();
        if ($options != null) {
            $data = array_merge($data, $options);
        }
        $data['video_base64'] = $videoBase64;
        return $this->request($this->facelivenessVerifyV1Url, $data, array('Content-Type' => 'application/json'));
    }

    /**
     * 身份证与名字比对
     * 接口使用说明文档: https://ai.baidu.com/ai-doc/FACE/Tkqahnjtk
     */
    public function facePersonIdmatchV3($idCardNumber, $name){
        $data = array();
        $data['id_card_number'] = $idCardNumber;
        $data['name'] = $name;
        return $this->request($this->facePersonIdmatchV3Url, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 人脸融合
     * 接口使用说明文档: https://ai.baidu.com/ai-doc/FACE/5k37c1ti0
     */
    public function faceMergeV1($imageTemplate, $imageTarget, $options=array()){
        $data = array();
        $data['image_template'] = $imageTemplate;
        $data['image_target'] = $imageTarget;
        $data = array_merge($data, $options);
        return $this->request($this->faceMergeV1Url, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 人脸属性编辑
     * 接口使用说明文档: https://ai.baidu.com/ai-doc/FACE/vk6rm5lj5
     */
    public function faceSkinSmoothV1($image, $imageType, $actionType, $options=array()){
        $data = array();
        $data['image'] = $image;
        $data['image_type'] = $imageType;
        $data['action_type'] = $actionType;
        $data = array_merge($data, $options);
        return $this->request($this->faceSkinSmoothV1Url, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 人脸关键点检测
     * 接口使用说明文档: https://ai.baidu.com/ai-doc/FACE/sk8a5xewt
     */
    public function faceLandmarkV1($image, $imageType, $options=array()){
        $data = array();
        $data['image'] = $image;
        $data['image_type'] = $imageType;
        $data = array_merge($data, $options);
        return $this->request($this->faceLandmarkV1Url, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 场景化（人脸注册）
     * 接口使用说明文档: https://ai.baidu.com/ai-doc/FACE/Aknhmx6hi#%E4%BA%BA%E8%84%B8%E5%BA%93%E7%AE%A1%E7%90%86%EF%BC%88%E5%9C%BA%E6%99%AF%E5%8C%96%EF%BC%89-%E4%BA%BA%E8%84%B8%E6%B3%A8%E5%86%8C
     */
    public function faceSceneFacesetUserAdd($image, $imageType, $groupId, $userId, $sceneType, $options=array()){
        $data = array();
        $data['image'] = $image;
        $data['image_type'] = $imageType;
        $data['group_id'] = $groupId;
        $data['user_id'] = $userId;
        $data['scene_type'] = $sceneType;
        $data = array_merge($data, $options);
        return $this->request($this->faceSceneFacesetUserAddUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 场景化（人脸更新）
     * 接口使用说明文档: https://ai.baidu.com/ai-doc/FACE/Aknhmx6hi#%E4%BA%BA%E8%84%B8%E5%BA%93%E7%AE%A1%E7%90%86%EF%BC%88%E5%9C%BA%E6%99%AF%E5%8C%96%EF%BC%89-%E4%BA%BA%E8%84%B8%E6%9B%B4%E6%96%B0
     */
    public function faceSceneFacesetUserUpdate($image, $imageType, $groupId, $userId, $sceneType, $options=array()){
        $data = array();
        $data['image'] = $image;
        $data['image_type'] = $imageType;
        $data['group_id'] = $groupId;
        $data['user_id'] = $userId;
        $data['scene_type'] = $sceneType;
        $data = array_merge($data, $options);
        return $this->request($this->faceSceneFacesetUserUpdateUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 场景化（创建用户组）
     * 接口使用说明文档: https://ai.baidu.com/ai-doc/FACE/Aknhmx6hi#%E4%BA%BA%E8%84%B8%E5%BA%93%E7%AE%A1%E7%90%86%EF%BC%88%E5%9C%BA%E6%99%AF%E5%8C%96%EF%BC%89-%E5%88%9B%E5%BB%BA%E7%94%A8%E6%88%B7%E7%BB%84
     */
    public function faceSceneFacesetGroupAdd($groupId, $sceneType){
        $data = array();
        $data['group_id'] = $groupId;
        $data['scene_type'] = $sceneType;
        return $this->request($this->faceSceneFacesetGroupAddUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 场景化（1：N识别）
     * 接口使用说明文档: https://ai.baidu.com/ai-doc/FACE/Aknhmx6hi
     */
    public function faceCaptureSearch($image, $imageType, $groupIdList, $options=array()){
        $data = array();
        $data['image'] = $image;
        $data['image_type'] = $imageType;
        $data['group_id_list'] = $groupIdList;
        $data = array_merge($data, $options);
        return $this->request($this->faceCaptureSearchUrl, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 身份证信息及有效期核验接口
     * 接口使用说明文档: https://ai.baidu.com/ai-doc/FACE/elav5puig
     */
    public function faceIdmatchDateV4($name, $idCardNumber, $startDate, $endDate){
        $data = array();
        $data['name'] = $name;
        $data['id_card_number'] = $idCardNumber;
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;
        return $this->request($this->faceIdmatchDateV4Url, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 人脸实名信息及有效期核验
     * 接口使用说明文档: https://ai.baidu.com/ai-doc/FACE/qlav5rwms
     */
    public function faceVerifyDateV4($name, $idCardNumber, $startDate, $endDate, $image, $imageType, $options=array()) {
        $data = array();
        $data['name'] = $name;
        $data['id_card_number'] = $idCardNumber;
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;
        $data['image'] = $image;
        $data['image_type'] = $imageType;
        $data = array_merge($data, $options);
        return $this->request($this->faceVerifyDateV4Url, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

}