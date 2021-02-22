<?php

namespace System\Libraries;

/**
 * Class Client
 * @package System\Controller
 * @author Konrad Sroga <konradsroga@gmail.com>
 * @version 1.0.0 (22.02.2021)
 */
class Client
{
    /**
     * @var string Client ip address.
     */
    public $ipAddress;

    /**
     * @var string Client browser user agent.
     */
    public $userAgent;

    /**
     * @var array Client browser object.
     */
    public $browser;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->setIpAddress();
        $this->setBrowser();
        $this->setUserAgent();
    }

    /**
     * Set ip address.
     */
    private function setIpAddress(): void
    {
        $this->ipAddress = $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Set browser data.
     */
    private function setBrowser(): void
    {
        $this->browser = get_browser(null, true);
    }

    /**
     * Set user agent.
     */
    private function setUserAgent(): void
    {
        $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
    }
}