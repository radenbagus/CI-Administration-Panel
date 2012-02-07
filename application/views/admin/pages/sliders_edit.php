<?php $this -> load -> view('admin/header');?>
<style>
	#logolist, #logolist_inactive {
		float: left;
		width: 85%;
		min-height: 12em;
	}
	* html #gallery {
		height: 12em;
	}/* IE6 */
	.gallery.custom-state-active {
		background: #eee;
	}
	.gallery li {
		float: left;
		width: 96px;
		padding: 0.4em;
		margin: 0 0.4em 0.4em 0;
		text-align: center;
	}
	.gallery li h5 {
		margin: 0 0 0.4em;
		cursor: move;
	}
	.gallery li a {
		float: right;
	}
	.gallery li a.ui-icon-zoomin {
		float: left;
	}
	.gallery li img {
		width: 100%;
		cursor: move;
	}
	#trash {
		float: right;
		width: 32%;
		min-height: 18em;
		padding: 1%;
	}
	* html #trash {
		height: 18em;
	}/* IE6 */
	#trash h4 {
		line-height: 16px;
		margin: 0 0 0.4em;
	}
	#trash h4 .ui-icon {
		float: left;
	}
	#trash .gallery h5 {
		display: none;
	}
</style>
<script>
		/*<![CDATA[*/
			$(function() {
				$("#datepicker").datepicker({
					dateFormat : 'yy-mm-dd'
				});
				new Ajax_upload('coverart', {
					action : '/admin/sections/upload_image/',
					onSubmit : function(file, ext) {
						$('#photo_status').html('<img src="/img/ajax-loader.gif" /> Uploading ' + file + '');
						this.disable();
					},
					onComplete : function(file) {
						$('#photo_status').html('Uploaded');
						$('#coverart_val').val('/img/press/' + file)
					}
				});
				new Ajax_upload('presspdf', {
					action : '/admin/sections/upload_pdf/',
					onSubmit : function(file, ext) {
						$('#pdf_status').html('<img src="/img/ajax-loader.gif" /> Uploading ' + file + '');
						this.disable();
					},
					onComplete : function(file) {
						$('#pdf_status').html('Uploaded');
						$('#presspdf_val').val('/img/press/' + file)
					}
				});
			});
			var myEditor = new YAHOO.widget.SimpleEditor('description', {
				height : '100px',
				width : '600px',
				dompath : true //Turns on the bar at the bottom
			});
			myEditor.render();
			myEditor.on('toolbarLoaded', function() {
				myEditor.toolbar.collapse(true);
			});
			
			YAHOO.util.Event.on('save', 'click', function() {
				myEditor.saveHTML();
			});

/*]]>*/</script>

<?php if($result) { ?>
<div class="updated">
Article updated. <a href="/admin/sections">Go to published press articles</a>
</div>
<?php  }?>
<h1><a href="/admin/sections">Press articles</a> > <?=$section->name?></h1>
<form  name="edit" id="edit" method="post" action="/admin/sections/edit/<?=$section->id?>" enctype="application/x-www-form-urlencoded" class="open_edit" >
	<label class="s" for="name">Article title</label>
	<input value="<?=$section->name?>" type="text" name="title" id="title" class="text ui-widget-content ui-corner-all medium" />	

	<label class="s" for="folder"><span>Date</span></label>
	<input value="<?=$section->date?>" type="text" name="date" id="datepicker" class="text ui-widget-content ui-corner-all medium"  />
	<label class="s" for="parent"><span>Cover art</span></label>
	<div id="photo_status">
		<a id="coverart">Upload cover art</a>
	</div>
	<input type="hidden" name="img" id="coverart_val" value="<?=$section->img?>" />
	<label class="s" for="parent"><span>PDF of Article</span></label>
	<div id="pdf_status">
		<a id="presspdf">Upload PDF article</a>
	</div>
	<input type="hidden" name="doc" id="presspdf_val" value="<?=$section->doc?>" />

	<label class="s" for="link">Link to article</label>
	<input value="<?=$section->link?>" type="text" name="link" id="link" class="text ui-widget-content ui-corner-all medium" />
	
	<label class="s" for="parent"><span>Article summary</span></label>	<textarea name="description" id="description"><?=$section->description?></textarea>
	<label>
		<input type="submit" class="padding ui-widget-content ui-corner-all" style="padding: 5px;" id="save" name="save" value="Save" />
	</label>
</form>

<?php $this -> load -> view('admin/footer'); ?>