<?php

class Environment
{
    /**
     * @var mixed
     */
    private $env;

    public function __construct()
    {
        // Set host name
        $host = $_SERVER['SERVER_NAME'];

        // List of our development domains
        $dev_domains = [
            'localhost',
        ];

        if (in_array($host, $dev_domains)) {

            $this->env = 'development';

            // Set development ENV
            if (!defined('WP_ENV')) {
                define('WP_ENV', 'development');
            }

            // Enable strict error reporting
            error_reporting(E_ALL | E_STRICT);
            @ini_set('display_errors', 1);

            if (!defined('WP_DEBUG')) {
                define('WP_DEBUG', true);
            }

        } else {

            $this->env = 'production';

            // Set production ENV
            if (!defined('WP_ENV')) {
                define('WP_ENV', 'production');
            }

            // Limit post revisions to 5.
            if (!defined('WP_POST_REVISIONS')) {
                define('WP_POST_REVISIONS', 5);
            }

            // disallow wp files editor.
            if (!defined('DISALLOW_FILE_EDIT')) {
                define('DISALLOW_FILE_EDIT', true);
            }

            if (!defined('WP_DEBUG')) {
                define('WP_DEBUG', false);
            }

        }

        if (!defined('WP_ENV')) {

            // Fallback if WP_ENV isn't defined
            // Used to check for 'development' or 'production'
            if (!defined('WP_ENV')) {
                define('WP_ENV', 'production');
            }

        }

    }

    /**
     * @return null
     */
    public function getEnv()
    {

        return $this->env;

    }

}

function set_environment()
{

    $env = new Environment();
    return $env;

}

add_action('init', 'set_environment', 2);
