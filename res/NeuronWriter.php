<?php
class NeuronWriterAPI 
{
    private $apiEndpoint = 'https://app.neuronwriter.com/neuron-api/0.5/writer';
    private $headers = array();

    public function __construct($apikey) 
    {
        $this->headers = [
            'X-API-KEY: ' . $apikey,
            'Accept: application/json',
            'Content-Type: application/json'
        ];
    }
    
    private function sendRequest($method, $url, $body = null) 
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->apiEndpoint . $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        if (!is_null($body)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        }
        
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    
    public function createNewQuery($projectId, $keyword, $engine, $language) 
    {
        $payload = [
            'project' => $projectId,
            'keyword' => $keyword,
            'engine' => $engine,
            'language' => $language
        ];
        
        return $this->sendRequest('POST', '/new-query', $payload);
    }
    
    public function getQueryStatus($queryId) 
    {
        $retme = false;
        $payload = ['query' => $queryId];
        $response = $this->sendRequest('POST', '/get-query', $payload);
        $responseData = json_decode($response, true);
        if (isset($responseData['status']) && $responseData['status'] === 'ready') 
        {
            $retme = $responseData;
        }
        return $retme;
    }
}
?>