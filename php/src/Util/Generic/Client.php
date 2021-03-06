<?php

// This file is auto-generated, don't edit it. Thanks.
namespace Alipay\EasySDK\Util\Generic;

use Alipay\EasySDK\Kernel\EasySDKKernel;
use Alipay\EasySDK\Kernel\Util\Signer;
use AlibabaCloud\Tea\Tea;
use AlibabaCloud\Tea\Request;
use AlibabaCloud\Tea\Exception\TeaError;
use \Exception;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;

use Alipay\EasySDK\Util\Generic\Models\AlipayOpenApiGenericResponse;
use AlibabaCloud\Tea\Response;
use Alipay\EasySDK\Util\Generic\Models\AlipayOpenApiGenericSDKResponse;

class Client {
    protected $_kernel;

    public function __construct($kernel){
        $this->_kernel = $kernel;
    }

    /**
     * @param string $method
     * @param string[] $textParams
     * @param mixed[] $bizParams
     * @return AlipayOpenApiGenericResponse
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     */
    public function execute($method, $textParams, $bizParams){
        $_runtime = [
            "ignoreSSL" => $this->_kernel->getConfig("ignoreSSL"),
            "httpProxy" => $this->_kernel->getConfig("httpProxy"),
            "connectTimeout" => 15000,
            "readTimeout" => 15000,
            "retry" => [
                "maxAttempts" => 0
            ]
        ];
        $_lastRequest = null;
        $_lastException = null;
        $_now = time();
        $_retryTimes = 0;
        while (Tea::allowRetry(@$_runtime["retry"], $_retryTimes, $_now)) {
            if ($_retryTimes > 0) {
                $_backoffTime = Tea::getBackoffTime(@$_runtime["backoff"], $_retryTimes);
                if ($_backoffTime > 0) {
                    Tea::sleep($_backoffTime);
                }
            }
            $_retryTimes = $_retryTimes + 1;
            try {
                $_request = new Request();
                $systemParams = [
                    "method" => $method,
                    "app_id" => $this->_kernel->getConfig("appId"),
                    "timestamp" => $this->_kernel->getTimestamp(),
                    "format" => "json",
                    "version" => "1.0",
                    "alipay_sdk" => $this->_kernel->getSdkVersion(),
                    "charset" => "UTF-8",
                    "sign_type" => $this->_kernel->getConfig("signType"),
                    "app_cert_sn" => $this->_kernel->getMerchantCertSN(),
                    "alipay_root_cert_sn" => $this->_kernel->getAlipayRootCertSN()
                ];
                $_request->protocol = $this->_kernel->getConfig("protocol");
                $_request->method = "POST";
                $_request->pathname = "/gateway.do";
                $_request->headers = [
                    "host" => $this->_kernel->getConfig("gatewayHost"),
                    "content-type" => "application/x-www-form-urlencoded;charset=utf-8"
                ];
                $_request->query = $this->_kernel->sortMap(Tea::merge([
                    "sign" => $this->_kernel->sign($systemParams, $bizParams, $textParams, $this->_kernel->getConfig("merchantPrivateKey"))
                ], $systemParams, $textParams));
                $_request->body = $this->_kernel->toUrlEncodedRequestBody($bizParams);
                $_lastRequest = $_request;
                $_response= Tea::send($_request, $_runtime);
                $respMap = $this->_kernel->readAsJson($_response, $method);
                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayOpenApiGenericResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig("alipayPublicKey"))) {
                        return AlipayOpenApiGenericResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    "message" => "????????????????????????????????????????????????????????????"
                ]);
            }
            catch (Exception $e) {
                if (!($e instanceof TeaError)) {
                    $e = new TeaError([], $e->getMessage(), $e->getCode(), $e);
                }
                if (Tea::isRetryable($e)) {
                    $_lastException = $e;
                    continue;
                }
                throw $e;
            }
        }
        throw new TeaUnableRetryError($_lastRequest, $_lastException);
    }

    /**
     * @param string $method
     * @param string[] $textParams
     * @param mixed[] $bizParams
     * @param string[] $fileParams
     * @return AlipayOpenApiGenericResponse
     * @throws TeaError
     * @throws Exception
     * @throws TeaUnableRetryError
     */
    public function fileExecute($method, $textParams, $bizParams, $fileParams){
        $_runtime = [
            "ignoreSSL" => $this->_kernel->getConfig("ignoreSSL"),
            "httpProxy" => $this->_kernel->getConfig("httpProxy"),
            "connectTimeout" => 100000,
            "readTimeout" => 100000,
            "retry" => [
                "maxAttempts" => 0
            ]
        ];
        $_lastRequest = null;
        $_lastException = null;
        $_now = time();
        $_retryTimes = 0;
        while (Tea::allowRetry(@$_runtime["retry"], $_retryTimes, $_now)) {
            if ($_retryTimes > 0) {
                $_backoffTime = Tea::getBackoffTime(@$_runtime["backoff"], $_retryTimes);
                if ($_backoffTime > 0) {
                    Tea::sleep($_backoffTime);
                }
            }
            $_retryTimes = $_retryTimes + 1;
            try {
                $_request = new Request();
                $systemParams = [
                    "method" => $method,
                    "app_id" => $this->_kernel->getConfig("appId"),
                    "timestamp" => $this->_kernel->getTimestamp(),
                    "format" => "json",
                    "version" => "1.0",
                    "alipay_sdk" => $this->_kernel->getSdkVersion(),
                    "charset" => "UTF-8",
                    "sign_type" => $this->_kernel->getConfig("signType"),
                    "app_cert_sn" => $this->_kernel->getMerchantCertSN(),
                    "alipay_root_cert_sn" => $this->_kernel->getAlipayRootCertSN()
                ];
                $boundary = $this->_kernel->getRandomBoundary();
                $_request->protocol = $this->_kernel->getConfig("protocol");
                $_request->method = "POST";
                $_request->pathname = "/gateway.do";
                $_request->headers = [
                    "host" => $this->_kernel->getConfig("gatewayHost"),
                    "content-type" => $this->_kernel->concatStr("multipart/form-data;charset=utf-8;boundary=", $boundary)
                ];
                $_request->query = $this->_kernel->sortMap(Tea::merge([
                    "sign" => $this->_kernel->sign($systemParams, $bizParams, $textParams, $this->_kernel->getConfig("merchantPrivateKey"))
                ], $systemParams, $textParams));
                $_request->body = $this->_kernel->toMultipartRequestBody($textParams, $fileParams, $boundary);
                $_lastRequest = $_request;
                $_response= Tea::send($_request, $_runtime);
                $respMap = $this->_kernel->readAsJson($_response, $method);
                if ($this->_kernel->isCertMode()) {
                    if ($this->_kernel->verify($respMap, $this->_kernel->extractAlipayPublicKey($this->_kernel->getAlipayCertSN($respMap)))) {
                        return AlipayOpenApiGenericResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                else {
                    if ($this->_kernel->verify($respMap, $this->_kernel->getConfig("alipayPublicKey"))) {
                        return AlipayOpenApiGenericResponse::fromMap($this->_kernel->toRespModel($respMap));
                    }
                }
                throw new TeaError([
                    "message" => "????????????????????????????????????????????????????????????"
                ]);
            }
            catch (Exception $e) {
                if (!($e instanceof TeaError)) {
                    $e = new TeaError([], $e->getMessage(), $e->getCode(), $e);
                }
                if (Tea::isRetryable($e)) {
                    $_lastException = $e;
                    continue;
                }
                throw $e;
            }
        }
        throw new TeaUnableRetryError($_lastRequest, $_lastException);
    }

    /**
     * @param string $method
     * @param string[] $textParams
     * @param mixed[] $bizParams
     * @return AlipayOpenApiGenericSDKResponse
     */
    public function sdkExecute($method, $textParams, $bizParams){
        $_request = new Request();
        $systemParams = [
            "method" => $method,
            "app_id" => $this->_kernel->getConfig("appId"),
            "timestamp" => $this->_kernel->getTimestamp(),
            "format" => "json",
            "version" => "1.0",
            "alipay_sdk" => $this->_kernel->getSdkVersion(),
            "charset" => "UTF-8",
            "sign_type" => $this->_kernel->getConfig("signType"),
            "app_cert_sn" => $this->_kernel->getMerchantCertSN(),
            "alipay_root_cert_sn" => $this->_kernel->getAlipayRootCertSN()
        ];
        $sign = $this->_kernel->sign($systemParams, $bizParams, $textParams, $this->_kernel->getConfig("merchantPrivateKey"));
        $response = [
            "body" => $this->_kernel->generateOrderString($systemParams, $bizParams, $textParams, $sign)
        ];
        return AlipayOpenApiGenericSDKResponse::fromMap($response);
        $_lastRequest = $_request;
        $_response= Tea::send($_request);
    }

    /**
     * [verify ????????????my.getPhoneNumber?????????????????????????????????]
     * @param  string $response [????????????????????????response]
     * @return bool             [?????????????????????true: ?????????false: ??????]
     */
    public function verify($response)
    {
        $alipayPublicKey = $this->_kernel->getConfig("alipayPublicKey");
        $signer = new Signer();
        $params = json_decode($response, true);
        return $signer->verifyEncryptedParams($params, $alipayPublicKey);
    }

    /**
     * ISV????????????????????????appAuthToken
     *
     * @param $appAuthToken String ?????????token
     * @return $this ?????????????????????????????????
     */
    public function agent($appAuthToken)
    {
        $this->_kernel->injectTextParam("app_auth_token", $appAuthToken);
        return $this;
    }

    /**
    * ???????????????????????????authToken
    *
    * @param $authToken String ????????????token
    * @return $this
    */
    public function auth($authToken)
    {
        $this->_kernel->injectTextParam("auth_token", $authToken);
        return $this;
    }

    /**
    * ?????????????????????????????????????????????????????????????????????Config??????????????????
    *
    * @param $url String ????????????????????????????????????https://www.test.com/callback
    * @return $this
    */
    public function asyncNotify($url)
    {
        $this->_kernel->injectTextParam("notify_url", $url);
        return $this;
    }

    /**
    * ????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
    *
    * @param $testUrl String ????????????????????????
    * @return $this
    */
    public function route($testUrl)
    {
        $this->_kernel->injectTextParam("ws_service_url", $testUrl);
        return $this;
    }

    /**
    * ??????API????????????????????????????????????????????????(biz_content????????????)
    *
    * @param $key   String ???????????????????????????biz_content????????????????????????timeout_express???
    * @param $value object ???????????????????????????????????????????????????JSON?????????
    *               ??????????????????????????????????????????String???Price???Date???SDK?????????????????????????????????String??????
    *               ???????????????????????????????????????????????????Number???????????????Long??????
    *               ?????????????????????????????????????????????????????????array???????????????????????????
    *               ??????????????????????????????????????????array???????????????
    * @return $this
    */
    public function optional($key, $value)
    {
        $this->_kernel->injectBizParam($key, $value);
        return $this;
    }

    /**
    * ????????????API????????????????????????????????????????????????(biz_content????????????)
    * optional?????????????????????
    *
    * @param $optionalArgs array ????????????????????????????????????key???value?????????key???value??????????????????optional???????????????
    * @return $this
    */
    public function batchOptional($optionalArgs)
    {
        foreach ($optionalArgs as $key => $value) {
            $this->_kernel->injectBizParam($key, $value);
        }
        return $this;
    }

}