<?php
defined('ABSPATH') or die();
class Aiomatic_Query {
    public $maxTokens = 16;
    public $temperature = 0.8;
    public $stop = null;
    public $env = '';
    public $prompt = '';
    public $model = '';
    public $mode = '';
    public $apiKey = null;
    public $session = null;
    public $maxResults = 1;
    public $image_size = '512x512';
    public $assistant_id = '';

    public function __construct( $prompt = '', $maxTokens = 16, $model = 'gpt-3.5-turbo-instruct', $temperature = 0.8, $stop = null, $env = '', $mode = 'completion', $apiKey = null, $session = null, $maxResults = 1, $image_size = '512x512', $assistant_id = '' ) {
        $this->prompt = $prompt;
        $this->maxTokens = $maxTokens;
        $this->model = $model;
        $this->temperature = $temperature;
        $this->stop = $stop;
        $this->env = $env;
        $this->mode = $mode;
        $this->apiKey = $apiKey;
        $this->session = $session;
        $this->maxResults = $maxResults;
        $this->image_size = $image_size;
        $this->assistant_id = $assistant_id;
    }

    /**
     * The environment, like "chatbot", "imagesbot", "chatbot-007", "textwriter", etc...
     * Used for statistics, mainly.
     * @param string $env The environment.
     */
    public function setEnv( $env ) {
        $this->env = $env;
    }

    /**
     * ID of the model to use.
     * @param string $model ID of the model to use.
     */
    public function setModel( $model ) {
        $this->model = $model;
    }

    /**
     * ID of the assistant_id to use.
     * @param string $assistant_id ID of the assistant to use.
     */
    public function setAssistantID( $assistant_id ) {
        $this->assistant_id = $assistant_id;
    }

    /**
     * Given a prompt, the model will return one or more predicted completions.
     * It can also return the probabilities of alternative tokens at each position.
     * @param string $prompt The prompt to generate completions.
     */
    public function setPrompt( $prompt ) {
        $this->prompt = $prompt;
    }

    /**
     * The API key to use.
     * @param string $apiKey The API key.
     */
    public function setApiKey( $apiKey ) {
        $this->apiKey = $apiKey;
    }

    /**
     * The session ID to use.
     * @param string $session The session ID.
     */
    public function setSession( $session ) {
        $this->session = $session;
    }

    /**
     * How many completions to generate for each prompt.
     * Because this parameter generates many completions, it can quickly consume your token quota.
     * Use carefully and ensure that you have reasonable settings for max_tokens and stop.
     * @param float $maxResults Number of completions.
     */
    public function setMaxResults( $maxResults ) {
        $this->maxResults = $maxResults;
    }
    /**
     * How many completions to generate for each prompt.
     * Because this parameter generates many completions, it can quickly consume your token quota.
     * Use carefully and ensure that you have reasonable settings for max_tokens and stop.
     * @param float $maxImageSize Number of completions.
     */
    public function setImageSize( $image_size ) {
        $this->image_size = $image_size;
    }


    /**
     * The maximum number of tokens to generate in the completion.
     * The token count of your prompt plus max_tokens cannot exceed the model's context length.
     * Most models have a context length of 2048 tokens (except for the newest models, which support 4096).
     * @param float $prompt The maximum number of tokens.
     */
    public function setMaxTokens( $maxTokens ) {
        $this->maxTokens = $maxTokens;
    }

    /**
     * Set the sampling temperature to use. Higher values means the model will take more risks.
     * Try 0.9 for more creative applications, and 0 for ones with a well-defined answer.
     * @param float $temperature The temperature.
     */
    public function setTemperature( $temperature ) {
        $temperature = floatval( $temperature );
        if ( $temperature > 1 ) {
            $temperature = 1;
        }
        if ( $temperature < 0 ) {
            $temperature = 0;
        }
    $this->temperature = $temperature;
    }

    /**
     * Up to 4 sequences where the API will stop generating further tokens.
     * The returned text will not contain the stop sequence.
     * @param float $stop The stop.
     */
    public function setStop( $stop ) {
        if ( !empty( $stop ) ) {
            $this->stop = $stop;
        }
    }
  }
?>