<?php
class AiomaticHuggingFaceSDK
{
    protected $apiKey;
    protected $baseUrl = 'https://api-inference.huggingface.co/models/';
    protected $env;
    protected $model;
    protected $customModel;
    public function __construct($env, $baseUrl = '')
    {
        if(!empty($baseUrl))
        {
            $this->baseUrl = $baseUrl;
            $this->customModel = true;
        }
        else
        {
            $this->customModel = false;
        }
        $this->env = $env;
        $this->set_environment();
    }
    protected function set_environment()
    {
        $this->apiKey = $this->env['apikey'];
        $this->model = $this->env['model'] ?? 'gpt2';
        if (!isset($this->apiKey)) {
            throw new Exception('API key is required.');
        }
    }
    protected function build_body($query, $extra = null)
    {
        $body = [
            'inputs' => $query,
        ];
        if ($extra) {
            $body = array_merge($body, $extra);
        }
        return json_encode($body);
    }
    protected function build_url($model = null)
    {
        $url = $this->baseUrl;
        if($this->customModel === false)
        {
            if ($model) 
            {
                $url .= $model;
            } 
            else 
            {
                $url .= $this->model;
            }
        }
        return $url;
    }
    protected function build_headers()
    {
        return [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey,
        ];
    }
    public function generate_text($query, $extra = null)
    {
        $url = $this->build_url();
        $body = $this->build_body($query, $extra);
        $headers = $this->build_headers();
        $response = $this->send_request($url, $body, $headers, 'POST');
        if (isset($response['error'])) {
            throw new Exception($response['error']);
        }
        return $response;
    }
    public function list_models($params = [])
    {
        $models = [];
        $url = $this->build_list_models_url($params);
        $headers = $this->build_headers();

        $max_pages = 5;
        $cpage = 0;
        do 
        {
            $response = $this->send_request_list($url, null, $headers, 'GET');
            if (isset($response['error'])) {
                throw new Exception($response['error']);
            }
            if(is_array($response))
            {
                foreach($response as $rmodel)
                {
                    $models[] = $rmodel['id'];
                }
            }
            if(!isset($response['headers']['link']))
            {
                break;
            }
            $linkHeader = $this->parse_link_header($response['headers']['link']);
            $url = $linkHeader['next'] ?? null;
            $cpage++;
        } 
        while ($url && $max_pages > $cpage);
        return $models;
    }
    protected function build_list_models_url($params)
    {
        $baseListUrl = 'https://huggingface.co/api/models';
        $query = http_build_query($params);
        return $baseListUrl . '?' . $query;
    }
    protected function parse_link_header($linkHeader)
    {
        $links = [];
        if ($linkHeader) {
            $parts = explode(',', $linkHeader);
            foreach ($parts as $part) {
                $section = explode(';', $part);
                if (count($section) == 2) {
                    $url = trim($section[0], '<> ');
                    $name = trim(explode('=', $section[1])[1], '" ');
                    $links[$name] = $url;
                }
            }
        }
        return $links;
    }
    protected function send_request_list($url, $body, $headers, $method = 'POST')
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        if ($method === 'POST') 
        {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode >= 400) {
            $error = 'HTTP Error: ' . $httpCode . ' - ' . $response;
            curl_close($ch);
            throw new Exception($error);
        }
        curl_close($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($response, $headerSize);
        $js = json_decode($body, true);
        if(is_array($js))
        {
            $responseHeaders = substr($response, 0, $headerSize);
            $js['headers'] = $this->parse_headers($responseHeaders);
        }
        return $js;
    }
    
    protected function send_request($url, $body, $headers, $method = 'POST')
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($method === 'POST') 
        {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if ($this->env['stream'] == true) 
        {
            curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $data)
            {
                echo $data . "<br><br>";
                echo PHP_EOL;
                ob_flush();
                flush();
                return strlen($data);
            });
        }
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode >= 400) 
        {
            $error = 'HTTP Error: ' . $httpCode . ' - ' . $response;
            curl_close($ch);
            throw new Exception($error);
        }
        curl_close($ch);
        $js = json_decode($response, true);
        return $js;
    }
    protected function parse_headers($headerString)
    {
        $headers = [];
        $lines = explode("\r\n", $headerString);
        foreach ($lines as $line) {
            $parts = explode(': ', $line);
            if (count($parts) == 2) {
                $headers[strtolower($parts[0])] = $parts[1];
            }
        }
        return $headers;
    }
}
?>