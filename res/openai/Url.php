<?php

namespace AiomaticOpenAI\OpenAi;

defined('ABSPATH') or die();
class Url
{
    const ORIGIN = 'https://api.openai.com';
    const API_VERSION = 'v1';
    const OPEN_AI_URL = self::ORIGIN . "/" . self::API_VERSION;

    /**
     * @param string $engine
     * @return string
     */
    public static function completionURL(string $engine)
    {
        return self::OPEN_AI_URL . "/engines/$engine/completions";
    }

    /**
     * @return string
     */
    public static function completionsURL()
    {
        return self::OPEN_AI_URL . "/completions";
    }

    /**
     * @return string
     */
    public static function speechUrl() {
        return self::OPEN_AI_URL . "/audio/speech";
    }

    /**
     *
     * @return string
     */
    public static function editsUrl()
    {
        return self::OPEN_AI_URL . "/edits";
    }

    /**
     * @param string $engine
     * @return string
     */
    public static function searchURL(string $engine)
    {
        return self::OPEN_AI_URL . "/engines/$engine/search";
    }

    /**
     * @param
     * @return string
     */
    public static function enginesUrl()
    {
        return self::OPEN_AI_URL . "/engines";
    }

    /**
     * @param string $engine
     * @return string
     */
    public static function engineUrl(string $engine)
    {
        return self::OPEN_AI_URL . "/engines/$engine";
    }

    /**
     * @param
     * @return string
     */
    public static function classificationsUrl()
    {
        return self::OPEN_AI_URL . "/classifications";
    }

    /**
     * @param
     * @return string
     */
    public static function moderationUrl()
    {
        return self::OPEN_AI_URL . "/moderations";
    }

    /**
     * @param
     * @return string
     */
    public static function transcriptionsUrl()
    {
        return self::OPEN_AI_URL . "/audio/transcriptions";
    }

    /**
     * @param
     * @return string
     */
    public static function translationsUrl()
    {
        return self::OPEN_AI_URL . "/audio/translations";
    }

    /**
     * @param
     * @return string
     */
    public static function filesUrl()
    {
        return self::OPEN_AI_URL . "/files";
    }

    /**
     * @param
     * @return string
     */
    public static function fineTuneUrl()
    {
        return self::OPEN_AI_URL . "/fine_tuning/jobs";
    }

    /**
     * @param
     * @return string
     */
    public static function fineTuneModel()
    {
        return self::OPEN_AI_URL . "/models";
    }

    /**
     * @param
     * @return string
     */
    public static function answersUrl()
    {
        return self::OPEN_AI_URL . "/answers";
    }

    /**
     * @param
     * @return string
     */
    public static function imageUrl()
    {
        return self::OPEN_AI_URL . "/images";
    }

    /**
     * @param
     * @return string
     */
    public static function embeddings()
    {
        return self::OPEN_AI_URL . "/embeddings";
    }

    /**
     * @param
     * @return string
     */
    public static function chatUrl()
    {
        return self::OPEN_AI_URL . "/chat/completions";
    }
}
