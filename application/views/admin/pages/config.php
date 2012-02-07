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

		function updateTips( t ) {
			tips
				.text( t )
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 );
			}, 500 );
		}

		
		$( "#dialog-form" ).dialog({
			autoOpen: false,
			height: 330,
			width: 290,
			modal: true,
			buttons: {
				"Create": function() {
					


					$.post("/admin/config/new", $("#new_profile").serialize(),
					   function(data) {
						  	$( this ).dialog( "close" );
						  	window.location = "/admin/config";
					   });

					
				},
				"Cancel": function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				allFields.val( "" ).removeClass( "ui-state-error" );
			}
		});

		$( "#create-user" )
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
					  	window.location = "/admin/config/delete/"+deletelink;
	
					}
				}
			});
			return false;
		})
	});
	
/*]]>*/</script>
<?php if($result) { ?>
<div class="updated">User eliminated </div>	
<?php } ?>

<button id="create-user" class="right">Create administrative user</button>
<h1>User configuration </h1>
<div style="height:20px;"></div>
<div id="highlight">
<table width="100%" class="rows" style=""  border="0" cellspacing="0" id="highlight">
  <tr>
    <th>NAME</th>
    <th>LAST NAME</th>
    <th>EMAIL</th>
    <th class="right">ACTIONS</th>
  </tr>
<?php foreach ($users as $p): ?>
  <tr>
    <td><?=$p->firstName?></td>
    <td><?=$p->lastName?></td>
    <td><?=$p->email?></td>
    <td style="text-align: right;"><span class="delete"> <a class="delete ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" style="padding: 3px; font-size: 10px;" href="" rel="<?=$p->id?>"><span style="float:left;">DELETE</span><span class="ui-icon ui-icon-trash" style="float: left;"></span></a> </span></td>
  </tr>
<?php endforeach; ?>
</table>
</div>
<div id="dialog-form" title="Create a new administrative user">
	<p class="validateTips">All fields are required</p>
	<form name="new_profile" id="new_profile">

		<label for="name">Name</label>
		<input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all long" />
		
		<label for="name">Last name</label>
		<input type="text" name="lastname" id="lastname" class="text ui-widget-content ui-corner-all long" />
		
		<label for="email">Email</label>
		<input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all long" />
		
		<label for="clave">Password</label>
		<input type="text" name="password" id="clave" value="" class="text ui-widget-content ui-corner-all long" />
		

	</form>
</div>
<div id="dialog-confirm" title="Delete user" style="display:none">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This user will be permanently deleted, are you sure?</p>
</div>
<?php $this->load->view('admin/footer'); ?>