<?php
/* 
Plugin Name:Sagar Image Slideshow
Plugin URI: http://www.worldweblife.com/
Version: v1.00
Author: Sagar Ratnaparkhi
Description: This plugin is jscript based slideshow with scrolling thumbnail. Upload image resizes with large one and its thumnail and showed it as photo album.
Email : sagar.ibmr@gmail.com
*/
if (function_exists('register_activation_hook')) {
register_activation_hook(__FILE__,'slideshow_install');
}
if(function_exists('register_deactivation_hook')){
register_deactivation_hook( __FILE__, 'slideshow_uninstall' );
}


add_action('admin_menu', 'SlideshowMenu');
//Creating table Structure




function slideshow_install()
{
    global $wpdb;
    global $jal_db_version;
    $table_name = $wpdb->prefix."simageslideshow";
   if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
      $sql = "CREATE TABLE ".$table_name." (
  `imageid` mediumint(9) NOT NULL AUTO_INCREMENT,
  `imagename` varchar(250) NOT NULL,
  `imagetitle` varchar(250) NOT NULL,
  `thumbname` varchar(250) NOT NULL,
  `largename` varchar(250) NOT NULL,
  `shortdesc` text NOT NULL,
  `imageurl` varchar(55) NOT NULL,
  `category` int(10) NOT NULL DEFAULT '100',
  `category_name` varchar(250) NOT NULL,
  UNIQUE KEY `imageid` (`imageid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;";
	


      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

     
}

$gallery_options= array(
'UploadDirectory'=>$_SERVER['DOCUMENT_ROOT'] .'/wp-content/plugins/sagar-image-slideshow/images/',
);
 add_option("simage_slideshow_options", $gallery_options, '', 'yes');
}
//Creating table Structure ends

function slideshow_uninstall()
{
 delete_option('simage_slideshow_options');
}

function SlideshowMenu() {
  add_options_page('Sagar Image Slideshow', 'Sagar Image Slideshow', 5, basename(__FILE__), 'GalleryAdminSlideshow');
}
function GalleryAdminSlideshow() {
include('scripts/adminslideshow.php');
 
}

// front view of gallery
add_shortcode('view_slideshow', 'showImageSlideshow');
function showImageSlideshow($atts){
$GalleryOptions = get_option('simage_slideshow_options');
$atts = $atts;
include('scripts/static.php');

 }
  ?>