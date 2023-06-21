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
class AipMt extends AipBase {

    private $pictransV1Url = 'https://aip.baidubce.com/file/2.0/mt/pictrans/v1';
    private $texttransV1Url = 'https://aip.baidubce.com/rpc/2.0/mt/texttrans/v1';
    private $texttransWithDictV1Url = 'https://aip.baidubce.com/rpc/2.0/mt/texttrans-with-dict/v1';
    private $docTranslationCreateV2Url = 'https://aip.baidubce.com/rpc/2.0/mt/v2/doc-translation/create';
    private $docTranslationQueryV2Url = 'https://aip.baidubce.com/rpc/2.0/mt/v2/doc-translation/query';
    private $speechTranslationV2Url = 'https://aip.baidubce.com/rpc/2.0/mt/v2/speech-translation';
    
    /**
     * 文本翻译-通用版
     * 接口使用说明文档: https://ai.baidu.com/ai-doc/MT/4kqryjku9
     */
    public function texttransV1($from, $to, $q, $options=array()){
        $data = array();
        $data['from'] = $from;
        $data['to'] = $to;
        $data['q'] = $q;
        $data = array_merge($data, $options);
        return $this->request($this->texttransV1Url, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 文本翻译-词典版
     * 接口使用说明文档: https://ai.baidu.com/ai-doc/MT/nkqrzmbpc
     */
    public function texttransWithDictV1($from, $to, $q, $options=array()){
        $data = array();
        $data['from'] = $from;
        $data['to'] = $to;
        $data['q'] = $q;
        $data = array_merge($data, $options);
        return $this->request($this->texttransWithDictV1Url, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 文档翻译
     * 接口使用说明文档: https://ai.baidu.com/ai-doc/MT/Xky9x5xub
     */
    public function docTranslationCreateV2($from, $to, $input, $options=array()){
        $data = array();
        $data['from'] = $from;
        $data['to'] = $to;
        $data['input'] = $input;
        $data = array_merge($data, $options);
        return $this->request($this->docTranslationCreateV2Url, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 文档翻译-文档状态查询
     * 接口使用说明文档: https://ai.baidu.com/ai-doc/MT/Xky9x5xub#%E6%9F%A5%E8%AF%A2%E6%96%87%E6%A1%A3%E7%BF%BB%E8%AF%91%E6%8E%A5%E5%8F%A3
     */
    public function docTranslationQueryV2($id, $options=array()){
        $data = array();
        $data['id'] = $id;
        $data = array_merge($data, $options);
        return $this->request($this->docTranslationQueryV2Url, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * 语音翻译
     * 接口使用说明文档: https://ai.baidu.com/ai-doc/MT/el4cmi76f
     */
    public function speechTranslationV2($from, $to, $voice, $format, $options=array()){
        $data = array();
        $data['from'] = $from;
        $data['to'] = $to;
        $data['voice'] =  base64_encode($voice);
        $data['format'] = $format;
        $data = array_merge($data, $options);
        return $this->request($this->speechTranslationV2Url, json_encode($data),  array(
            'Content-Type' => 'application/json',
        ));
    }

}