<?php $this->load->view('admin/header'); ?>
<script>/*<![CDATA[*/

$(function() {
	
	
		
		
		<?php 
		
		if($result =="about") {
			echo '$("#contactus").hide();';
			echo '$("#sub-about").addClass("selected");';
		}elseif($result =="contact") {
			echo '$("#aboutus").hide();';
			echo '$("#sub-contact").addClass("selected");';
		}else {
			echo '$("#contactus").hide();';
			echo '$("#sub-about").addClass("selected");';
		}
		
		?>
		
		
		
		
		new Ajax_upload('button4', {
			action: 'http://plush.revalorizer.com/index.php/admin/cm/upload',
			onSubmit : function(file , ext){
				$('#file_status').html('<img src="http://plush.revalorizer.com/images/ajax-loader.gif" /> Uploading ' + file + '');
				this.disable();	
			},
			onComplete : function(file){
				$('#file_status').html('Uploaded');
				$('#pdf').val('/images/docs/'+file)		
			}		
		});
		//$('.rte-zone').rte("", "toolbox");
	});
	
	$("#sub-about").click(function(){
		cleanall();
		hideall();
		$(this).addClass('selected');
		$("#aboutus").show();
		return false;
	});
	
	$("#sub-contact").click(function(){
		alert();
		cleanall();
		hideall();
		$(this).addClass('selected');
		$("#contactus").show();
		return false;
	});
	
	function cleanall() {
		$("#sub-about").removeClass("selected");
		$("#sub-contact").removeClass("selected");
	}
	
	function hideall() {
		$("#aboutus").hide();
		$("#contactus").hide();
	}
	
/*]]>*/</script>

<?php 
 
if($result =="about") {
	echo '<div class="updated">Updated.</div>';
}elseif($result =="contact") {
	echo '<div class="updated">Updated.</div>';
}

?>
<h1>Content manager</h1>
<div style="clear: both;height: 5px;"></div>
<div id="submenu" style="margin-left: 13px; ">
	<div class="primary-nav"> 
		<a id="sub-about" class="main-nav-link" href="#">About us</a>
		<a id="sub-contact" class="main-nav-link" href="#">Contact us</a>
	</div>
</div>
 <div style="clear: both;height: 0;"></div>

<form id="aboutus" name="aboutus" method="post" enctype="application/x-www-form-urlencoded" action="/index.php/admin/cm/update" style="margin-left: 15px;">

 			<label for="aboutus_text">Content</label>
	     	<textarea name="aboutus_text" id="aboutus_text" rows="10" cols="60" class="rte-zone ui-widget-content ui-corner-all"><?=$data->aboutus_text?></textarea>
	     	
	    	
			<label for="pdf">PDF</label>
			<div id="file_status">
				<a id="button4">Click to upload pdf</a>
			</div>
			
			<input type="hidden" name="aboutus_pdf" id="pdf" value="<?=$data->aboutus_pdf?>" />

			<input type="submit" class="padding ui-widget-content ui-corner-all" name="about_save" value="Save" />

</form>


<div style="clear: both;height:0;"></div>
			   
					   
<form id="contactus" name="contactus" method="post" enctype="application/x-www-form-urlencoded" action="/index.php/admin/cm/update" style="margin-left: 15px;">
			<p>
				<label for="contact_address">Address</label>
				<textarea name="contact_address" id="contact_address" rows="4" cols="40" class="rte-zone ui-widget-content ui-corner-all long"><?=$data->contact_address?></textarea>
			</p>
			<p>
				<label for="contact_email">Email</label>
				<input name="contact_email" type="text" id="contact_email" value="<?=$data->contact_email?>" class="text ui-widget-content ui-corner-all long" />
			</p>
			<p>
				<label for="contact_phone_main">Main</label>
				<input name="contact_phone_main" type="contact_phone_main" id="main" value="<?=$data->contact_phone_main?>" class="text ui-widget-content ui-corner-all long" />
			</p>
			<p>
				<label for="contact_phone_fax">Fax</label>
				<input name="contact_phone_fax" type="text" id="contact_phone_fax" value="<?=$data->contact_phone_fax?>" class="text ui-widget-content ui-corner-all long" />
			</p>
			<p>
				<label for="contact_lsdn_telos">TELOS</label>
				<input name="contact_lsdn_telos" type="text" id="contact_lsdn_telos" value="<?=$data->contact_lsdn_telos?>" class="text ui-widget-content ui-corner-all long" />
			</p>
			<p>
				<label for="contact_lsdn_prima">Prima</label>
				<input name="contact_lsdn_prima" type="text" id="contact_lsdn_prima" value="<?=$data->contact_lsdn_prima?>" class="text ui-widget-content ui-corner-all long" />
			</p>
			<p>
				<label for="twitter">Twitter URL</label>
				<input name="twitter" type="text" id="twitter" value="<?=$data->twitter?>" class="text ui-widget-content ui-corner-all long" />
			</p>
			<p>
				<label for="facebook">Facebook URL</label>
				<input name="facebook" id="facebook" type="text" value="<?=$data->facebook?>" class="text ui-widget-content ui-corner-all long" />
			</p>
			<p>
				<label for="vimeo">Vimeo URL</label>
				<input name="vimeo" type="text" id="vimeo" value="<?=$data->vimeo?>" class="text ui-widget-content ui-corner-all long" />
			</p>
			<p>
				<input type="submit" class="padding ui-widget-content ui-corner-all" name="contact_save" value="Save" />
			</p>
</form>

<script>/*<![CDATA[*/
	
	$("#sub-about").click(function(){
		cleanall();
		hideall();
		$(this).addClass('selected');
		$("#aboutus").show();
		return false;
	});
	
	$("#sub-contact").click(function(){
		cleanall();
		hideall();
		$(this).addClass('selected');
		$("#contactus").show();
		return false;
	});
	
	function cleanall() {
		$("#sub-about").removeClass("selected");
		$("#sub-contact").removeClass("selected");
	}
	
	function hideall() {
		$("#aboutus").hide();
		$("#contactus").hide();
	}
	
/*]]>*/</script>
<?php $this->load->view('admin/footer'); ?>