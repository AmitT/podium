<?php
/*
Template Name: New Template
*/
use Podium\Config\Settings as settings;

$settings = new settings(); 
echo $settings->displaySidebar();
die;
?>