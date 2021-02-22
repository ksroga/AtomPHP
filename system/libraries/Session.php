<?php

namespace System\Libraries;

/**
 * Class Session
 * @package System\Controller
 * @author Konrad Sroga <konradsroga@gmail.com>
 * @version 1.0.0 (22.02.2021)
 */
class Session
{
    /**
     * Session constructor.
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * Set session data.
     * @param $key string Session key.
     * @param $value mixed Session value.
     */
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get session data.
     * @param $key string Get session key.
     * @return mixed|null Session data.
     */
    public function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }
}