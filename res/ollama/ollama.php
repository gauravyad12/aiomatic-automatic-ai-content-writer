<?php
class AiomaticOllamaAPI 
{
    private $baseUrl;
    public function __construct($baseUrl) 
    {
        $this->baseUrl = rtrim($baseUrl, '/');
    }
    private function makeRequest($endpoint, $data, $stream) 
    {
        $url = $this->baseUrl . $endpoint;
        
        $payload = json_encode($data);
        if ($payload === false) {
            aiomatic_log_to_file('Failed to encode payload in request: ' . print_r($data, true));
            return false;
        }

        $args = array(
            'body'        => $payload,
            'headers'     => array(
                'Content-Type' => 'application/json',
            ),
            'method'      => 'POST',
            'data_format' => 'body',
            'timeout'     => AIOMATIC_DEFAULT_BIG_TIMEOUT,
        );

        if ($stream === true) {
            add_action('http_api_curl', array($this, 'filterCurlForStream'));
        }

        $response = wp_remote_post($url, $args);

        if ($stream === true) {
            remove_action('http_api_curl', array($this, 'filterCurlForStream'));
        }

        if (is_wp_error($response)) {
            aiomatic_log_to_file('Error making request to ' . $url . ': ' . $response->get_error_message());
            return false;
        }

        $body = wp_remote_retrieve_body($response);

        if ($stream === true) {
            return '';
        }
        $res = json_decode($body, true);
        if ($res === null) {
            aiomatic_log_to_file('Failed to decode response: ' . $body);
            return false;
        }

        return $res;
    }
    public function filterCurlForStream($handle)
    {
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_WRITEFUNCTION, function ($curl_info, $data) 
        {
            $my_copy_data = trim($data);
            $prefix = 'data: ';
            if (substr($my_copy_data, 0, strlen($prefix)) == $prefix) {
                $my_copy_data = substr($my_copy_data, strlen($prefix));
            }
            $suffix = 'data: [DONE]';
            $needle_length = strlen($suffix);
            if (substr($my_copy_data, -$needle_length) === $suffix) {
                $my_copy_data = substr($my_copy_data, 0, -$needle_length);
            }
            $my_copy_data = trim($my_copy_data);
            $response = json_decode($my_copy_data, true);
            if (isset($response['error']) && !empty($response['error'])) 
            {
                $message = isset($response['error']['message']) && !empty($response['error']['message']) ? $response['error']['message'] : '';
                if (empty($message) && isset($response['error']['code']) && $response['error']['code'] == 'invalid_api_key') {
                    $message = "Incorrect API key provided. You can find your API key at https://platform.openai.com/account/api-keys.";
                }
                echo "event: message\n";
                echo 'data: {"error":[{"message":"' . $message . '"}]}';
                echo "\n\n";
                $l1 = ob_get_length();
                if($l1 === false)
                {
                    $l1 = 0;
                }
                if (ob_get_length())
                {
                    ob_end_flush();
                }
                flush();
                echo 'data: {"choices":[{"finish_reason":"stop"}]}';
                echo "\n\n";
                $l2 = ob_get_length();
                if($l2 === false)
                {
                    $l2 = 0;
                }
                if (ob_get_length())
                {
                    ob_end_flush();
                }
                flush();
                return $l1 + $l2;
            } 
            else 
            {
                echo "data: {$data}\n\n";
                if (ob_get_length())
                {
                    ob_flush();
                }
                flush();
                return strlen($data);
            }
        });
    }
    public function chatCompletion($model, $messages, $stream = true, $options = []) 
    {
        $data = [
            'model' => $model,
            'messages' => $messages,
            'stream' => $stream
        ];
        if(!empty($options))
        {
            $data['options'] = $options;
        }
        $resp = $this->makeRequest('/api/chat', $data, $stream);
        if($resp === false)
        {
            return false;
        }
        if($stream === true)
        {
            return '';
        }
        if(!isset($resp['message']['content']))
        {
            aiomatic_log_to_file('Failed to interpret Ollama chat API response: ' . print_r($resp, true));
            return false;
        }
        return $resp['message']['content'];
    }
    public function generate($model, $prompt, $stream = false, $options = []) 
    {
        $data = [
            'model' => $model,
            'prompt' => $prompt,
            'stream' => $stream
        ];
        if(!empty($options))
        {
            $data['options'] = $options;
        }
        $resp = $this->makeRequest('/api/generate', $data, $stream);
        if($resp === false)
        {
            return false;
        }
        if($stream === true)
        {
            return '';
        }
        if(!isset($resp['response']))
        {
            aiomatic_log_to_file('Failed to interpret Ollama completion API response: ' . print_r($resp, true));
            return false;
        }
        return $resp['response'];
    }
}
?>