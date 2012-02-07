<?php $this->load->view('admin/header'); ?>


	<style>
	#logolist, #logolist_inactive { float: left; width: 100%; min-height: 12em; } * html #gallery { height: 12em; } /* IE6 */
	.gallery.custom-state-active { background: #eee; }
	.gallery li { float: left; width: 96px; padding: 0.4em; margin: 0 0.4em 0.4em 0; text-align: center; }
	.gallery li h5 { margin: 0 0 0.4em; cursor: move; }
	.gallery li a { float: right; }
	.gallery li a.ui-icon-zoomin { float: left; }
	.gallery li img { width: 100%; cursor: move; }


  .ui-selecting { background: #eee; }
  .ui-selected { background: #def; }
  
  

	#trash { float: right; width: 32%; min-height: 18em; padding: 1%;} * html #trash { height: 18em; } /* IE6 */
	#trash h4 { line-height: 16px; margin: 0 0 0.4em; }
	#trash h4 .ui-icon { float: left; }
	#trash .gallery h5 { display: none; }
	</style>
	
<script>/*<![CDATA[*/

$(function() {
	
		<?php if($deleted): ?>
		showdeletenotice();
		<?php endif; ?>
		
		
		$("#logolist li").click(function() {
		  $(this).addClass("ui-selected").siblings().removeClass("ui-selected");
			
			var fr_img_pid = <?=$info?>;
			var fr_img_photo_id = $(this).attr("idmg");
		  		  	
			$.post("/admin/images/front_select", { pid: fr_img_pid, photo_id: fr_img_photo_id},
			 
					function(data) { 
						
							$("#alerts").html("");
							$("#alerts").html('<div class="updated">Photo selected as front image </div>').fadeIn(300);
							$("#alerts").delay(5000).fadeOut(600);  			
						
						}); 
			});
		

		$("#logolist").sortable({
			dropOnEmpty: true,
			handle: "img",
			placeholder: "ui-state-highlight",
			update: function(event, ui) {
					$.post("/admin/images/update", { pages: $('#logolist').sortable('serialize')}, 
					function(data) { 
						
								$("#alerts").html("");
					  			$("#alerts").html('<div class="updated">Photo order updated</div>').fadeIn(300);
					  			$("#alerts").delay(5000).fadeOut(600);
					  			
						}); 
			}
		});
		
	
		new Ajax_upload('button4', {
			action: '/admin/images/upload/<?=$info?>/<?php if($sinfo) echo $sinfo; ?>',
			onSubmit : function(file , ext){
			$("#dialog-uploading").showLoading();
			$( "#dialog-uploading" ).dialog({
				resizable: false,
				height:140,
				modal: true
			});


				this.disable();	
			},
			onComplete : function(file){
				$("#dialog-uploading").hideLoading();
				$("#dialog-uploading").dialog( "close" );
				window.location = "/admin/images/view/<?=$info?>/<?php if($sinfo) echo $sinfo; ?>";
	
			}
		});
	
		$(".ui-icon-trash").click(function(){
			var imageid = $(this).attr("rel");
			$( "#dialog-confirm" ).dialog({
				resizable: false,
				height:140,
				modal: true,
				buttons: {
					"Delete": function() {
					  	$.post("/admin/images/delete/"+imageid,
					  		function(data) {
					  			$( this ).dialog( "close" );
					  			window.location = "/admin/images/view/<?=$info?>/<?php if($sinfo) echo $sinfo; ?>";
					  			//$("#dialog-confirm").html(data);
					  		} 
					  	);
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				}
			});
			
			return false;
		});
	
		$("#edit_gallery").click(function(){
			$( "#dialog-big" ).dialog({
				resizable: true,
				height:160,
				width: 310,
				modal: true,
				buttons: {
					
					"Save changes": function() {
						$("#dialog-big").showLoading();

						var projectname = $("#pname").val();
					  	$.post("/admin/images/save/<?=$info?>/<?php if($sinfo) echo $sinfo; ?>", { name: projectname }, 
					  	
					  		function(data) {
					  			
					  			$("#dialog-big").hideLoading();
								$("#alerts").html("");
								$("#dialog-big").dialog( "close");								
					  			$("#alerts").html('<div class="updated">Project name saved.</div>').fadeIn(600);
					  			$("#alerts").delay(2000).fadeOut(600);
					  			
					  			setTimeout(gotorefreshedpage, 3000);
					  			

					  		} 
					  	);
	 
					},

					"Delete project":  function() 
					{
						var answer = confirm("Are you sure you want to delete this project and all the images that pertain to it?")
						
						if (answer){
							alert("Proceeding to delete project");
							window.location = "/admin/images/delete_project/<?=$info?>/<?php if($sinfo) echo $sinfo; ?>";
						}
					},
					
					Cancel: function() {
						$( this ).dialog( "close" );
					}
					
				}
			});
			
			return false;
		});
		
		function gotorefreshedpage () {
  			window.location = "/admin/images/view/<?=$info?>/<?php if($sinfo) echo $sinfo; ?>";
		}
		
		function showdeletenotice() {
			
			$("#alerts").html("");
			$("#alerts").html('<div class="alert">Project deleted successfully.</div>').fadeIn(300);
			$("#alerts").delay(5000).fadeOut(600);
					  			
		}
		
		$("#button-new").click(function(){
			$( "#dialog-new-project" ).dialog({
				resizable: true,
				height:240,
				width: 220,
				modal: true,
				buttons: {
					
					"Add": function() {
						$("#dialog-new-project").showLoading();
						
						var vaddpid = $("#ap_pid").val();
						var vaddname = $("#ap_name").val();
						
					  	$.post("/admin/images/new/", { addpid: vaddpid, addname: vaddname}, 
					  	
					  		function(data) {
					  			
					  			$("#dialog-new-project").hideLoading();
					  			$("#dialog-new-project").dialog( "close" );
								$("#alerts").html("");
					  			$("#alerts").html('<div class="updated">Project added.</div>').fadeIn(300);
					  			$("#alerts").delay(5000).fadeOut(600);
					  			
					  			setTimeout(gotorefreshedpage, 3000);

					  		} 
					  	);
	 
					},
					
					Cancel: function() {
						$( this ).dialog( "close" );
					}
					
				}
			});
			
			return false;
		});
	
		function opensesame(dimg) { 
			
			var deletelink = $(this).attr('rel');
			$( "#dialog-confirm" ).dialog({
				resizable: false,
				height:140,
				modal: true,
				buttons: {
					"Delete": function() {
						//alert(dimg);
	                	jQuery('#'+dimg).remove();
						$( this ).dialog( "close" );
					  	//window.location = "/index.php/admin/images/delete/"+deletelink;
	 
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				}
			});
			
			return false;
		};

	});
	
/*]]>*/</script>
<button id="button-new" role="button" class="right ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"><span class="ui-button-text">Add new project</span></button>

<h1>Projects</h1>
<div style="height:20px;"></div>
<div id="alerts" style="display:none;"></div>
<button id="button4" role="button" class="right ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"><span class="ui-button-text">Upload new image</span></button>
<button id="edit_gallery" role="button" class="right ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"><span class="ui-button-text">Edit project details</span></button>
<select id='sections'  onchange="window.open(this.options[this.selectedIndex].value,'_top')">
	<?php foreach ($cats as $c): ?>
       <option  <?php if($info == $c->id) echo 'selected="selected"'; ?> value='/admin/images/view/<?=$c->id?>'><?=$c->name?></option>
	<?php endforeach; ?>
</select>

<select id='sections'  onchange="window.open(this.options[this.selectedIndex].value,'_top')">
	<?php foreach ($scats as $sc): ?>
       <option  <?php if($sinfo == $sc->id) echo 'selected="selected"'; ?> value='/admin/images/view/<?=$info?>/<?=$sc->id?>'><?=$sc->name?></option>
	<?php endforeach; ?>
</select>


<div style="height:20px;"></div>
<?php if($logos): ?>
<ul class="sortable horizontal gallery ui-helper-reset ui-helper-clearfix" id="logolist" style="list-style: none; height:auto; clear:both; ">
	<?php foreach ($logos as $l): ?>
	<li class="ui-widget-content ui-corner-tr selectit <?php if($p_catinfo->front ==$l->id) echo "ui-selected"?>" id="logo_<?=$l->id?>" idmg="<?=$l->id?>">
		<a class="todelete" href="#" rel="<?=$l->id?>"><img class="" src="/img/gallery/<?=$l->name?>" height="100" /></a>
		<a href="" title="Delete" rel="<?=$l->id?>" class="ui-icon ui-icon-trash">Delete</a>
	</li>
	<?php endforeach; ?>
</ul>
<?php else: ?>
<br>
<h2>No images uploaded in this project yet</h2>

<?php endif; ?>
<div style="height:20px; clear:both;"></div>


<div id="dialog-uploading" title="Uploading image" style="display:none">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Uploading image</p>
</div>

<div id="dialog-confirm" title="Delete image" style="display:none">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This photo is about to be deleted permanently, are you sure?</p>
</div>

<div id="dialog-big" title="Edit project" style="display:none">
	<form name="editgallery" id="editgallery">

		<label class="s" for="name">Name of project</label>
		<input value="<?=$catinfo->name?>" type="text" name="pname" id="pname" class="text ui-widget-content ui-corner-all medium" />

	</form>
</div>


<div id="dialog-new-project" title="New project" style="display:none">

	<form name="newproject" id="newproject">
	<label class="s" for="pid">Parent project</label>	
	<select name="pid" id="ap_pid">
		<?php foreach ($cats as $c): ?>
			<option value="<?=$c->id?>"><?=$c->name?></option>
		<?php endforeach; ?>
	</select>
	
	<label class="s" for="name">Name of project</label>
	<input value="" type="text" name="name" id="ap_name" class="text ui-widget-content ui-corner-all medium" />

	</form>

</div>
<?php $this->load->view('admin/footer'); ?>