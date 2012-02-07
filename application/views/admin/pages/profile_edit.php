<?php $this->load->view('admin/header'); ?>
<script>/*<![CDATA[*/

$(function() {

		new Ajax_upload('button4', {
			action: 'http://plush.revalorizer.com/index.php/admin/profiles/photo',
			onSubmit : function(file , ext){
				$('#photo_status').showLoading();
				//$('#photo_status').html('<img src="http://plush.revalorizer.com/images/ajax-loader.gif" /> Uploading ' + file + '');
				this.disable();	
			},
			onComplete : function(file){
				$('#photo_status').hideLoading();
				$('#photo_status').css("backgroundColor", "yellow");
				$('#photo_status').html('<img id="button4" src="http://plush.revalorizer.com/images/techs/thumbnails/'+file+'"  /><span style="margin: 8px; display: block; color:#000000; font-size: 14px;">Update profile to save</span>');
				$('#photo').val("/images/techs/thumbnails/"+file);
			}		
		});

});

/*]]>*/</script>
<?php if($result):  ?>
	<div class="updated">
		Updated. <a href="/index.php/admin/profiles">Go to list of profiles.</a> 
	</div>
<?php endif; ?>
<h1>Editing profile for <strong><?=$profiles->name?> <?=$profiles->lastname?></strong></h1>
<form name="new_profile" id="new_profile" class="open_edit" enctype="application/x-www-form-urlencoded" method="post">
	<div id="photo_status" style="float: right; height: auto; background-color: black;">
			<img src="http://plush.revalorizer.com/<?=$profiles->photo?>" id="button4" style="margin-right: 0; display: block"  />
			<span style="margin: 8px; display: block; font-size: 14px;">Click photo to change</span>
	</div>
	
		<label for="name"><span>First Name</span></label>
		<input value="<?=$profiles->name?>" type="text" name="name" id="name" class="text ui-widget-content ui-corner-all medium" />
		
		<label for="name"><span>Last Name</span></label>
		<input value="<?=$profiles->lastname?>" type="text" name="lastname" id="lastname" class="text ui-widget-content ui-corner-all medium" />
		
		<label for="email"><span>Email</span></label>
		<input value="<?=$profiles->email?>" type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all medium" />

		<label for="bio"><span>Biography</span></label>
		<textarea name="bio" id="bio" value="" cols="45" rows="6" class="text ui-widget-content ui-corner-all long" ><?=$profiles->biography?></textarea>
		
		<label for="vimeo"><span>Vimeo Album</span></label>
		<input value="<?=$profiles->vimeo?>" type="text" name="vimeo" id="vimeo" value="" class="text ui-widget-content ui-corner-all medium" />

		<label for="position"><span>Position</span></label>
		<input value="<?=$profiles->position?>" type="text" name="position" id="position" value="" class="text ui-widget-content ui-corner-all long" />

		<input type="hidden" value="<?=$profiles->photo?>" name="photo" id="photo" />
		<label>
			<input type="submit" class="button padding ui-widget-content ui-corner-all" name="go_update" value="Update profile" />
        </label>
	</form>
<?php $this->load->view('admin/footer'); ?>