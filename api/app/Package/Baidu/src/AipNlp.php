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

class AipNlp extends AipBase
{

    /**
     * 词法分析 lexer api url
     * @var string
     */
    private $lexerUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/lexer';

    /**
     * 词法分析（定制版） lexer_custom api url
     * @var string
     */
    private $lexerCustomUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/lexer_custom';

    /**
     * 依存句法分析 dep_parser api url
     * @var string
     */
    private $depParserUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/depparser';

    /**
     * 词向量表示 word_embedding api url
     * @var string
     */
    private $wordEmbeddingUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v2/word_emb_vec';

    /**
     * DNN语言模型 dnnlm_cn api url
     * @var string
     */
    private $dnnlmCnUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v2/dnnlm_cn';

    /**
     * 词义相似度 word_sim_embedding api url
     * @var string
     */
    private $wordSimEmbeddingUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v2/word_emb_sim';

    /**
     * 短文本相似度 simnet api url
     * @var string
     */
    private $simnetUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v2/simnet';

    /**
     * 评论观点抽取 comment_tag api url
     * @var string
     */
    private $commentTagUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v2/comment_tag';

    /**
     * 情感倾向分析 sentiment_classify api url
     * @var string
     */
    private $sentimentClassifyUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/sentiment_classify';

    /**
     * 文章标签 keyword api url
     * @var string
     */
    private $keywordUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/keyword';

    /**
     * 文章分类 topic api url
     * @var string
     */
    private $topicUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/topic';

    /**
     * 对话情绪识别接口 emotion api url
     * @var string
     */
    private $emotionUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/emotion';

    /**
     * 新闻摘要接口 news_summary api url
     * @var string
     */
    private $newsSummaryUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/news_summary';

    /**
     * 地址识别接口 address api url
     * @var string
     */
    private $addressUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/address';

    private $commentTagCustomUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v2/comment_tag_custom';
    private $sentimentClassifyCustomUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/sentiment_classify_custom';
    private $coupletsUrl = 'https://aip.baidubce.com/rpc/2.0/creation/v1/couplets';
    private $poemUrl = 'https://aip.baidubce.com/rpc/2.0/creation/v1/poem';
    private $entityLevelSentimentUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/entity_level_sentiment';
    private $entityLevelSentimentAddUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/entity_level_sentiment/add';
    private $entityLevelSentimentDeleteUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/entity_level_sentiment/delete';
    private $entityLevelSentimentDeleteRepoUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/entity_level_sentiment/delete_repo';
    private $entityLevelSentimentListUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/entity_level_sentiment/list';
    private $entityLevelSentimentQueryUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/entity_level_sentiment/query';
    private $topicPhraseUrl = 'https://aip.baidubce.com/rpc/2.0/creation/v1/topic_phrase';
    private $cvparserUrl = 'https://aip.baidubce.com/rpc/2.0/recruitment/v1/cvparser';
    private $personPostUrl = 'https://aip.baidubce.com/rpc/2.0/recruitment/v1/person_post';
    private $personasUrl = 'https://aip.baidubce.com/rpc/2.0/recruitment/v1/personas';
    private $titlepredictorUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/titlepredictor';
    private $depParserV2Url = 'https://aip.baidubce.com/rpc/2.0/nlp/v2/depparser';
    private $blessCreationUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/bless_creation';
    private $entityAnalysisUrl = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/entity_analysis';

    private $aipNlpUtf8Client;


    public function __construct($appId, $apiKey, $secretKey) {
        parent::__construct($appId, $apiKey, $secretKey);
        $this->aipNlpUtf8Client = new AipNlpUtf8($appId, $apiKey, $secretKey);
    }


    /**
     * 格式化结果
     * @param $content string
     * @return mixed
     */
    protected function proccessResult($content)
    {
        $result = null;
        $result = json_decode(mb_convert_encoding($content, 'UTF8', 'GBK'), true, 512, JSON_BIGINT_AS_STRING);
        if ($result == null) {
            $result = json_decode($content, true, 512, JSON_BIGINT_AS_STRING);
        }
        return $result;
    }

    /**
     * 词法分析接口
     *
     * @param string $text - 待分析文本（目前仅支持GBK编码），长度不超过65536字节
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function lexer($text, $options = array())
    {

        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->lexerUrl, $data);
    }

    /**
     * 词法分析（定制版）接口
     *
     * @param string $text - 待分析文本（目前仅支持GBK编码），长度不超过65536字节
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function lexerCustom($text, $options = array())
    {

        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->lexerCustomUrl, $data);
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
        return $this->aipNlpUtf8Client->depParser($text, $options);
    }

    /**
     * 词向量表示接口
     *
     * @param string $word - 文本内容（GBK编码），最大64字节
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function wordEmbedding($word, $options = array())
    {

        $data = array();

        $data['word'] = $word;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->wordEmbeddingUrl, $data);
    }

    /**
     * DNN语言模型接口
     *
     * @param string $text - 文本内容（GBK编码），最大512字节，不需要切词
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function dnnlm($text, $options = array())
    {

        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->dnnlmCnUrl, $data);
    }

    /**
     * 词义相似度接口
     *
     * @param string $word1 - 词1（GBK编码），最大64字节
     * @param string $word2 - 词1（GBK编码），最大64字节
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   mode 预留字段，可选择不同的词义相似度模型。默认值为0，目前仅支持mode=0
     * @return array
     */
    public function wordSimEmbedding($word1, $word2, $options = array())
    {

        $data = array();

        $data['word_1'] = $word1;
        $data['word_2'] = $word2;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->wordSimEmbeddingUrl, $data);
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
        return $this->aipNlpUtf8Client->simnet($text1, $text2, $options);
    }

    /**
     * 评论观点抽取接口
     *
     * @param string $text - 评论内容（GBK编码），最大10240字节
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   type 评论行业类型，默认为4（餐饮美食）
     * @return array
     */
    public function commentTag($text, $options = array())
    {

        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->commentTagUrl, $data);
    }

    /**
     * 情感倾向分析接口
     *
     * @param string $text - 文本内容（GBK编码），最大102400字节
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function sentimentClassify($text, $options = array())
    {

        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->sentimentClassifyUrl, $data);
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
        return $this->aipNlpUtf8Client->keyword($title, $content, $options);
    }

    /**
     * 文章分类接口
     *
     * @param string $title - 篇章的标题，最大80字节
     * @param string $content - 篇章的正文，最大65535字节
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function topic($title, $content, $options = array())
    {

        $data = array();

        $data['title'] = $title;
        $data['content'] = $content;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->topicUrl, $data);
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
        return $this->aipNlpUtf8Client->ecnet($text, $options);
    }

    /**
     * 对话情绪识别接口接口
     *
     * @param string $text - 待识别情感文本，输入限制512字节
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   scene default（默认项-不区分场景），talk（闲聊对话-如度秘聊天等），task（任务型对话-如导航对话等），customer_service（客服对话-如电信/银行客服等）
     * @return array
     */
    public function emotion($text, $options = array())
    {

        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->emotionUrl, $data);
    }

    /**
     * 新闻摘要接口接口
     *
     * @param string $content - 字符串（限3000字符数以内）字符串仅支持GBK编码，长度需小于3000字符数（即6000字节），请输入前确认字符数没有超限，若字符数超长会返回错误。正文中如果包含段落信息，请使用"\n"分隔，段落信息算法中有重要的作用，请尽量保留
     * @param integer $maxSummaryLen - 此数值将作为摘要结果的最大长度。例如：原文长度1000字，本参数设置为150，则摘要结果的最大长度是150字；推荐最优区间：200-500字
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     *   title 字符串（限200字符数）字符串仅支持GBK编码，长度需小于200字符数（即400字节），请输入前确认字符数没有超限，若字符数超长会返回错误。标题在算法中具有重要的作用，若文章确无标题，输入参数的“标题”字段为空即可
     * @return array
     */
    public function newsSummary($content, $maxSummaryLen, $options = array())
    {

        $data = array();

        $data['content'] = $content;
        $data['max_summary_len'] = $maxSummaryLen;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->newsSummaryUrl, $data);
    }

    /**
     * 地址识别接口接口
     *
     * @param string $text - 待识别的文本内容，不超过1000字节
     * @param array $options - 可选参数对象，key: value都为string类型
     * @description options列表:
     * @return array
     */
    public function address($text, $options = array())
    {

        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');
        $headers['Content-Encoding'] = "GBK";

        return $this->request($this->addressUrl, $data, $headers);
    }

    /**
     * 评论观点抽取（定制）
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/ok6z52g8q
     */
    public function commentTagCustom($text, $options = array())
    {
        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->commentTagCustomUrl, $data);
    }

    /**
     * 情感倾向分析（定制）
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/zk6z52hds
     */
    public function sentimentClassifyCustom($text, $options = array())
    {
        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->sentimentClassifyCustomUrl, $data);
    }

    /**
     * 智能春联
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/Ok53wb6dh
     */
    public function couplets($text, $options = array())
    {
        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->coupletsUrl, $data);
    }

    /**
     * 智能写诗
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/ak53wc3o3
     */
    public function poem($text, $options = array())
    {
        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->poemUrl, $data);
    }

    /**
     * 实体抽取与情感倾向分析
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/Fk6z52g04
     */
    public function entityLevelSentiment($title, $content, $type, $options = array())
    {
        $data = array();

        $data['title'] = $title;
        $data['content'] = $content;
        $data['type'] = $type;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->entityLevelSentimentUrl, $data);
    }

    /**
     * 增加实体/实体库新增
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/Fk6z52g04#%E5%AE%9E%E4%BD%93%E5%BA%93%E6%96%B0%E5%A2%9E%E6%8E%A5%E5%8F%A3
     */
    public function entityLevelSentimentAdd($repository, $entities, $options = array())
    {
        $data = array();

        $data['repository'] = $repository;
        $data['entities'] = $entities;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->entityLevelSentimentAddUrl, $data);
    }

    /**
     * 删除实体/实体名单删除
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/Fk6z52g04#%E5%AE%9E%E4%BD%93%E5%90%8D%E5%8D%95%E5%88%A0%E9%99%A4%E6%8E%A5%E5%8F%A3
     */
    public function entityLevelSentimentDelete($repository, $entities, $options = array())
    {
        $data = array();

        $data['repository'] = $repository;
        $data['entities'] = $entities;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->entityLevelSentimentDeleteUrl, $data);
    }

    /**
     * 删除实体库/实体库删除
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/Fk6z52g04#%E5%AE%9E%E4%BD%93%E5%BA%93%E5%88%A0%E9%99%A4%E6%8E%A5%E5%8F%A3
     */
    public function entityLevelSentimentDeleteRepo($repositories, $options = array())
    {
        $data = array();

        $data['repositories'] = $repositories;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->entityLevelSentimentDeleteRepoUrl, $data);
    }

    /**
     * 实体库列表/实体库查询
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/Fk6z52g04#%E5%AE%9E%E4%BD%93%E5%BA%93%E6%9F%A5%E8%AF%A2%E6%8E%A5%E5%8F%A3
     */
    public function entityLevelSentimentList($options = array())
    {
        $data = array();

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->entityLevelSentimentListUrl, $data);
    }

    /**
     * 查询实体/实体名单查询
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/Fk6z52g04#%E5%AE%9E%E4%BD%93%E5%90%8D%E5%8D%95%E6%9F%A5%E8%AF%A2%E6%8E%A5%E5%8F%A3
     */
    public function entityLevelSentimentQuery($repository, $options = array())
    {
        $data = array();

        $data['repository'] = $repository;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->entityLevelSentimentQueryUrl, $data);
    }

    /**
     * 文章主题短语生成
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/9k53w3qob
     */
    public function topicPhrase($title, $summary, $options = array())
    {
        return $this->aipNlpUtf8Client->topicPhrase($title, $summary, $options);
    }

    /**
     * 智能招聘-简历解析
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/Xkahvfeqa
     */
    public function recruitmentCvparser($resume, $options = array())
    {
        $data = array();

        $data['resume'] = $resume;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->cvparserUrl, $data);
    }

    /**
     * 智能招聘-人岗匹配
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/Pkahwzux5
     */
    public function recruitmentPersonPost($resume, $job_description, $options = array())
    {
        $data = array();

        $data['resume'] = $resume;
        $data['job_description'] = $job_description;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->personPostUrl, $data);
    }

    /**
     * 智能招聘-简历画像
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/5kc1kmz3w
     */
    public function recruitmentPersonas($resume, $options = array())
    {
        $data = array();

        $data['resume'] = $resume;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->personasUrl, $data);
    }

    /**
     * 文章标题生成
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/0kvc1u1eg
     */
    public function titlepredictor($doc, $options = array())
    {
        $data = array();

        $data['doc'] = $doc;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->titlepredictorUrl, $data);
    }

    /**
     * 依存句法分析V2
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/nk6z52eu6
     */
    public function depParserV2($text, $options = array())
    {
        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->depParserV2Url, $data);
    }

    /**
     * 祝福语生成
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/sl4cg75jk
     */
    public function blessCreation($text, $options = array())
    {
        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->blessCreationUrl, $data);
    }

    /**
     * 实体分析
     * 接口文档链接: https://ai.baidu.com/ai-doc/NLP/al631z295
     */
    public function entityAnalysis($text, $options = array())
    {
        $data = array();

        $data['text'] = $text;

        $data = array_merge($data, $options);
        $data = mb_convert_encoding(json_encode($data), 'GBK', 'UTF8');

        return $this->request($this->entityAnalysisUrl, $data);
    }
}