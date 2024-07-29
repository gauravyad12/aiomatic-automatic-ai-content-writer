<?php

namespace Gioni06\Gpt3Tokenizer;
class Vocab
{
    private $vocab;

    public function __construct(string $path = __DIR__ . '/pretrained_vocab_files/vocab.json')
    {
        $this->vocab = array();
        global $wp_filesystem;
        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
            include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
            wp_filesystem($creds);
        }
        $contx = $wp_filesystem->get_contents($path);
        if($contx !== false)
        {
            $jsx = json_decode($contx, true);
            if($jsx !== false)
            {
                $this->vocab = $jsx;
            }
        }
    }

    public function data(): mixed
    {
        return $this->vocab;
    }
}
