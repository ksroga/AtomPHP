<?php

namespace System\Libraries;

/**
 * Class Input
 * @package System\Controller
 * @author Konrad Sroga
 * @version 1.0.0 (21.02.2021)
 */
class Input {

    /**
     * @var array GET data.
     */
    private $get;

    /**
     * @var array POST data.
     */
    private $post;

    /**
     * @var Client Client data object.
     */
    public $client;

    /**
     * Input constructor.
     */
    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->client = new Client();

        $this->sanitizeData();
    }

    /**
     * Get data from GET by key.
     * @param string $key GET data key.
     * @return mixed|null GET value or null.
     */
    public function get(string $key)
    {
        return $this->get[$key] ?? null;
    }

    /**
     * Get data from POST by key.
     * @param string $key POST data key.
     * @return mixed|null POST value or null.
     */
    public function post(string $key)
    {
        return $this->post[$key] ?? null;
    }

    /**
     * Sanitize data.
     */
    private function sanitizeData(): void
    {
        foreach ($this->get as $key => $value)
        {
            $this->get[$key] = $this->sanitizeValue($value);
        }

        foreach ($this->post as $key => $value)
        {
            $this->post[$key] = $this->sanitizeValue($value);
        }
    }

    /**
     * Sanitize value (preventing XSS).
     * @param $value string Value to sanitize.
     * @return string Sanitized value.
     */
    private function sanitizeValue(string $value): string
    {
        return htmlspecialchars(strip_tags($value));
    }
}