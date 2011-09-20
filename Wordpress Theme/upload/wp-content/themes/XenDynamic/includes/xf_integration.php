<?php

/*
 * Theme Name: XenDynamic
 * Theme URI: http://www.rcbdesigns.net
 * Description: The Dynamic XenForo v1.0.4 Theme For WordPress 
 * Version: 0.2.0
 * Author: Rich Berrill
 * Author URI: http://www.rcbdesigns.net
 * Tags: xenforo
 * File: xf_integration.php
 * 
 * This file will hold all code and functions for hooking the theme in with XF
 */

class XFIntegration {

    private $localLoaded = false;
    private $forumPath = "/community";

    public function initialize($inputPath) {
        $this->forumPath = $inputPath;
        $startTime = microtime(true);
        $fileDir = ABSPATH . $this->forumPath;
        $autoloaderPath = $fileDir . '/library/XenForo/Autoloader.php';
        if (file_exists($autoloaderPath)) {
            if (!class_exists("XenForo_Autoloader")) {
                $this->localLoaded = true;
                require($autoloaderPath);
                XenForo_Autoloader::getInstance()->setupAutoloader($fileDir . '/library');
                XenForo_Application::initialize($fileDir . '/library', $fileDir);
                XenForo_Application::set('page_start_time', $startTime);
                XenForo_Application::disablePhpErrorHandler();
                error_reporting(E_ALL ^ E_NOTICE ^ E_USER_NOTICE ^ E_WARNING);
            }
        }
    }

    public function isLocalLoaded() {
        return $this->localLoaded;
    }

    public function getTemplateParts($buffer) {
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
                                                                                if ($("ul.publicTabs li.' . $slug . '").length>0) {
                                                                                    $("ul.publicTabs li.' . $slug . '").addClass("selected");
                                                                                }
                                                                                else {
                                                                                    $("ul.publicTabs li.home").addClass("selected");
                                                                                }
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
        $buffer = preg_replace("/<title>(.*?)<\/title>/i", "", $buffer);
        $buffer = preg_replace("/_bH = \"(.*?)\"/i", "_bH = \"" . get_bloginfo("wpurl") . $this->forumPath . "/\"", $buffer);
        $buffer = preg_replace("/<base href=\"(.*?)\" \/>/i", "<base href=\"" . get_bloginfo("wpurl") . $this->forumPath . "/\" />", $buffer);
        $buffer = str_replace('form,public', 'form,public,events,news_feed,login_bar,node_category,node_forum,node_list,XenDynamic,XenDynamicEXTRA', $buffer);
        $buffer = str_replace('<form action="index.php?search/search" method="post"', '<form action="/" method="get"', $buffer);
        $buffer = str_replace('name="keywords"', 'name="s"', $buffer);
        $headFinishPos = strpos($buffer, "</head>");
        $middleFinishPos = strpos($buffer, "</body>");
        $headText = substr($buffer, 0, $headFinishPos);
        $middleText = substr($buffer, $headFinishPos + 7, $middleFinishPos - $headFinishPos - 7);
        return array("head" => $headText, "middle" => $middleText);
    }

    public function displayXFTemplate($template) {
        $breadCrumb = buildBreadCrumbs();
        addScript(".breadBoxTop", "html", $breadCrumb);
        addScript(".breadBoxBottom", "html", $breadCrumb);
        $args = array(
            "container" => false,
            "theme_location" => "secondary_menu",
            "echo" => false,
            "menu_class" => "secondaryContent blockLinksList",
        );
        $menu = wp_nav_menu($args);
        $menu = ereg_replace("/\n\r|\r\n|\n|\r/", "", $menu);
        $menu = preg_replace("/\t/", "", $menu);
        $menu = str_replace("\"", "'", $menu);
        addScript(".tabLinks", "html", $menu);
        $template['middle'] = str_replace("<!-- main template -->", '<div class="mainContainer XenDynamicMC">
            <div class="mainContent">
            </div>
        </div>
        <aside>
        </aside>', $template['middle']);
        return $template['middle'];
    }

}
