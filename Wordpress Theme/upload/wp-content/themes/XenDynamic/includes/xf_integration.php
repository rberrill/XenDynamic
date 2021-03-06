<?php

/*
 * Theme Name: XenDynamic
 * Theme URI: http://www.rcbdesigns.net
 * Description: The Dynamic XenForo v1.0.4 Theme For WordPress 
 * Version: 0.1.0
 * Author: Rich Berrill
 * Author URI: http://www.rcbdesigns.net
 * Tags: xenforo
 * File: xf_integration.php
 * 
 * This file will hold all code and functions for hooking the theme in with XF
 */

//******************************************************************************
// Pull instantiate and pull the template from the Xenforo system
//******************************************************************************

if (!is_admin()) {
    $XenDynamic_container = true;
    $startTime = microtime(true);
    $XenDynamic_indexFile = "../../../.." . getThemeOption("xenforo_path");
    $fileDir = dirname(__FILE__) . "/{$XenDynamic_indexFile}";
//    $fileDir = ABSPATH . getThemeOption("xenforo_path");
//	$fileDir = dirname(__FILE__) . "/../../../.." . getThemeOption("xenforo_path");
	if (!class_exists("XenForo_Autoloader")) {
        require($fileDir . '/library/XenForo/Autoloader.php');
        XenForo_Autoloader::getInstance()->setupAutoloader($fileDir . '/library');
        XenForo_Application::initialize($fileDir . '/library', $fileDir);
        XenForo_Application::set('page_start_time', $startTime);
        XenForo_Application::disablePhpErrorHandler();
        error_reporting(E_ALL ^ E_NOTICE ^ E_USER_NOTICE ^ E_WARNING);
    }
    ob_start();
    $XenDynamic_fc = new RCBD_XenDynamic_FrontController(new XenForo_Dependencies_Public());
    $xenforoOutput = $XenDynamic_fc->runXenDynamic(ob_get_clean());
    global $templateParts;
    $templateParts = getTemplateParts($xenforoOutput,getThemeOption("xenforo_path"));
}

//******************************************************************************
// This function takes the raw buffer from Xenforo and breaks it into the header
// and the rest of the file it also does some jquery replacements for elements
// that need to be changed on all wordpress templates.  
// RCBD TODO: It's ugly and I'm going to try to find a better way to do it.
//******************************************************************************

function getTemplateParts($buffer,$fileDir) {
    $uri = explode("/", $_SERVER['REQUEST_URI']);
    if (sizeof($uri) < 3) {
        $uri[1] = "home";
    }
    $slug = str_replace("-", "", $uri[1]);
    $buffer = str_replace("</body>", '<script type="text/javascript"> 
										<!--
                                                                                $("div#contentMover").prependTo("div.mainContent");
                                                                                $("div#contentMover").css("display","block");
                                                                                $("div.sidebar").prependTo("aside");
                                                                                $("div.sidebar").css("display","block");
                                                                                $("ul.publicTabs li.' . $slug . '").addClass("selected");
                                                                                if($("div#footer_credits a").html() == "Aurora theme by Akrion.") {
                                                                                    $("ul.publicTabs li.' . $slug . '").removeClass("PopupClosed");
                                                                                    $("ul.publicTabs li.' . $slug . ' a").addClass("navDivLink");
                                                                                    $("a.navDivLink").removeClass("navLink");
                                                                                    $("a.navDivLink").wrap("<div class=\'navLink\'></div>");
                                                                                }                                                                                
										$(".controlsWrapper").empty();
										//-->
									</script>
                                                                        <!-- end of middle -->
									</body>', $buffer);
//    $buffer = str_replace(get_bloginfo("wpurl") . "/", "", $buffer);
    $buffer = preg_replace("/<title>(.*?)<\/title>/i", "", $buffer);
//    $buffer = preg_replace("/_bH = \"(.*?)\"/i", "_bH = \"" . get_bloginfo("wpurl") . $fileDir . "/\"", $buffer);
//    $buffer = preg_replace("/<base href=\"(.*?)\" \/>/i", "<base href=\"" . get_bloginfo("wpurl") . $fileDir . "/\" />", $buffer);
    $buffer = str_replace('form,public', 'form,public,events,news_feed,login_bar,node_category,node_forum,node_list,XenDynamic,XenDynamicEXTRA', $buffer);
    $buffer = str_replace('<form action="index.php?search/search" method="post"', '<form action="/" method="get"', $buffer);
    $buffer = str_replace('name="keywords"', 'name="s"', $buffer);
    $headFinishPos = strpos($buffer, "</head>");
    $middleFinishPos = strpos($buffer, "</body>");
    $headText = substr($buffer, 0, $headFinishPos);
    $middleText = substr($buffer, $headFinishPos + 7, $middleFinishPos - $headFinishPos - 7);
    return array("head" => $headText, "middle" => $middleText);
}

//******************************************************************************
// This is called from the Wordpress templates and sends it the main portion of
// the page that's been rendered.
//******************************************************************************

function displayXFTemplate() {
    $breadCrumb = buildBreadCrumbs();
//    echo $breadCrumb;
    addScript(".breadBoxTop", "html", $breadCrumb);
    addScript(".breadBoxBottom", "html", $breadCrumb);
    addScript(".tabLinks", "html","<ul class='secondaryContent blockLinksList'><li><a href='forums/-/mark-read?date=1316264858'>Mark All Forums Read</a></li><li><a href='search/?type=post'>Search Forums</a></li><li><a href='watched/threads'>Watched Threads</a></li></ul>");
    global $templateParts;
    $templateParts['middle'] = str_replace("<!-- main template -->", '<div class="mainContainer XenDynamicMC">
            <div class="mainContent">
            </div>
        </div>
        <aside>
        </aside>', $templateParts['middle']);
    echo $templateParts['middle'];
}
