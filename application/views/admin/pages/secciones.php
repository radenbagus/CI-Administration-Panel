<?php $this -> load -> view('admin/header');?>
<script>
	/*<![CDATA[*/

	$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$("#dialog:ui-dialog").dialog("destroy");

		var name = $("#name"), email = $("#email"), password = $("#password"), allFields = $([]).add(name).add(email).add(password), tips = $(".validateTips");

		function updateTips(t) {
			tips.text(t).addClass("ui-state-highlight");
			setTimeout(function() {
				tips.removeClass("ui-state-highlight", 1500);
			}, 500);
		}


		$("#dialog-form").dialog({
			autoOpen : false,
			height : 530,
			width : 340,
			modal : true,
			buttons : {
				"Create article" : function() {
					$('#dialog-form').showLoading();
					myEditor.saveHTML();
					$.post("/admin/sections/new", $("#new_filter").serialize(), function(data) {
						$(this).dialog("close");
						window.location = "/admin/sections";
					});
				},
				Cancel : function() {
					$(this).dialog("close");
				}
			},
			close : function() {
				allFields.val("").removeClass("ui-state-error");
			}
		});

		$("#create-filter").button().click(function() {
			$("#dialog-form").dialog("open");
		});

		$('.delete a').click(function() {
			var deletelink = $(this).attr('rel');

			$("#dialog-confirm").dialog({

				resizable : false,
				height : 140,
				modal : true,
				buttons : {
					"Delete" : function() {
						$(this).dialog("close");
						window.location = "/admin/sections/delete/" + deletelink;

					},
					Cancel : function() {
						$(this).dialog("close");
					}
				}
			});
			return false;
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
	/*]]>*/
</script>
<?php if($result) {
?>

<div class="updated">
	Article deleted.
</div>
<?php }?>

<button id="create-filter" class="right" style="padding-bottom: 4px;">
	<span class="ui-icon ui-icon-plus" style="float: left;"></span><span style="float:left; padding-top: 0px;">Create Press Article</span>
</button>
<h1>Press articles</h1>
<div style="height:20px;"></div>
<table width="100%" class="rows" style=""  border="0" cellspacing="0" id="highlight">
	<tr style="margin-bottom: 5px; border-bottom: 1px dotted #CCC;" >
		<th>ARTICLE TITLE</th>
		<th class="right">ACTION</th>
	</tr>
	<?php foreach ($data as $f):
	?>
	<tr class="topbottom" style="padding: 5px;">
		<td><?=$f->name
		?></td>
		<td style="text-align: right;"><a class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" style="padding: 3px; font-size: 10px;" href="/admin/sections/edit/<?=$f->id?>"><span style="float:left;">EDIT</span><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a><span class="delete "> <a href="#" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" style="font-size: 10px; padding: 3px;" rel="<?=$f->id?>"><span style="float:left;">DELETE</span><span class="ui-icon ui-icon-trash" style="float: left;"></span></a></span></td>
	</tr>
	<?php endforeach;?>
</table>
<div id="dialog-form" title="Create new section">
	<p class="validateTips">
		All the fields are required
	</p>
	<form name="new_filter" id="new_filter">
		<label class="s" for="name">Title</label>
		<input value="" type="text" name="name" id="name" class="text ui-corner-all  ui-widget-content large" />
		<label class="s" for="date"><span>Date</span></label>
		<input value="" type="text" name="date" id="datepicker" class="text ui-widget-content ui-corner-all large"  />
		<label class="s" for="parent"><span>Cover art</span></label>
		<div id="photo_status">
			<a id="coverart">Click to upload cover art</a>
		</div>
		<input type="hidden" name="img" id="coverart_val" value="" />
		<label class="s" for="parent"><span>PDF of Article</span></label>
		<div id="pdf_status">
			<a id="presspdf">Click to upload PDF article</a>
		</div>
		<input type="hidden" name="doc" id="presspdf_val" value="" />
		<label class="s" for="parent"><span>Article summary</span></label>
		<textarea name="description" id="description">
	</textarea>
	</form>
</div>
<div id="dialog-confirm" title="Delete this press article?" style="display:none">
	<p>
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This press article and all the information related to it will be deleted permanently, do you wish to continue?
	</p>
</div>
<script>
	$(function() {
		$("#datepicker").datepicker({
			dateFormat : 'yy-mm-dd'
		});
	});
	var myEditor = new YAHOO.widget.SimpleEditor('description', {
		height : '100px',
		width : '100%',
		dompath : true //Turns on the bar at the bottom
	});

	myEditor.render();

	myEditor.on('toolbarLoaded', function() {
		myEditor.toolbar.collapse(true);
	});

</script>
<?php $this -> load -> view('admin/footer');?>