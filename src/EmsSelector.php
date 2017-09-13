<?php namespace Ems;
/**
 * Created by PhpStorm.
 * User: 都大爽
 * Date: 2017/1/25
 * Time: 17:06
 */

/**
 * Class EmsSelector
 * @package Ems
 */
class EmsSelector {

    /**
     * 调用查询地址
     * @var
     */
    public $host;


    /**
     * 调用方式,get ,post
     * @var
     */
    public $method;


    /**
     * 阿里云appCode
     * @var
     */
    public $appCode;


    /**
     * 查询条件
     * @var
     */
    public $query;


    /**
     * 快递公司
     * @var
     */
    public $emsCompany;


    /**
     * 快递单号
     * @var
     */
    public $emsNumber;


    /**
     * 查询地址
     * @var
     */
    public $url;


    /**
     * EmsSelector constructor.
     * @param string $emsCompany
     * @param $emsNumber
     */
    public function __construct($emsNumber , $emsCompany = 'auto')
    {
        $this->host = 'http://ali-deliver.showapi.com/showapi_expInfo';
        $this->method = 'GET';
        $this->appCode = env('ALIYUN_EMS_APPCODE');
        $this->emsCompany = $emsCompany;
        $this->emsNumber = $emsNumber;
        $this->query = 'com='.$this->emsCompany.'&nu='.$this->emsNumber;
        $this->url = $this->host.'?'.$this->query;
    }


    /**
     * 快递查询
     * @return mixed
     */
    public function getSelectEms()
    {
        $headers = [];
        array_push($headers, "Authorization:APPCODE " . $this->appCode);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        try{
            $result = curl_exec($curl);
            $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
            curl_close();
            return substr($result, $headerSize);
        } catch (\Exception $e) {
            curl_close();
            \Log::error($e->getMessage());
        }
    }
}
