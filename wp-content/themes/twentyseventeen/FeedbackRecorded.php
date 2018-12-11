<?php
/*
Template Name: FeedBackRecorded
*/
require_once ABSPATH .'wp-content/plugins/PortfolioFeedback/common.php';

$perpage = 10;
if(isset($_GET['abc']) && !empty($_GET['abc'])){
	$curpage = $_GET['abc'];
}else{
	$curpage = 1;
}
$start = ( $curpage * $perpage ) - $perpage;
$wpdb->get_results("SELECT * FROM wp_lws_recordfeedbacks where user_id = $user_id");
$totalres = $wpdb->num_rows;
$endpage = ceil($totalres/$perpage);
$startpage = 1;
$nextpage = $curpage + 1;
$previouspage = $curpage - 1;

$sql_get_title = $wpdb->get_results("SELECT * FROM wp_lws_recordfeedbacks where user_id = $user_id limit $start , $perpage");

if(isset($_POST['post_title'])){
	global $wpdb;
	$sql_get_title = $wpdb->get_results("SELECT * FROM wp_lws_recordfeedbacks where dept_name like '%".$_POST['post_title']."%'");
}
?>
<style>
#adminmenumain,#wpadminbar,#wpfooter {
	display:none;
}
</style>
<script src="<?php echo site_url(); ?>/wp-content/plugins/PortfolioFeedback/assets/js/sweetalert.js"></script>
<?php
require_once ABSPATH .'wp-content/plugins/PortfolioFeedback/common.php';
require_once('admin_sidebar.php');
if(!empty($statusMsg)){
        echo "<script>swal('Message!','$statusMsg','$statusMsgClass');</script>";
}?> 
            <!-- MAIN CONTENT-->
<div class="main-content">
	<div class="section__content section__content--p30">
		<div class="container-fluid">
			<div class="row">	
			<div class="container">
			<?php if($sql_get_title){ ?>
				<table class="table table-dark table-hover">
				<thead>
				  <tr>
					<th>ID</th>
					<th>Trainer Name</th>
					<th>Topic</th>
					<th>Date/Time</th>
					<th>View</th>
				  </tr>
				</thead>
				<tbody>
			<?php $id = 1;
			foreach($sql_get_title as $val){
			?>
			<tr>
			<td><?php echo $id; ?></td>
			<td><?php $train_name = lws_getTrainerName($val->trainer,$wpdb); echo $train_name[0]->name; ?></td>
			<td><?php echo $val->traing_topic; ?></td>
			<td><?php echo date('d-M-Y g:i A, l',strtotime($val->record_date)); ?></td>
			<td><span class="pop_up_info" data-id="<?php echo $val->id; ?>" data-toggle="modal" data-target="#lwsRecordModal" ><i class="fa fa-eye"></i></span></a></td>
			</tr>
			<?php  $id ++; } ?>
				</tbody>
			  </table>
	<nav aria-label="Page navigation">
		<ul class="pagination">
	  <?php if($curpage != $startpage){ ?>
		<li class="page-item">
		  <a class="page-link" href="/wp-admin/admin.php?page=lws_department&abc=<?php echo $startpage ?>" tabindex="-1" aria-label="Previous">
			<span aria-hidden="true">&laquo;</span>
			<span class="sr-only">First</span>
		  </a>
		</li>
		<?php } ?>
		<?php if($curpage >= 2){ ?>
		<li class="page-item"><a class="page-link" href="/wp-admin/admin.php?page=lws_department&abc=<?php echo $previouspage ?>"><?php echo $previouspage ?></a></li>
		<?php } ?>
		<li class="page-item active"><a class="page-link" href="/wp-admin/admin.php?page=lws_department&abc=<?php echo $curpage ?>"><?php echo $curpage ?></a></li>
		<?php if($curpage != $endpage){ ?>
		<li class="page-item"><a class="page-link" href="/wp-admin/admin.php?page=lws_department&abc=<?php echo $nextpage ?>"><?php echo $nextpage ?></a></li>
		<li class="page-item">
		  <a class="page-link" href="/wp-admin/admin.php?page=lws_department&abc=<?php echo $endpage ?>" aria-label="Next">
			<span aria-hidden="true">&raquo;</span>
			<span class="sr-only">Last</span>
		  </a>
		</li>
		<?php } ?>
	  </ul>
	</nav>
	
	<?php } else{ ?>
	<p style="color:red;">No Related Data Found</p>
	<?php } ?>
			</div>
		</div>
<?php include('admin_footer.php'); ?>
<div class="modal fade" id="lwsRecordModal" role="dialog" tabindex=-1>
<div class="modal-dialog modal-lg">
  <div class="modal-content">
	<div class="modal-header">
	  <h4 class="modal-title">Modal Header</h4>
	</div>
	<div class="modal-body title_info_data">
			  
	</div>
	<div class="modal-footer">
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
  </div>
</div>
</div>
<script>
jQuery('.pop_up_info').click(function(){
	var ids = jQuery(this).attr('data-id');
	var data_time = {
	"action": "lws_viewUserRating",
	"ids" : ids
	},
	ajaxurl = "<?php echo admin_url("admin-ajax.php") ?>";
		jQuery.post(ajaxurl, data_time, function(response) {
			response = JSON.parse(response);
			jQuery('.title_info_data').html('<table class="table table-dark table-hover"><thead><tr><th>ID</th><th>Question</th><th>Rating</th></tr></thead><tbody class="lws_list"></tbody></table>');
			html_table = '';
			counter = 1;
			jQuery.each(response,function(index,value) {
				jQuery('.lws_list').append('<tr><td>'+counter+'</td><td>'+value.ques_name+'</td><td>'+value.answr+'</td></tr>');
				counter++;
			});
	});
});
</script>

