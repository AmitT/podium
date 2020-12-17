<?php
namespace Podium\Config;

use Podium\Config\Environment as Environment;

class Scripts
{
    private $baseUrl;
    private $suffix = '';
    private $scripts = [
        'home' => [
            'url' => false,
            'depends_on' => [],
            'version' => '',
            'in_footer' => true
        ]
    ];
    public function __construct()
    {
        $this->baseUrl = \get_stylesheet_directory_uri() . 'dist/scripts/';
        $env = new Environment();
        if ($env->isLive()) {
            $this->suffix = '.min';
        }
    }
    public function register()
    {
        foreach ($this->scripts as $key => $script) {
            // podium_ver_dump($key);
            if ($script['url'] === false) {
                $script['url'] =
                    $this->baseUrl . $key . $this->suffix . '.css';
            }
            wp_register_script(
                $key,
                $script['url'],
                $script['depends_on'],
                $script['version'],
                $script['in_footer']
            );
        }
        // wp_register_script( string $handle, string|bool $src, string[] $deps = array(), string|bool|null $ver = false, bool $in_footer = false )
    }
}
