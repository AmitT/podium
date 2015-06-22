<?php
/*
Template Name: New Template
*/
use Podium\Config\Settings as settings;
$settings = new settings(); 

if($settings->displaySidebar()){
	echo 'sidebar should be displayed';
} else {
	echo 'sidebar should not be displayed';
}
?>