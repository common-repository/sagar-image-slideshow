<link rel="stylesheet" href="<?=get_bloginfo('url')?>/wp-content/plugins/sagar-image-slideshow/styleTiny.css" />
<table width="100%" border="0" cellspacing="4" cellpadding="4">
  <?php
  global $wpdb; 
  $num_row = $wpdb->get_var("SELECT count(*) FROM ".$wpdb->prefix."simageslideshow");  ?>
<tr><td><div>

	<ul id="slideshow">
    <? 	
	if(!empty($atts["cat"])){$category = $atts["cat"];
	$thumbs = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."simageslideshow where category = '$category' order by imageid limit 0,10");
	}else{
	$thumbs = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."simageslideshow  order by imageid limit 0,10");
	}
	 foreach($thumbs as $thumbrow){ ?>
		<li>
			<h3><?=$thumbrow->imagetitle;?></h3>
			<span><? echo get_bloginfo('url').'/wp-content/plugins/sagar-image-slideshow/images/'.$thumbrow->largename ?> </span>
			<p><?=$thumbrow->shortdesc ;?></p>
			<a href="#"><img src="<? echo get_bloginfo('url').'/wp-content/plugins/sagar-image-slideshow/images/'.$thumbrow->thumbname ?>" alt="Orange Fish" /></a>
		</li>
        <? } ?>
        </ul>
        
        	<div id="wrapper">
		<div id="fullsize">
			<div id="imgprev" class="imgnav" title="Previous Image"></div>
			<div id="imglink"></div>
			<div id="imgnext" class="imgnav" title="Next Image"></div>
			<div id="image"></div>
			<div id="information">
				<h3></h3>
				<p></p>
			</div>
		</div>
		<div id="thumbnails">
			<div id="slideleft" title="Slide Left"></div>
			<div id="slidearea">
				<div id="slider"></div>
			</div>
			<div id="slideright" title="Slide Right"></div>
		</div>
	</div>
    <script type="text/javascript" src="<?=get_bloginfo('url')?>/wp-content/plugins/sagar-image-slideshow/js/compressed.js"></script>
<script type="text/javascript">
	$('slideshow').style.display='none';
	$('wrapper').style.display='block';
	var slideshow=new TINY.slideshow("slideshow");
	window.onload=function(){
		slideshow.auto=true;
		slideshow.speed=5;
		slideshow.link="linkhover";
		slideshow.info="information";
		slideshow.thumbs="slider";
		slideshow.left="slideleft";
		slideshow.right="slideright";
		slideshow.scrollSpeed=4;
		slideshow.spacing=5;
		slideshow.active="#fff";
		slideshow.init("slideshow","image","imgprev","imgnext","imglink");
	}
</script>

</div></td></tr>

</table>
