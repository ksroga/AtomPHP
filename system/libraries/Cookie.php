<?php

namespace System\Libraries;

/**
 * Class Cookie
 * @package System\Controller
 * @author Konrad Sroga <konradsroga@gmail.com>
 * @version 1.0.0 (22.02.2021)
 */
class Cookie
{
    /**
     * Set cookie.
     * @param string $name Cookie name.
     * @param mixed $value Cookie value.
     * @param int $expires The time the cookie expires.
     * @param string $path The path on the server in which the cookie will be available on.
     * @param string $domain The (sub)domain that the cookie is available to.
     * @param bool $secure Indicates that the cookie should be transmitted over HTTPS from the client.
     */
    public function set(
        string $name,
        $value,
        int $expires = 0,
        string $path = "",
        string $domain = "",
        bool $secure = false
    ): void
    {
        setcookie($name, $value, $expires, $path, $domain, $secure);
    }

    /**
     * Get cookie.
     * @param $name Cookie name.
     * @return mixed|null Cookie value or nul if cookie does not exist.
     */
    public function get($name)
    {
        return $_COOKIE[$name] ?? null;
    }
}