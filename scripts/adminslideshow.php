<?php
global $wpdb; 
$GalleryOptions = get_option('simage_slideshow_options');
if(isset($_POST['submit'])){
$description=$_POST['image_desc'];
$img_title=$_POST['img_title'];
$category=$_POST['category'];
$newCat=$_POST['newCat'];
$image_name=$_FILES['image']['name'];
$thumb_name="thumb_" . $_FILES['image']['name'];
$large_name="large_" . $_FILES['image']['name'];
$image_size = $_FILES['image']['size'];
$image_type = $_FILES['image']['type'];
$image_tmp_nm = $_FILES['image']['tmp_name'];
$valid_extension=array('JPEG','jpeg','PNG','png' ,'GIF','gif','JPG','jpg');
$uploads_dir = $GalleryOptions['UploadDirectory'] ;
 $ext = explode('/' ,$image_type);
  if(!in_array($ext['1'] , $valid_extension))
          {
              $error = "File is not valid";
          } 
  
       if($image_size > 2000000 or $image_size == 0)
            {
              $error = "File is too large or there is no file to upload";
            }
		if(!$error){	
		list($width,$height)=getimagesize($image_tmp_nm);
	
	     //start of image resize 
		  	$src = imagecreatefromjpeg($image_tmp_nm);			
			// large image with width:400px and height:300px
			$newwidth=400;
			$newheight=300;
			$tmp1=imagecreatetruecolor($newwidth,$newheight);			
			imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth,$newheight,$width,$height);					
			$filename = $uploads_dir . "large_" . $image_name;
			imagejpeg($tmp1,$filename,100);
			//move_uploaded_file($image_tmp_nm, $uploads_dir . $image_name);
			
			$newwidth=100;
			//$newwidth=150;
			$newheight=($height/$width)*$newwidth;
			$tmp=imagecreatetruecolor($newwidth,$newheight);			
			imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);					
			$filename = $uploads_dir . "thumb_" . $image_name;
			imagejpeg($tmp,$filename,100);
			move_uploaded_file($image_tmp_nm, $uploads_dir . $image_name);
			 //end of image resize			 
			 imagedestroy($src);
             imagedestroy($tmp);
			 imagedestroy($tmp1);
			 $cat = 1;
			 $sql="";
			 if(!empty($newCat)){
			 $row = $wpdb->get_row("SELECT category FROM ".$wpdb->prefix."simageslideshow order by category desc");
			{$category = $row->category+1; 	
			}}
			else{$row = $wpdb->get_row("SELECT category_name FROM ".$wpdb->prefix."simageslideshow where category=$category order by category desc");
			$newCat = $row->category_name;
			}
			$query="insert into ".$wpdb->prefix."simageslideshow(imageid,imagename,thumbname,largename,shortdesc,category,category_name) values('','$img_title','$thumb_name','$large_name','$description','$category','$newCat')";
			$wpdb->query($query); 
	echo '<script>window.location="'.get_bloginfo('url').'/wp-admin/options-general.php?page=image-gallery.php&message=1"</script>';
 }
}
if(isset($_POST['update'])){

$image_id=$_POST['image_id'];
$description=$_POST['image_desc'];
$img_title=$_POST['img_title'];
$category=$_POST['category'];
$newCat=$_POST['newCat'];
$img_title=$_POST['img_title'];
$image_name=$_FILES['image']['name'];
$thumb_name="thumb_" . $_FILES['image']['name'];
$image_size = $_FILES['image']['size'];
$image_type = $_FILES['image']['type'];
$image_tmp_nm = $_FILES['image']['tmp_name'];
$valid_extension=array('JPEG','jpeg','PNG','png' ,'GIF','gif','JPG','jpg');
$uploads_dir = $GalleryOptions['UploadDirectory'] ;
$ext = explode('/' ,$image_type);
 
 
  if($image_name){
  if(!in_array($ext['1'] , $valid_extension))
          {
              $error = "File is not valid";
          } 
  
       if($image_size > 2000000 or $image_size == 0)
            {
              $error = "File is too large or there is no file to upload";
            }
			
		if(!$error){	
	     //start of image resize
		 	list($width,$height)=getimagesize($image_tmp_nm);
	     //start of image resize 
		  	$src = imagecreatefromjpeg($image_tmp_nm);			
			// large image with width:400px and height:300px
			$newwidth=400;
			$newheight=300;
			$tmp1=imagecreatetruecolor($newwidth,$newheight);			
			imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth,$newheight,$width,$height);					
			$filename = $uploads_dir . "large_" . $image_name;
			imagejpeg($tmp1,$filename,100);
			//move_uploaded_file($image_tmp_nm, $uploads_dir . $image_name);
			
			$newwidth=100;
			//$newwidth=150;
			$newheight=($height/$width)*$newwidth;
			$tmp=imagecreatetruecolor($newwidth,$newheight);			
			imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);					
			$filename = $uploads_dir . "thumb_" . $image_name;
			imagejpeg($tmp,$filename,100);
			move_uploaded_file($image_tmp_nm, $uploads_dir . $image_name);
			 //end of image resize			 
			 imagedestroy($src);
             imagedestroy($tmp);
			 imagedestroy($tmp1);	
		  
		  
	}
	}else{	
		$image_name=$_POST['image_name'];
		$thumb_name=$_POST['thumb_name'];
			
}

		 	 $cat = 1;
			 if(!empty($newCat)){
			 $row = $wpdb->get_row("SELECT category FROM ".$wpdb->prefix."simageslideshow order by category desc");
			{$category = $row->category+1; 	
			}}
			else{$row = $wpdb->get_row("SELECT category_name FROM ".$wpdb->prefix."simageslideshow where category=$category order by category desc");
			$newCat = $row->category_name;
			}
		
		$query="update ".$wpdb->prefix."simageslideshow set imagename='$img_title',thumbname='$thumb_name',shortdesc='$description', category='$category',category_name ='$newCat' where imageid='$image_id'";
		$wpdb->query($query); 
	$update_success='<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p>Image updated successfully</p></div>';
 }



?>
<style type="text/css">
a{ text-decoration:none; font-size:12px;}
</style>
<div class="wrap">
 <table width="100%" border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td colspan="4"><h2>Sagar Image Slideshow</h2></td>
   </tr>
  <tr>
    <td width="25%" ><a href="<?php echo $base_url?>?page=image-gallery.php" class="edit"><strong>Gallery Home</strong></a></td>
    <td width="25%"><a href="<?php echo $base_url?>?page=image-gallery.php&option=add_new" class="edit"><strong>Upload New</strong></a></td>
    <td width="25%"><a href="<?php echo $base_url?>?page=image-gallery.php&option=settings" class="edit"><strong>Settings</strong></a></td>
    <td width="25%"><a href="<?php echo $base_url?>?page=image-gallery.php&option=help" class="edit"><strong>Help</strong></a></td>
  </tr>
   <tr>
    <td colspan="4"><hr></td>
    </tr>
  <?php if($_GET['message']) {?>
   <tr>
    <td colspan="4">
      
    <?php if($_GET['message']==1){
	echo '<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p>Image successfully uploaded</p></div>';
	}else{
	if($_GET['message']==2){
	echo '<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p>Image successfully deleted</p></div>';
	}else{
	echo '<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p>Image successfully restored</p></div>';
	}
	}
	?>
    </td>
  </tr>
 <?php } ?>
    
    
  <tr><td colspan="4">
<?php 
	$option=$_GET['option'];
	switch($option){
	  case 'add_new': 
	    {
		
    $catList = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."simageslideshow group by category");
?>
<form action="" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td><h3>Add Image</h3></td>
    <td>&nbsp;</td>
  </tr>
    <tr>
    <td><strong>Image title</strong></td>
    <td><input type="text" name="img_title" id="textfield" /></td>
  </tr>

  <tr>
    <td><strong>Browse Image</strong></td>
    <td><input type="file" name="image" id="textfield" size="45" /><br><?php echo $error;?></td>
  </tr>
  
   
  <tr>
    <td valign="top"><strong>Select Category</strong></td>
    <td><select name="category" id="category" >
    <option value="z">select category</option>
    <?php foreach($catList as $catList){?>
    <option value="<?=$catList->category?>"><?=$catList->category_name?></option>
    <?php } ?>
    
    </select></td>
  </tr>
    <tr>
    <td><strong>Insert new category</strong></td>
    <td><input type="text" name="newCat" id="newCat" /></td>
  </tr>
  <tr>
    <td valign="top"><strong>Image short description</strong></td>
    <td><textarea name="image_desc" id="textarea" cols="40" rows="3"></textarea></td>
  </tr>
  
  <tr>
    <td colspan="2"><input type="submit" name="submit" id="button" value="Submit" /></td>
    </tr>
</table>
</form>

<?php
break;
}
case 'edit':
$imgid=$_GET['img_id'];
$catList = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."simageslideshow group by category ");

$row = $wpdb->get_row("SELECT * FROM  ".$wpdb->prefix."simageslideshow WHERE imageid='$imgid'");
{
 ?>
 <form action="" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="4" cellpadding="4">


  <tr>
    <td><h3>Edit Image</h3></td>
    <td>&nbsp;</td>
  </tr>
  <?php if($update_success){?>
<tr>
    <td colspan="2"><?=$update_success?></td>
 </tr>
<?php } ?>
<tr>
    <td><strong>Image title</strong></td>
    <td><input type="text" name="img_title" id="textfield"  value="<?php  echo $row->imagename;?>"/></td>
  </tr>
  <tr>
    <td valign="top"><strong>Browase a Image</strong></td>
    <td><input type="file" name="image" id="textfield" size="45" /><input name="image_name" type="hidden" value="<?php echo $row->imagename;?>" /><input name="thumb_name" type="hidden" value="<?php echo $row->thumbname;?>" /><input name="image_id" type="hidden" value="<?php echo $row->imageid;?>" />
   
    <?php echo '<br>'.$error;?></td>
  </tr>
   
  <tr>
    <td><strong>Image short description</strong></td>
    <td><textarea name="image_desc" id="textarea" cols="40" rows="3"><?php echo $row->shortdesc;?></textarea></td>
  </tr>
  <tr>
    <td valign="top"><strong>Select Category</strong></td>
    <td><select name="category" id="category" >
    <option value="z">select category</option>
    <?php foreach($catList as $catList){
	$select ="";
	if($catList->category == $row->category){$select ="selected"; }
	?>
    <option value="<?=$catList->category?>" <?=$select?>><?=$catList->category_name?></option>
    <?php } ?>
    
    </select></td>
  </tr>
    <tr>
    <td><strong>Insert new category</strong></td>
    <td><input type="text" name="newCat" id="newCat" /></td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" name="update" id="button" value="Submit" /></td>
    </tr>
</table>
</form>

<?php
break;
}


case 'delete':
	    {
			if($_POST['imagedeleteyes']){
					$thumb_name=$_POST['thumb_name'];
					$image_name=$_POST['image_name'];
					$image_id= $_POST['image_id'];
					$delete_query="delete from ".$wpdb->prefix."simageslideshow where imageid='$image_id'";
					$wpdb->query($delete_query);
					if(file_exists($thumb_name))
					  {
						unlink($thumb_name);
					  }
					  if(file_exists($image_name))
					  {
						unlink($image_name);
					  }
			echo '<script>window.location="'.get_bloginfo('url').'/wp-admin/options-general.php?page=image-gallery.php&message=2"</script>';	  
		  }else{
		  if($_POST['imagedeleteno']){
		  echo '<script>window.location="'.get_bloginfo('url').'/wp-admin/options-general.php?page=image-gallery.php&message=3"</script>';
		  }
     }


 
$imgid=$_GET['img_id'];
$sql="SELECT * FROM wp_simageslideshow WHERE imageid='$imgid'";
$row = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."simageslideshow WHERE imageid='$imgid'");

?>

<form action="" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td width="25%"><h3>Confirm Delete</h3></td>
    <td width="75%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
    <img src="<?=get_bloginfo('wpurl')?>/wp-content/plugins/sagar-image-slideshow/images/<?=$row->thumbname?>"/>
      <input name="thumb_name" type="hidden" value="<?php echo $row->thumbname;?>" />
      <input name="image_name" type="hidden" value="<?php echo $row->imagename;?>" />
      <input name="image_id" type="hidden" value="<?php echo $row->imageid;?>" />
      <br></td>
    </tr>
   
  <tr>
    <td><strong>Image title</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><?php echo $row->imagename;?></td>
    </tr>

   <tr>
     <td colspan="2">&nbsp;</td>
     </tr>
  <tr>
    <td><input type="submit" name="imagedeleteyes" id="button" value="Yes" /></td>
    <td><input type="submit" name="imagedeleteno" id="button" value="No" /></td>
  </tr>
</table>
</form>

 <?php	 
	 break;
}

case 'settings':
	{
       include('settings.php');
	   break;
		}
		
		
		
case 'help':
	{
       include('help.php');
	   break;
	}		
		

		
		
	default :	
	   {
		
    $checkpost = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."simageslideshow ");
		?>	
          <table width="100%" border="1" cellspacing="4" cellpadding="4">
          <tr>
            <td align="left" class=""><strong>Thumbnail</strong></td>
            <td align="left"><strong>Description</strong></td>
            <td align="left"><strong>Category</strong></td>
            <td align="left"><strong>Actions</strong></td>
          </tr>
			
<?php foreach($checkpost as $checkposts){?>
<tr>
<td width="18%" style="border:1px solid #cfcfcf;"><img src="<?=get_bloginfo('wpurl')?>/wp-content/plugins/sagar-image-slideshow/images/<?php echo $checkposts->thumbname?>"/></td>
<td valign="top" width="35%" style="border:1px solid #cfcfcf;"><?php echo $checkposts->shortdesc?></td>
<td valign="top" width="15%" style="border:1px solid #cfcfcf;">&nbsp;&nbsp;<?php echo $checkposts->category_name?><br />[view_slideshow cat="<?php echo $checkposts->category?>"] </td>

<td valign="top" style="border:1px solid #cfcfcf;" align="left">&nbsp;&nbsp;
<a href="<?php echo $base_url?>?page=image-gallery.php&option=edit&img_id=<?php echo $checkposts->imageid ?>" class="current"><strong>Edit Image</strong></a>&nbsp;&nbsp;&nbsp;
<a href="<?php echo $base_url?>?page=image-gallery.php&option=delete&img_id=<?php echo $checkposts->imageid ?>" class="current"><strong>Delete Image</strong></a></td>
</tr>
<?php }?>
</table>
<?php break;
	   }
	}
	?>
</td> </tr>   
</table>
</div>