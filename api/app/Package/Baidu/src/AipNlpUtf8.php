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

class AipNlpUtf8 extends AipBase
{

    /**
     * 依存句法分析 dep_parser api url
     * @var string
     */
    private $depParserUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/depparser';


    /**
     * 短文本相似度 simnet api url
     * @var string
     */
    private $simnetUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v2/simnet';


    /**
     * 文章标签 keyword api url
     * @var string
     */
    private $keywordUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/keyword';

    /**
     * 文本纠错 ecnet api url
     * @var string
     */
    private $ecnetUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/ecnet';


    /**
     * 格式化结果
     * @param $content string
     * @return mixed
     */
    protected function proccessResult($content)
    {
        $result = json_decode($content, true, 512, JSON_BIGINT_AS_STRING);

        return $result;
    }

    /**
     * 依存句法分析接口
     *
     * @param string $text - 待分析文本（目前仅支持GBK编码），长度不超过256字节
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   mode 模型选择。默认值为0，可选值mode=0（对应web模型）；mode=1（对应query模型）
     * @return array
     */
    public function depParser($text, $options = array())
    {

        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->depParserUrl, $data);
    }


    /**
     * 文章主题短语生成
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/9k53w3qob
     */
    public function topicPhrase($title, $summary, $options = array())
    {
        $data = array();

        $data['title'] = $title;
        $data['summary'] = $summary;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->topicPhraseUrl, $data);
    }


    /**
     * 短文本相似度接口
     *
     * @param string $text1 - 待比较文本1（GBK编码），最大512字节
     * @param string $text2 - 待比较文本2（GBK编码），最大512字节
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   model 默认为"BOW"，可选"BOW"、"CNN"与"GRNN"
     * @return array
     */
    public function simnet($text1, $text2, $options = array())
    {

        $data = array();

        $data['text_1'] = $text1;
        $data['text_2'] = $text2;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        // 编码转换：兼容老接口，防止乱码
        return $this->request($this->simnetUrl, $data);
    }

    /**
     * 文章标签接口
     *
     * @param string $title - 篇章的标题，最大80字节
     * @param string $content - 篇章的正文，最大65535字节
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function keyword($title, $content, $options = array())
    {

        $data = array();

        $data['title'] = $title;
        $data['content'] = $content;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'UTF8', 'GBK');

        // 编码转换：兼容老接口，防止乱码
        return $this->request($this->keywordUrl, $data);
    }

    /**
     * 文本纠错接口
     *
     * @param string $text - 待纠错文本，输入限制511字节
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function ecnet($text, $options = array())
    {
        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'UTF8', 'GBK');

        // 编码转换：兼容老接口，防止乱码
        return $this->request($this->ecnetUrl, $data);
    }
}