<?php $this->load->view('admin/header'); ?>
<script>/*<![CDATA[*/

$(function() {
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		
		var name = $( "#name" ),
			email = $( "#email" ),
			password = $( "#password" ),
			allFields = $( [] ).add( name ).add( email ).add( password ),
			tips = $( ".validateTips" );

		$("#link").change(function(){
			
			var str = $(this).val();
			
			var pattern = /[0-9]+/;
			var match = str.match(pattern);
			$("#vidid").val(match);
			
			$("#videoprev").html('<iframe src="http://player.vimeo.com/video/'+match+'" width="348" height="200" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>');

		});
			
			
		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
		}
		
		$('.stripe tr:even').addClass('alt');
		
		$( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 580,
			width: 700,
			modal: true,
			buttons: {
				"Add video": function() {
					


					$.post("http://plush.revalorizer.com/index.php/admin/videos/new", $("#new_video").serialize(),
					   function(data) {
						  	$( this ).dialog( "close" );
						  	window.location = "http://plush.revalorizer.com/index.php/admin/videos";
					   });

					
				},
				Cancel: function() {
					$( this ).dialog( "close" );
					$('#new_profile')[0].reset();
					$("#videoprev").html('<br /><br /><br /><br /><br />Insert link to visualize video');

				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#create-video" )
			.button()
			.click(function() {
				$( "#dialog-form" ).dialog( "open" );
			});
	

	
	
	
		$('.delete a').click(function(){
			var deletelink = $(this).attr('rel');

			$( "#dialog-confirm" ).dialog({
		
	
				resizable: false,
				height:140,
				modal: true,
				buttons: {
					"Delete": function() {
						$( this ).dialog( "close" );
					  	window.location = "http://plush.revalorizer.com/index.php/admin/videos/delete/"+deletelink;
	
					},
					Cancel: function() {
						$( this ).dialog( "close" );
					}
				}
			});
			return false;
		});
		
		$("#tags").multiselect({
		   selectedList: 10,
		   header: false
		});
		
		$("#pid").multiselect({
		   selectedList: 1,
		   multiple: false,
		   header: false
		});
	
	});
	
/*]]>*/</script>
<h1>Sliders</h1>
<div style="height:20px;"></div>
<div id="highlight">
<table width="99%" class="rows" style="margin-left: 15px;" border="0" cellspacing="0" id="highlight">
  <tr>
    <th>Nombre de slider</th>
    <th>Tipo</th>
    <th class="right">Acciones</th>
  </tr>
  
<?php foreach ($sliders as $s): ?>
  <tr class="stripe topbottom">
    <td><?=$s->name?></td>
    <td><?=$s->sys?></td>
    <td class="right"><a href="/index.php/admin/sections/edit/<?=$s->id?>">Editar</a></td>
  </tr>
<?php endforeach; ?>

</table>
</div>




<div id="dialog-confirm" title="Delete and dissociate this video?" style="display:none">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This video will be permanently dissociated from this website and cannot be undone later. Are you sure?</p>
</div>
<?php $this->load->view('admin/footer'); ?>