<?php
declare(strict_types=1);
// +----------------------------------------------------------------------
// | Created by PhpStorm.
// +----------------------------------------------------------------------
// | user : JYF
// +----------------------------------------------------------------------
// | blog : blog.jianjiana.cn
// +----------------------------------------------------------------------
// | email: 1749934563@qq.com
// +----------------------------------------------------------------------
// | Date : 2022/2/24
// +----------------------------------------------------------------------

namespace ToolPackage\Tool\Http;

class Request
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var array
     */
    private $header = [];

    /**
     * @var string
     */
    private $output = '';

    /**
     * @var string
     */
    private $http_info = '';

    /**
     * @var string
     */
    private $error = '';

    /**
     * @var int
     */
    private $timeout = 30;

    /**
     * @var resource|false
     */
    private $curl_ch;

    public function __construct()
    {
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function setTimeout(int $timeout = 30): self
    {
        $this->timeout = $timeout;
        return $this;
    }

    public function setHeader(array $header = []): self
    {
        $this->header = $header;
        return $this;
    }

    public function addHeader(array $header = []): self
    {
        $this->header = array_merge($this->header, $header);
        return $this;
    }


    public function getBody(): string
    {
        return $this->output;
    }

    public function getBodyToArray(): array
    {
        return json_decode($this->output, true);
    }

    public function getHttpInfo(): string
    {
        return $this->http_info;
    }


    public function getError(): string
    {
        return $this->error;
    }

    private function curlInit()
    {
        $this->curl_ch = $curl_ch = curl_init();
        curl_setopt($curl_ch, CURLOPT_URL, $this->url);
        if (substr($this->url, 0, 5) == 'https') {
            curl_setopt($curl_ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl_ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        curl_setopt($curl_ch, CURLOPT_TIMEOUT, $this->timeout);
        if ($this->header) {
            curl_setopt($curl_ch, CURLOPT_HTTPHEADER, $this->header);
        }
        //只取body头
        curl_setopt($curl_ch, CURLOPT_RETURNTRANSFER, 1);
        return $this->curl_ch;
    }

    private function curlClose(): void
    {
        curl_close($this->curl_ch);
    }

    private function exec(): void
    {
        $this->output = curl_exec($this->curl_ch);
        $this->http_info = curl_getinfo($this->curl_ch);
        $this->error = curl_errno($this->curl_ch);
    }

    private function setMethod($curl_ch, string $type = 'POST')
    {
        if ('POST' === $type) {
            curl_setopt($curl_ch, CURLOPT_POST, true);
        } else {
            curl_setopt($curl_ch, CURLOPT_HEADER, 0);
            curl_setopt($curl_ch, CURLOPT_NOBODY, 0);
        }
    }

    public function get(array $data = []): self
    {
        $data && ($this->url .= '?' . http_build_query($data));
        $this->curl_ch = $this->curlInit();
        $this->setMethod($this->curl_ch, 'GET');
        //只取body头
        $this->exec();
        $this->curlClose();
        return $this;
    }

    public function post($data = null): self
    {
        $this->curl_ch = $this->curlInit();
        $this->setMethod($this->curl_ch, 'POST');
        if($data){
            curl_setopt($this->curl_ch, CURLOPT_POSTFIELDS, $data);
        }
        $this->exec();
        $this->curlClose();
        return $this;
    }

    /**
     * @param array $data
     * @param callable|null $getContentAfter
     * @return array
     * @author JYF 2022/2/24 17:18
     */
    public function multi(array $data, ?callable $getContentAfter = null): array
    {
        $chs_arr = [];
        $resArr = [];
        foreach ($data as $curlData) {
            $chs = curl_init();
            curl_setopt($chs, CURLOPT_URL, $curlData['url']);
            curl_setopt($chs, CURLOPT_TIMEOUT, $curlData['timeout'] ?? 0.5);
            curl_setopt($chs, CURLOPT_HEADER, 0);
            curl_setopt($chs, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($chs, CURLOPT_RETURNTRANSFER, 1);
            if ('POST' === $curlData['method']) {
                curl_setopt($chs, CURLOPT_POST, 1);
                curl_setopt($chs, CURLOPT_POSTFIELDS, $curlData['data']);
            }

            if(isset($curlData['headers']) && !empty($curlData['headers'])){
                curl_setopt($chs, CURLOPT_HTTPHEADER, $curlData['headers']);
            }

            array_push($chs_arr, $chs);
        }
        $mh = curl_multi_init();
        if ($mh && !empty($chs_arr)) {
            foreach ($chs_arr as $k => $v) {
                // 增加句柄
                curl_multi_add_handle($mh, $v);
            }

            // 执行批处理句柄
            $active = null;
            do {
                $mrc = curl_multi_exec($mh, $active);//当无数据，active=true
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);//当正在接受数据时

            while ($active && $mrc == CURLM_OK) {//当无数据时或请求暂停时，active=true
                if (curl_multi_select($mh) != -1) {
                    do {
                        $mrc = curl_multi_exec($mh, $active);
                    } while ($mrc == CURLM_CALL_MULTI_PERFORM);
                }
            }
            // 读取数据
            foreach ($chs_arr as $get_ch) {
                $content = curl_multi_getcontent($get_ch);
                if (is_callable($getContentAfter)) {
                    $getContentAfter($content);
                }
                $resArr[] = [
                    'output' => $content,
                    'http_info' => curl_getinfo($get_ch),
                    'error' => curl_errno($get_ch),
                ];
                curl_multi_remove_handle($mh, $get_ch);
            }
            // 关闭全部句柄
            curl_multi_close($mh);
        }
        return $resArr;
    }

}