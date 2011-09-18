<?php
/*
 * Theme Name: XenDynamic
 * Theme URI: http://www.rcbdesigns.net
 * Description: The Dynamic XenForo v1.0.4 Theme For WordPress 
 * Version: 0.2.0
 * Author: Rich Berrill
 * Author URI: http://www.rcbdesigns.net
 * Tags: xenforo
 * File: breadcrumb.php
 * 
 * This file will hold all code and functions for building the breadcrumbs
 */

//******************************************************************************
// This function walks through the path and builds the breadcrumb string
//******************************************************************************

function buildBreadCrumbs() {
    $path = get_bloginfo("wpurl");
    $breadCrumb = '<nav class="test"><fieldset class="breadcrumb"><a href="index.php?misc/quick-navigation-menu" class="OverlayTrigger jumpMenuTrigger" data-cacheOverlay="true" title="Open quick navigation"><!--Jump to...--></a><div class="boardTitle"><strong>Defiant Minecraft Server</strong></div><span class="crumbs"><span class="crust" itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . $path . '" class="crumb" rel="up" itemprop="url"><span itemprop="title">Home</span></a><span class="arrow"><span></span></span></span>';
    $crumbs = getPathHierarchy();
    foreach ($crumbs as $crumb) {
        $path .= "/" . $crumb;
        if ($crumb != "category") {
            $crumb = str_replace("-", " ", $crumb);
            $crumb = ucwords($crumb);
            $breadCrumb .= '<span class="crust" itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="' . $path . '" class="crumb" rel="up" itemprop="url"><span itemprop="title">' . $crumb . '</span></a><span class="arrow"><span></span></span></span>';
        }
    }
    $breadCrumb .= '</span></fieldset></nav>';
    return str_replace("\"", "'", $breadCrumb);
}

//******************************************************************************
// Pulls the requested URI and returns an array ordered by hierarchy
//******************************************************************************

function getPathHierarchy() {
    $requestPath = explode("/", $_SERVER["REQUEST_URI"]);
    $pathHierarchy = array();
    foreach ($requestPath as $path) {
        if ($path) {
            $pathHierarchy[] = $path;
        }
    }

    return $pathHierarchy;
}


