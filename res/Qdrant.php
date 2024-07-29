<?php

function aiomatic_qdrant_run_request( $method, $apikey, $server, $url, $query = null) 
{
    $headers = "accept: application/json, charset=utf-8\r\ncontent-type: application/json\r\n" .
      "api-key: " . $apikey . "\r\n";
    $body = $query ? json_encode( $query ) : null;
    $url = $server . $url;
    $options = [
        "headers" => $headers,
        "method" => $method,
        "timeout" => 90,
        "body" => $body,
        "sslverify" => false
    ];
    try 
    {
        $response = wp_remote_request( $url, $options );
        if ( is_wp_error( $response ) ) {
            throw new Exception( $response->get_error_message() );
        }
        $responsebod = wp_remote_retrieve_body( $response );
        if(empty($responsebod))
        {
            throw new Exception( 'Empty response returned from Qdrant, code: ' . wp_remote_retrieve_response_code($response) );
        }
        $jresponse = json_decode( $responsebod, true );
        if ( !is_array( $jresponse ) ) {
            throw new Exception( 'Exception from Qdrant: ' . $jresponse );
        }
        return $jresponse;
    }
    catch ( Exception $e ) 
    {
        throw new Exception( '[Qdrant] ' . $e->getMessage() );
    }
    return [];
}
function aiomatic_qdrant_add_index( $apikey, $server, $name ) 
{
    $dimension = 1536;
    $metric = 'Cosine';
    $result = aiomatic_qdrant_run_request( 'PUT', $apikey, $server, '/collections/' . $name, [
        'vectors' => [
            'distance' => $metric,
            'size' => $dimension,
        ]
    ] );
    return $name;
}

function aiomatic_qdrant_delete_index( $apikey, $server, $name ) 
{
    $index = aiomatic_qdrant_run_request( 'DELETE', $apikey, $server, "/collections/" . $name );
    $success = !empty( $index );
    return $success;
}
function aiomatic_qdrant_list_indexes( $apikey, $server ) 
{
    $indexesIds = aiomatic_qdrant_run_request( 'GET', $apikey, $server, '/collections' );

    $indexes = [];
    foreach ( $indexesIds['result']['collections'] as $row ) {
        $index = aiomatic_qdrant_run_request( 'GET', $apikey, $server, "/collections/" . $row['name'] )['result'];
        $indexes[] = [
            'name' => $row['name'],
            'metric' => $index['config']['params']['vectors']['distance'],
            'dimension' => $index['config']['params']['vectors']['size'],
            'host' => $server,
            'ready' => $index['status'] === "green"
        ];
    }   
    return $indexes;
}

function aiomatic_qdrant_list_vectors( $apikey, $server, $index, $limit, $offset ) 
{
    $vectors = aiomatic_qdrant_run_request( 'POST', $apikey, $server, "/collections/{$index}/points/scroll", [
        'limit' => $limit,
        'offset' => $offset,
        'with_payload' => false,
        'with_vector' => false,
    ] );
    $vectors = isset( $vectors['result']['points'] ) ? $vectors['result']['points'] : [];
    $vectors = array_map( function( $vector ) { return $vector['id']; }, $vectors );
    return $vectors;
}

function aiomatic_qdrant_delete_vectors( $apikey, $server, $index, $ids, $deleteAll = false ) 
{
    if ( $deleteAll ) 
    {
        $body = 
        [
                'filter' => 
                [
                    'must' => 
                    [
                        [
                            "is_empty" => 
                            [
                                "key" => "any"
                            ]
                        ]
                    ]
                ]
        ];
    } 
    else 
    {
        $body = ['points' => $ids];
    }

    $success = aiomatic_qdrant_run_request( 'POST', $apikey, $server, "/collections/{$index}/points/delete", $body );
    $success = true;
    return $success;
}

function aiomatic_qdrant_add_vector( $apikey, $server, $index, $vector ) 
{
    $qid = aiomatic_qdrant_get_uuid();
    $body = [
        'points' => 
        [
            [
                'id' => $qid,
                'vector' => $vector['values'],
                'payload' => [
                    'title' => $vector['id']
                ]
            ]
        ]
    ];

    $res = aiomatic_qdrant_run_request( 'PUT', $apikey, $server, "/collections/{$index}/points", $body );
    $success = isset( $res['status'] ) && $res['status'] === "ok";
    if ( $success ) {
        return $qid;
    }
    $error = isset( $res['status']['error'] ) ? $res['status']['error'] : 'Unknown error from Qdrant.';
    throw new Exception( $error );
}

function aiomatic_qdrant_query_vectors( $apikey, $server, $index, $maxSelect, $vector ) 
{
    $body = [
        'limit' => $maxSelect,
        'vector' => $vector,
        'with_payload' => true
    ];

    $res = aiomatic_qdrant_run_request( 'POST', $apikey, $server, "/collections/{$index}/points/search", $body );
    $vectors = isset( $res['result'] ) ? $res['result'] : [];

    foreach ( $vectors as &$vector ) {
        $vector['metadata'] = $vector['payload'];
    }
    return $vectors;
}

function aiomatic_qdrant_get_vector( $apikey, $server, $index, $vectorId ) 
{
    $vectorId = $vectorId;

    $res = aiomatic_qdrant_run_request( 'GET', $apikey, $server, "/collections/{$index}/points/{$vectorId}" );
    
    $removeVector = isset( $res['result']['id'] ) ? $res['result'] : null;
    
    if ( !empty( $removeVector ) ) {
        return [
            'id' => $vectorId,
            'type' => isset( $removeVector['payload']['type'] ) ? $removeVector['payload']['type'] : 'manual',
            'title' => isset( $removeVector['payload']['title'] ) ? $removeVector['payload']['title'] : '',
            'values' => isset( $removeVector['vector'] ) ? $removeVector['vector'] : []
        ];
    }
    return null;
}
function aiomatic_qdrant_get_uuid($len = 32, $strong = true) 
{
    $data = openssl_random_pseudo_bytes($len, $strong);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}
?>