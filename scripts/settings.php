<?php

if(isset($_POST['UpdateGalleryOptions']))
 {
  $UpdateData['UploadDirectory']=$_POST['update_upload_dir'];
update_option('simage_slideshow_options', $UpdateData);
$update_setting='<div style="background-color: rgb(255, 251, 204);" id="message" class="updated fade"><p>Settings updated successfully</p></div>';
 }
 
 $GalleryOptions = get_option('simage_slideshow_options');


?>
<form action="" method="post">
<table width="100%" border="0" cellspacing="4" cellpadding="4">
<?php if($update_setting){ ?>  
  <tr>
    <td colspan="3"><?php echo $update_setting?></td>
  </tr>
<?php }?>
  
  <tr>
    <td colspan="3"><h3>Gallery Settings</h3></td>
  </tr>
  

 
 
 
    <tr>
    <td><strong>Upload Directory</strong></td>
    <td><input type="text" name="update_upload_dir" id="textfield" style="height:40px; width:500px;" value="<?=$GalleryOptions['UploadDirectory']?>"/></td>
    <td>&nbsp;</td>
  </tr>
  
  
   
  
   <tr>
    <td colspan="3"><input type="submit" name="UpdateGalleryOptions" id="button" value="Update" /></td>
  </tr>
</table>

  

