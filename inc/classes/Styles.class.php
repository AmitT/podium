<?php
namespace Podium\Config;

use Podium\Config\Environment as Environment;

class Styles
{
    private $baseUrl;
    private $suffix = '';
    private $styles = [
        'home' => [
            'url' => false,
            'depends_on' => [],
            'version' => '',
            'media' => ''
        ],
        'blog' => [
            'url' => false,
            'depends_on' => [],
            'version' => '',
            'media' => ''
        ]
    ];
    public function __construct()
    {
        $this->baseUrl = \get_stylesheet_directory_uri() . 'dist/styles/';
        $env = new Environment();
        if ($env->isLive()) {
            $this->suffix = '.min';
        }
    }

    public function register()
    {
        foreach ($this->styles as $key => $style) {
            if ($style['url'] === false) {
                $style['url'] = $this->baseUrl . $key . $this->suffix . '.css';
            }
            \wp_register_style(
                $key . '-style',
                $style['url'],
                $style['depends_on'],
                $style['version'],
                $style['media']
            );
        }
        // wp_register_style(  $handle, $src, $deps, $ver, $media )
        // https://developer.wordpress.org/reference/functions/wp_register_style/
    }
    public function enqueue($templateName, $additionaFiles = null)
    {
        if (wp_script_is($templateName, 'enqueued')) {
            \wp_enqueue_style($templateName);
        } else {
            // \podium_var_dump($templateName);
        }
        // foreach ($this->styles as $key => $style) {

        // }
        // wp_enqueue_style( string $handle, string $src = '', string[] $deps = array(), string|bool|null $ver = false, string $media = 'all' )
    }
}
