<?php

namespace AiomaticOpenAI\OpenRouter;

defined('ABSPATH') or die();
use Exception;

#[AllowDynamicProperties]
class OpenRouter
{
    private $engine = "davinci";
    private $model = "gpt-3.5-turbo-instruct";
    private $chatModel = "gpt-3.5-turbo";
    private $headers;
    private $headers2;
    private $contentTypes;
    private $timeout = 0;
    private $stream_method;
    private $customUrlOpenRouter = "";
    private $proxy = "";
    private $curlInfo = [];
    public function __construct($OPENAI_API_KEY)
    {
        $this->contentTypes = [
            "application/json"    => "Content-Type: application/json",
            "multipart/form-data" => "Content-Type: multipart/form-data",
        ];

        $this->headers = [
            $this->contentTypes["application/json"],
            "Authorization: Bearer $OPENAI_API_KEY",
        ];

        $this->headers2 = [
            "Content-Type" => $this->contentTypes["application/json"],
            "Authorization" => "Bearer $OPENAI_API_KEY",
        ];
    }

    /**
     * @return array
     * Remove this method from your code before deploying
     */
    public function getCURLInfo()
    {
        return $this->curlInfo;
    }

    /**
     * @return bool|string
     */
    public function listModels()
    {
        $url = UrlOpenRouter::fineTuneModel();
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'GET');
    }

    /**
     * @param $model
     * @return bool|string
     */
    public function retrieveModel($model)
    {
        $model = "/$model";
        $url   = UrlOpenRouter::fineTuneModel().$model;
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'GET');
    }

    /**
     * @param $opts
     * @return bool|string
     * @deprecated
     */
    public function complete($opts)
    {
        $engine = $opts['engine'] ?? $this->engine;
        $url    = UrlOpenRouter::completionURL($engine);
        unset($opts['engine']);
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * Create speech from text.
     * 
     * @param array $opts Options for speech generation.
     * @return bool|string
     */
    public function createSpeech(array $opts) 
    {
        $url = UrlOpenRouter::speechUrl();
        
        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @param        $opts
     * @param  null  $stream
     * @return bool|string
     * @throws Exception
     */
    public function completion($opts, $stream = null)
    {
        if ($stream != null && array_key_exists('stream', $opts)) {
            if (!$opts['stream']) {
                throw new Exception(
                    'Please provide a stream function. Check https://github.com/orhanerday/open-ai#stream-example for an example.'
                );
            }

            $this->stream_method = $stream;
        }

        $opts['model'] = $opts['model'] ?? $this->model;
        $url           = UrlOpenRouter::completionsURL();
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @param $opts
     * @return bool|string
     */
    public function createEdit($opts)
    {
        $url = UrlOpenRouter::editsUrl();
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @param $opts
     * @return bool|string
     */
    public function image($opts)
    {
        $url = UrlOpenRouter::imageUrl()."/generations";
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @param $opts
     * @return bool|string
     */
    public function imageEdit($opts)
    {
        $url = UrlOpenRouter::imageUrl()."/edits";
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @param $opts
     * @return bool|string
     */
    public function createImageVariation($opts)
    {
        $url = UrlOpenRouter::imageUrl()."/variations";
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @param $opts
     * @return bool|string
     * @deprecated
     */
    public function search($opts)
    {
        $engine = $opts['engine'] ?? $this->engine;
        $url    = UrlOpenRouter::searchURL($engine);
        unset($opts['engine']);
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @param $opts
     * @return bool|string
     * @deprecated
     */
    public function answer($opts)
    {
        $url = UrlOpenRouter::answersUrl();
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @param $opts
     * @return bool|string
     * @deprecated
     */
    public function classification($opts)
    {
        $url = UrlOpenRouter::classificationsUrl();
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @param $opts
     * @return bool|string
     */
    public function moderation($opts)
    {
        $url = UrlOpenRouter::moderationUrl();
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @param        $opts
     * @param  null  $stream
     * @return bool|string
     * @throws Exception
     */
    public function chat($opts, $stream = null)
    {
        if ($stream != null && array_key_exists('stream', $opts)) {
            if (!$opts['stream']) {
                throw new Exception(
                    'Please provide a stream function. Check https://github.com/orhanerday/open-ai#stream-example for an example.'
                );
            }

            $this->stream_method = $stream;
        }

        $opts['model'] = $opts['model'] ?? $this->chatModel;
        $url           = UrlOpenRouter::chatUrl();
        $this->baseUrlOpenRouter($url);
        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @param $opts
     * @return bool|string
     */
    public function transcribe($opts)
    {
        $url = UrlOpenRouter::transcriptionsUrl();
        $this->baseUrlOpenRouter($url);

        return $this->sendRequestAlt($url, 'POST', $opts);
    }

    /**
     * @param $opts
     * @return bool|string
     */
    public function translate($opts)
    {
        $url = UrlOpenRouter::translationsUrl();
        $this->baseUrlOpenRouter($url);

        return $this->sendRequestAlt($url, 'POST', $opts);
    }

    /**
     * @param $opts
     * @return bool|string
     */
    public function uploadFile($opts)
    {
        $url = UrlOpenRouter::filesUrl();
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @return bool|string
     */
    public function listFiles($opts = array())
    {
        $url = UrlOpenRouter::filesUrl();
        if(!empty($opts))
        {
            $queryString = http_build_query($opts);
            $url = $url . '?' . $queryString;
        }
        $this->baseUrlOpenRouter($url);
        return $this->sendRequest($url, 'GET');
    }

    /**
     * @param $file_id
     * @return bool|string
     */
    public function retrieveFile($file_id)
    {
        $file_id = "/$file_id";
        $url     = UrlOpenRouter::filesUrl().$file_id;
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'GET');
    }

    /**
     * @param $file_id
     * @return bool|string
     */
    public function retrieveFileContent($file_id)
    {
        $file_id = "/$file_id/content";
        $url     = UrlOpenRouter::filesUrl().$file_id;
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'GET');
    }

    /**
     * @param $file_id
     * @return bool|string
     */
    public function deleteFile($file_id)
    {
        $file_id = "/$file_id";
        $url     = UrlOpenRouter::filesUrl().$file_id;
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'DELETE');
    }

    /**
     * @param $opts
     * @return bool|string
     */
    public function createFineTune($opts)
    {
        $url = UrlOpenRouter::fineTuneUrl();
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @return bool|string
     */
    public function listFineTunes()
    {
        $url = UrlOpenRouter::fineTuneUrl();
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'GET');
    }

    /**
     * @param $fine_tune_id
     * @return bool|string
     */
    public function retrieveFineTune($fine_tune_id)
    {
        $fine_tune_id = "/$fine_tune_id";
        $url          = UrlOpenRouter::fineTuneUrl().$fine_tune_id;
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'GET');
    }

    /**
     * @param $fine_tune_id
     * @return bool|string
     */
    public function cancelFineTune($fine_tune_id)
    {
        $fine_tune_id = "/$fine_tune_id/cancel";
        $url          = UrlOpenRouter::fineTuneUrl().$fine_tune_id;
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'POST');
    }

    /**
     * @param $fine_tune_id
     * @return bool|string
     */
    public function listFineTuneEvents($fine_tune_id)
    {
        $fine_tune_id = "/$fine_tune_id/events";
        $url          = UrlOpenRouter::fineTuneUrl().$fine_tune_id;
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'GET');
    }

    /**
     * @param $fine_tune_id
     * @return bool|string
     */
    public function deleteFineTune($fine_tune_id)
    {
        $fine_tune_id = "/$fine_tune_id";
        $url          = UrlOpenRouter::fineTuneModel().$fine_tune_id;
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'DELETE');
    }

    /**
     * @param
     * @return bool|string
     * @deprecated
     */
    public function engines()
    {
        $url = UrlOpenRouter::enginesUrl();
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'GET');
    }

    /**
     * @param $engine
     * @return bool|string
     * @deprecated
     */
    public function engine($engine)
    {
        $url = UrlOpenRouter::engineUrl($engine);
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'GET');
    }

    /**
     * @param $opts
     * @return bool|string
     */
    public function embeddings($opts)
    {
        $url = UrlOpenRouter::embeddings();
        $this->baseUrlOpenRouter($url);

        return $this->sendRequest($url, 'POST', $opts);
    }

    /**
     * @param  int  $timeout
     */
    public function setTimeout(int $timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * @param  string  $proxy
     */
    public function setProxy(string $proxy)
    {
        if ($proxy && strpos($proxy, '://') === false) {
            $proxy = 'https://'.$proxy;
        }
        $this->proxy = $proxy;
    }

    /**
     * @param  string  $customUrlOpenRouter
     * @deprecated
     */

    /**
     * @param  string  $customUrlOpenRouter
     * @return void
     */
    public function setCustomURL(string $customUrlOpenRouter)
    {
        if ($customUrlOpenRouter != "") {
            $this->customUrlOpenRouter = $customUrlOpenRouter;
        }
    }

    /**
     * @param  string  $customUrlOpenRouter
     * @return void
     */
    public function setBaseURL(string $customUrlOpenRouter)
    {
        if ($customUrlOpenRouter != '') {
            $this->customUrlOpenRouter = $customUrlOpenRouter;
        }
    }

    /**
     * @param  array  $header
     * @return void
     */
    public function setHeader(array $header)
    {
        if ($header) {
            foreach ($header as $key => $value) {
                $this->headers[$key] = $value;
            }
        }
    }

    /**
     * @param  string  $org
     */
    public function setORG(string $org)
    {
        if ($org != "") {
            $this->headers[] = "OpenAI-Organization: $org";
        }
    }

    /**
     * @param  string  $url
     * @param  string  $method
     * @param  array   $opts
     * @return bool|string
     */
    private function sendRequest(string $url, string $method, array $opts = [])
    {
        $post_fields = json_encode($opts);
        
        if (array_key_exists('file', $opts) || array_key_exists('image', $opts)) {
            $this->headers[0] = $this->contentTypes["multipart/form-data"];
            $post_fields      = $opts;
        } else {
            $this->headers[0] = $this->contentTypes["application/json"];
        }
        $curl_info = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_POSTFIELDS     => $post_fields,
            CURLOPT_HTTPHEADER     => $this->headers,
        ];

        if ($opts == []) {
            unset($curl_info[CURLOPT_POSTFIELDS]);
        }

        if (!empty($this->proxy)) {
            $curl_info[CURLOPT_PROXY] = $this->proxy;
        }

        if (array_key_exists('stream', $opts) && $opts['stream']) {
            $curl_info[CURLOPT_WRITEFUNCTION] = $this->stream_method;
        }

        $curl = curl_init();

        curl_setopt_array($curl, $curl_info);

        $aiomatic_Main_Settings = get_option('aiomatic_Main_Settings', false);
        if (isset($aiomatic_Main_Settings['proxy_ai']) && $aiomatic_Main_Settings['proxy_ai'] == 'on' && isset($aiomatic_Main_Settings['proxy_url']) && $aiomatic_Main_Settings['proxy_url'] != '' && $aiomatic_Main_Settings['proxy_url'] != 'disable' && $aiomatic_Main_Settings['proxy_url'] != 'disabled')
        {
            $prx = explode(',', $aiomatic_Main_Settings['proxy_url']);
            $randomness = array_rand($prx);
            curl_setopt($curl, CURLOPT_PROXY , trim($prx[$randomness]));
            if (isset($aiomatic_Main_Settings['proxy_auth']) && $aiomatic_Main_Settings['proxy_auth'] != '') 
            {
                $prx_auth = explode(',', $aiomatic_Main_Settings['proxy_auth']);
                if(isset($prx_auth[$randomness]) && trim($prx_auth[$randomness]) != '')
                {
                    curl_setopt($curl, CURLOPT_PROXYUSERPWD , trim($prx_auth[$randomness]));
                }
            }
        }

        $response = curl_exec($curl);

        $info           = curl_getinfo($curl);
        $this->curlInfo = $info;

        curl_close($curl);

        return $response;
    }

    public function create_body_for_file($file, $boundary)
    {
        $fields = array(
            'purpose' => 'fine-tune',
            'file' => $file['filename']
        );

        $body = '';
        foreach ($fields as $name => $value) {
            $body .= "--$boundary\r\n";
            $body .= "Content-Disposition: form-data; name=\"$name\"";
            if ($name == 'file') {
                $body .= "; filename=\"{$value}\"\r\n";
                $body .= "Content-Type: application/json\r\n\r\n";
                $body .= $file['data'] . "\r\n";
            } else {
                $body .= "\r\n\r\n$value\r\n";
            }
        }
        $body .= "--$boundary--\r\n";
        return $body;
    }
    public function create_body_for_audio($file, $boundary, $fields)
    {
        $fields['file'] = $file['filename'];
        unset($fields['audio']);
        $body = '';
        foreach ($fields as $name => $value) {
            $body .= "--$boundary\r\n";
            $body .= "Content-Disposition: form-data; name=\"$name\"";
            if ($name == 'file') {
                $body .= "; filename=\"{$value}\"\r\n";
                $body .= "Content-Type: application/json\r\n\r\n";
                $body .= $file['data'] . "\r\n";
            } else {
                $body .= "\r\n\r\n$value\r\n";
            }
        }
        $body .= "--$boundary--\r\n";
        return $body;
    }
    private function sendRequestAlt(string $url, string $method, array $opts = [])
    {
        $post_fields = json_encode($opts);
        
        if (array_key_exists('file', $opts) || array_key_exists('image', $opts)) {
            $boundary = wp_generate_password(24, false);
            $this->headers2['Content-Type'] = 'multipart/form-data; boundary='.$boundary;
            $post_fields = $this->create_body_for_file($opts['file'], $boundary);
        }
        elseif (array_key_exists('audio', $opts)) {
            $boundary = wp_generate_password(24, false);
            $this->headers2['Content-Type'] = 'multipart/form-data; boundary='.$boundary;
            $post_fields = $this->create_body_for_audio($opts['audio'], $boundary, $opts);
        } else {
            $this->headers2['Content-Type'] = 'application/json';
        }
        $request_options = array(
            'headers' => $this->headers2,
            'method' => $method,
            'body' => $post_fields,
            'timeout'     => 900,
            'redirection' => 10,
            'httpversion' => '1.1',
        );
        if($post_fields == '[]'){
            unset($request_options['body']);
        }
        add_action('http_api_curl', 'aiomatic_add_proxy');
        $response = wp_remote_request($url, $request_options);
        remove_action('http_api_curl', 'aiomatic_add_proxy');
        if(is_wp_error($response)){
            return json_encode(array('error' => array('message' => $response->get_error_message())));
        }
        else{
            return wp_remote_retrieve_body($response);
        }

        return $response;
    }

    /**
     * @param  string  $url
     */
    private function baseUrlOpenRouter(string &$url)
    {
        if ($this->customUrlOpenRouter != "") {
            $url = str_replace(UrlOpenRouter::ORIGIN, $this->customUrlOpenRouter, $url);
        }
    }
}
