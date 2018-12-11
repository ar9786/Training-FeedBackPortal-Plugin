<?php 
global $wpdb;
$perpage = 10;
if(isset($_GET['status_id']) && !empty($_GET['status_id'])){
	$status;
	if($_GET['status'] == 0){
		$status = 1;
	}else{
		$status = 0;
	}
	$wpdb->query("update wp_lws_departments set  status = '".$status."' where  id = '".$_GET['status_id']."'");
}
if(isset($_POST['dept_name'])){
	$wpdb->query("insert into wp_lws_departments set dept_name = '".$_POST['dept_name']."'");
}

if(isset($_POST['FP_update_depart'])){
	$wpdb->query("update wp_lws_departments set dept_name = '".$_POST['name']."' where  id = '".$_POST['id']."'");
}
if(isset($_GET['abc']) && !empty($_GET['abc'])){
	$curpage = $_GET['abc'];
}else{
	$curpage = 1;
}
$start = ( $curpage * $perpage ) - $perpage;
$wpdb->get_results("SELECT * FROM wp_lws_departments");
$totalres = $wpdb->num_rows;
$endpage = ceil($totalres/$perpage);
$startpage = 1;
$nextpage = $curpage + 1;
$previouspage = $curpage - 1;

$sql_get_title = $wpdb->get_results("SELECT * FROM wp_lws_departments limit $start , $perpage");

if(isset($_POST['post_title'])){
	global $wpdb;
	$sql_get_title = $wpdb->get_results("SELECT * FROM wp_lws_departments where dept_name like '%".$_POST['post_title']."%'");
}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<div class="row">
	<div class="col-lg-6">
		<div class="card">
			<div class="card-header">Add Department</div>
			<div class="card-body">
				<div class="card-title">
					<h3 class="text-center title-2">Department</h3>
				</div>
				<hr>
				<form action="" method="post" novalidate="novalidate">
					<div class="form-group">
						<label for="cc-payment" class="control-label mb-1">Department Name</label>
						<input id="cc-pament" name="dept_name" type="text" class="form-control" aria-required="true" aria-invalid="false" value="">
					</div>
					<div>
						<button id="payment-button" type="submit" name="submit_trainer" class="btn btn-lg btn-info btn-block">
							<i class="fa fa-lock fa-lg"></i>&nbsp;
							<span id="payment-button-amount">Submit</span>
							<span id="payment-button-sending" style="display:none;">Submit…</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row" style="padding-left: inherit;padding: 16px;">
		<form action="" method="POST">
		<input type="text" autocomplete="off" placeholder="Department" name="post_title" required>
		<input type="submit">
		</form>
	</div>
	
	<?php if($sql_get_title){ ?>
	<table id="data_table"  class="table table-striped table-bordered" style="width:100%">
		<thead>
			<tr>
			<th>Id</th>
			<th>Name</th>
			<th>Status</th>
			<th>Edit</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$id = 1;
			foreach($sql_get_title as $val){
			?>
			<tr>
			<td><?php echo $id; ?></td>
			<td><?php echo $val->dept_name; ?></td>
			<td><?php if($val->status == 0){ echo '<a href="?page=lws_department&status_id='.$val->id.'&status='.$val->status.'">Active</a>'; }else{ echo '<a href="?page=lws_department&status_id='.$val->id.'&status='.$val->status.'">Inactive</a>'; } ?></td>
			<td><input type="button" class="pop_up_info" data-toggle="modal" data-target="#myModal" value="Edit" data-id="<?php echo $val->id; ?>"></td>
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
	<div class="modal fade" id="myModal" role="dialog" tabindex=-1>
		<div class="modal-dialog popup-center">
		
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Update</h4>
			</div>
			<div class="modal-body title_info_data">
			  
			</div>
		  </div>
		  
		</div>
	</div>
</div>
<script>
jQuery('.pop_up_info').click(function(){
	var ids = jQuery(this).attr('data-id');
	var data_time = {
	"action": "departments_FP",
	"id" : ids
	},
	ajaxurl = "<?php echo admin_url("admin-ajax.php") ?>";
		jQuery.post(ajaxurl, data_time, function(response) {
			response = JSON.parse(response);
			jQuery('.title_info_data').html('<form action="" method="POST" class="myform"><div class="form-group"><label>Trainer Name</label><input type="text" value="'+response[0].dept_name+'" name="name" class="form-control"></div><div class="form-group"><input type="hidden" value="'+response[0].id+'" name="id"><input type="submit" class="update-btn-title" value="Submit" name="FP_update_depart"></form>');
	});
});



</script>