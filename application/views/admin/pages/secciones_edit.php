<?php $this -> load -> view('admin/header');?>
<?php if($result):?>
<div class="updated">
	Updated.</a>
</div>
<?php endif;?>
<h1>Jeff Lincoln Profile</h1>
<form action="/admin/content/edit"  name="edit_filter" id="edit_filter"  method="post" enctype="application/x-www-form-urlencoded" class="open_edit">
	<p style="margin-top: 25px;">
		<textarea name="content" id="content_area">
                <?=$content->content?>
                </textarea>
	</p>

	<div id="photo_status" style="position:absolute; top: 215px; right: 90px; height: auto; background-color: black;">
		<img width="200" src="<?=$content->photo?>" id="button4" style="margin-right: 0; display: block"  /><span style="margin: 8px; display: block; font-size: 14px;">Click photo to change</span>
	</div>
	
	<input type="hidden" value="<?=$content->photo?>" name="photo" id="image_val" />
	<br>
	<br>
	
	<label>
		<input type="submit" class="button padding ui-widget-content ui-corner-all" style="padding: 5px;" name="save" id="save" value="Save" />
	</label>
</form>

<script>

	$(function() {
		$("#datepicker").datepicker();
		new Ajax_upload('button4', {
			action : '/admin/profiles/photo',
			onSubmit : function(file, ext) {
				$('#photo_status').showLoading();
				this.disable();
			},
			onComplete : function(file) {
				$('#photo_status').hideLoading();
				$('#photo_status').css("backgroundColor", "yellow");
				$('#photo_status').html('<img width="200" id="button4" src="/img/' + file + '"  /><span style="margin: 8px; display: block; color:#000000; font-size: 12px;">Click save below to update photo</span>');
				$('#image_val').val("/img/" + file);
			}
		});
	});
	
	var myEditor = new YAHOO.widget.SimpleEditor('content_area', {
		height : '300px',
		width : '60%',
		dompath : true //Turns on the bar at the bottom
	});
	myEditor.render();
	YAHOO.util.Event.on('save', 'click', function() {
		myEditor.saveHTML();
	});

</script>

<?php $this -> load -> view('admin/footer');?>