<?php
use Podium\Config\Environment as Environment;
use Podium\Config\CleanImageFilenames as CleanImageFilenames;

if (!function_exists('floating_direction')) {
    /**
     * @param $reverse
     */
    function floating_direction($reverse = false)
    {
        if ((is_rtl() && !$reverse) || (!is_rtl() && $reverse)) {
            return 'right';
        } else {
            return 'left';
        }
    }
}

if (!function_exists('podium_var_dump')) {
    function podium_var_dump($var, $exit = false)
    {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
        if ($exit) {
            exit();
        }
    }
}

if (!function_exists('podium_set_environment')) {
    function podium_set_environment()
    {
        $env = new Environment();
        return $env;
    }
}

add_action('init', 'podium_set_environment', 2);

new CleanImageFilenames();
