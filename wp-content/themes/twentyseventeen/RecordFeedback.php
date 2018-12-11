<?php
/*
Template Name: RecordFeedback
*/
?>
<style>
#adminmenumain,#wpadminbar,#wpfooter {
	display:none;
}
.rateYo img {
	height:60px;
}
.emoji:hover {
	transform: scale(1.2);
}
.formerror{
	color: red;
}
</style>
<script src="<?php echo site_url(); ?>/wp-content/plugins/PortfolioFeedback/assets/js/sweetalert.js"></script>
<?php
require_once ABSPATH .'wp-content/plugins/PortfolioFeedback/common.php';

if(isset($_POST['lws-button-sending'])){
	
	$time_batches = trim($_POST['time_batches']);
	$lws_t1 = explode(':',$time_batches);
	if($lws_t1[1] == 30 || $lws_t1[1] == 00 && $lws_t1[2] == 00  && count($lws_t1) == 3){
	$trainer = trim($_POST['trainer']);
	$record_date = trim($_POST['record_date'].' '.$time_batches);
	$traing_topic = trim($_POST['traing_topic']);
	// Search for date
	$wpdb->query("select record_date from wp_lws_recordfeedbacks where record_date = '$record_date' AND user_id = '$user_id' AND trainer = '$trainer'");
	
	// If not found for specific date and time
	if($wpdb->num_rows == 0){
		
		$chk_flag = array();
		
		$chk_flags = 1;
		foreach($_POST['lws_submit_ans'] as $key=>$val){
			if(empty($val)){
				$chk_flag[] = $key;
				$chk_flags = 0;
			}
		}
		if($chk_flags == 1){
		$wpdb->query("insert into wp_lws_recordfeedbacks set trainer = '$trainer',record_date = '$record_date',traing_topic = '$traing_topic',user_id = '$user_id',curnt_time = NOW()");
		
		$lastid = $wpdb->insert_id;
		$lws_sqls ='';
		$lws_sql = "insert into `wp_lws_answrs` (`ques_id`,`answr`,`record_id`) VALUES ";
		foreach($_POST['lws_submit_ans'] as $key=>$val){
			$lws_sqls .= '('. $key.','.$val.','.$lastid .'),';
		}
		$lws_sql .= rtrim($lws_sqls,",");
		$wpdb->query($lws_sql);
		$statusMsgClass = 'success';
		$statusMsg = "Data successfully saved";
		}else{
		$statusMsgClass = 'error';
		$statusMsg = "Select all answers";	
		}
	}else{
		$statusMsgClass = 'error';
		$statusMsg = "All reday booked for this time slot";
	}
	}else{
		$statusMsgClass = 'error';
		$statusMsg = "Time Format is not correct";
	}
}
require_once('admin_sidebar.php');
if(!empty($statusMsg)){
        echo "<script>swal('Message!','$statusMsg','$statusMsgClass');</script>";
} ?> 
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            
							
							<div class="container">
  
  <div id="accordion">
    <div class="card">
      <div class="card-header">
        <a class="card-link" data-toggle="collapse" href="#collapseOne">
          First Process
        </a>
      </div>
      <div id="collapseOne" class="collapse show" data-parent="#accordion">
        <div class="card-body">
          <form action="" method="post" id="lws-button-sending">
			<div class="form-group">
				<label for="cc-payment" class="control-label mb-1">Select Trainer</label>
				<select class="form-control" name="trainer" id="trainer">
				<?php $trainerFetch = trainerFetch($wpdb); 
				foreach($trainerFetch as $val){?>
				<option value="<?php echo $val->id; ?>"><?php echo $val->name; ?></option>
				<?php }?>
				</select>
			</div>
			<div class="form-group">
				<div class="form-group pmd-textfield pmd-textfield-floating-label">
				<label class="control-label" for="datepicker-start">Date</label>
				<input type="text" class="form-control" id="lws_time_datetimes" name="record_date" autocomplete="off"><span id="datetimes_error" style="color:red">
				</div>
			
				<div class="form-group pmd-textfield pmd-textfield-floating-label">
				<label class="control-label" for="datepicker-start">Time Batches</label>
				<select name="time_batches" class="form-control">
				<?php foreach($array_time as $key=>$val){?>
				<option value="<?php echo $key; ?>"><?php echo  $val; ?></option>
				<?php }?>
				</select>
				</div>
			</div>
			<div class="form-group">
				<label for="cc-payment" class="control-label mb-1">Training Topic</label>
				<textarea name="traing_topic" id="traing_topic" class="form-control"></textarea><span id="traing_topic_error" style="color:red">
			</div>
			<div>
				<button  type="button" id="recordFeedback" class="btn btn-sm btn-info">
				<i class="fa fa-submit fa-lg"></i>&nbsp;
				<span id="payment-button-amount">Submit</span>
				<span id="payment-button-sending" style="display:none;">Sending…</span>
				</button>
			</div>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <a class="collapsed card-link" data-toggle="collapse" >
        Second Process
      </a>
      </div>
      <div id="collapseTwo" class="collapse" data-parent="#accordion">
        <div class="card-body">
         
			<div class="container">
			<?php $lws_cout=1; foreach($ques_bank as $key=>$val){ ?>
				<h4 class="col-md-12">
				<?php echo $lws_cout; ?> ->
                <?php echo $val->ques_name; ?>? *</h2><h4 class="col-md-12"></h4>
				<div class="rating">
					<div class="rateYo">
						<img src="<?php echo site_url();?>/wp-content/plugins/PortfolioFeedback/assets/images/very-poor.png" data-value="1" class="emoji">
							<img src="<?php echo site_url();?>/wp-content/plugins/PortfolioFeedback/assets/images/poor.png" data-value="2" class="emoji">
							<img src="<?php echo site_url();?>/wp-content/plugins/PortfolioFeedback/assets/images/average.png" data-value="3" class="emoji">
							<img src="<?php echo site_url();?>/wp-content/plugins/PortfolioFeedback/assets/images/good.png" data-value="4" class="emoji">
							<img src="<?php echo site_url();?>/wp-content/plugins/PortfolioFeedback/assets/images/excellent.png" data-value="5" class="emoji">
						<input type="hidden" name="lws_submit_ans[<?php echo $val->id; ?>]" class="val" >
						<?php if(isset($chk_flag)){
				foreach($chk_flag as $lol){ if($lol == $val->id){ ?><span class="formerror">Required</span><?php  } } } ?>
						<span class="formerror" ></span>
					</div>
				</div>
				<?php $lws_cout++; } ?>
				<button type="submit"  name="lws-button-sending" class="btn btn-sm btn-info" >Submit</button>
				</form>
			</div>
		</form>
        </div>
      </div>
    </div><!--
    <div class="card">
      <div class="card-header">
        <a class="collapsed card-link" data-toggle="collapse" href="#collapseThree">
          Collapsible Group Item #3
        </a>
      </div>
      <div id="collapseThree" class="collapse" data-parent="#accordion">
        <div class="card-body">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        </div>
      </div>
    </div>-->
  </div>
</div>
</div>
<?php include('admin_footer.php'); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!--<link href="<?php echo site_url(); ?>/wp-content/plugins/PortfolioFeedback/assets/css/pmd-datetimepicker.css" rel="stylesheet" media="all">-->
<script>
jQuery( function() {
jQuery( "#lws_time_datetimes" ).datepicker({ minDate: 0,dateFormat: 'yy-mm-dd'	});
} );
jQuery('#recordFeedback').click(function(){
	flag = 0;
	traing_topic = jQuery('#traing_topic').val();
	lws_time_datetimes = jQuery('#lws_time_datetimes').val();
	if(traing_topic == ''){
		flag = 1;
		jQuery('#traing_topic_error').html("Required");
	}else{
		jQuery('#traing_topic_error').html("");
	}

	var lws_regex = /(((0|1)[0-9]|2[0-9]|3[0-1])\/(0[1-9]|1[0-2])\/((19|20)\d\d))$/;
	//Check whether valid dd/MM/yyyy Date Format.
	if (lws_regex.test(lws_time_datetimes) || lws_time_datetimes.length == 0) {
		flag = 1;
		jQuery('#datetimes_error').html("Required");
	}else{
		jQuery('#datetimes_error').html("");
	}
	if(flag == 1){
		return false;
	}else{
		jQuery('#collapseOne').removeClass("show");
		jQuery('#collapseTwo').addClass("show");
	}
	
});
jQuery("input,textarea").click(function(){
	jQuery(this).children("span").html("");
});

$('.val').keyup(function(){
	$(this).next('.formerror').html("");
});

$('.emoji').click(function(){
	$rte = $(this).attr('data-value');
	$(this).parent().find('.formerror').html("");
	$(this).parent().find('.emoji').css("cssText", "height: 60px !important;");
	$(this).css("cssText", "height: 110px !important; -webkit-filter: grayscale(100%);");
	$(this).parent().find('.val').val($rte);
});
$('#lws-button-sending').submit(function (){
	var errot=0;
	$( ".val" ).each(function( index ) {
		if($( this ).val() == ''){
			//errot = 1;
			$(this).next('.formerror').html("Required");
		}else{
			$(this).next('.formerror').html(" ");
		}
	});
	if(errot == 1){
	return false;
	}else{
		alert("Thank You for sharing the feedback. All the best for your future endeavors.");
	return true;
	}
});
</script>
