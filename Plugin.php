<?php
/**
 * Lightgallery图片灯箱效果
 * @package Lightgallery
 * @author WhiteBear
 * @version 1.0.0
 * @link https://www.coder-bear.com/
 */
class Lightgallery_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->header = array('Lightgallery_Plugin', 'headcss');
        Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('Lightgallery_Plugin', 'LightgalleryArticle');
        
    }
   
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){
	}
   
    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
	}


    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}   
   
    /**
     * 替换文章中图片链接
     *
     * @access public
     * @param string $content
     * @return void
     */
    public static function LightgalleryArticle($content, $widget, $lastResult) {
        $Archive = Typecho_Widget::widget('Widget_Archive');
    	$content = empty($lastResult) ? $content : $lastResult;
    
    	$pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
    $replacement = '
<li data-src="$1">
                <a href="$1"><img src="$1">
        </a>
</li>

     ';
    $content = preg_replace($pattern, $replacement, $content);
    $contents = str_replace(array('<p>','</p>','<br>'),'',$content);
        return '<ul id="auto-loop" class="gallery">'.$contents.'</ul>';
    }
    

    /**
     * 头部插入CSS
     *
     * @access public
     * @param unknown $headcss
     * @return unknown
     */
    public static function headcss($css) {
        $Lightgallery_assets = Helper::options()->pluginUrl .'/Lightgallery/';
		$css = '<link rel="stylesheet" href="'.$Lightgallery_assets.'css/lightGallery.css">
<style>
    	ul{
			list-style: none outside none;
		    padding-left: 0;
		}
		.gallery li {
			display: block;
			float: left;
			height: 100px;
			margin-bottom: 6px;
			margin-right: 6px;
			width: 100px;
		}
		.gallery li a {
			height: 100px;
			width: 100px;
		}
		.gallery li a img {
			max-width: 100px;
		}
    </style>
<script src="'.$Lightgallery_assets.'js/jquery.min.js"></script>
<script src="'.$Lightgallery_assets.'js/lightGallery.js"></script>
<script>
    	 $(document).ready(function() {
			$("#auto-loop").lightGallery({
				loop:true,
				auto:true,
				pause:4000
			});
		});
    </script>';
		echo $css;
    }
    
  
}