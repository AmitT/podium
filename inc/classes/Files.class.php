<?php
namespace Podium\Config;

use Podium\Config\Styles as PodiumStyles;
use Podium\Config\Scripts as PodiumScripts;
use Podium\Config\Environment as Environment;

class Files
{
    private $scripts = [];

    private $suffix = '';
    public function __construct()
    {
        $env = new Environment();
        if ($env->isLive()) {
            $this->suffix = '.min';
        }
    }

    public function register()
    {
        // register styles
        $podiumStyles = new PodiumStyles();
        $podiumStyles->register();
        // register scripts
        $podiumScripts = new PodiumScripts();
        $podiumScripts->register();
    }
}
