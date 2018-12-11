<?php 
require_once ABSPATH .'wp-content/plugins/PortfolioFeedback/common.php';
$perpage = 10;
if(isset($_GET['abc']) && !empty($_GET['abc'])){
	$curpage = $_GET['abc'];
}else{
	$curpage = 1;
}
$start = ( $curpage * $perpage ) - $perpage;
$wpdb->get_results("SELECT * FROM wp_lws_recordfeedbacks");
$totalres = $wpdb->num_rows;
$endpage = ceil($totalres/$perpage);
$startpage = 1;
$nextpage = $curpage + 1;
$previouspage = $curpage - 1;

$sql_get_title = $wpdb->get_results("SELECT * FROM wp_lws_recordfeedbacks limit $start , $perpage");

if(isset($_POST['post_title'])){
	global $wpdb;
	$sql_get_title = $wpdb->get_results("SELECT * FROM wp_lws_recordfeedbacks where dept_name like '%".$_POST['post_title']."%'");
}
function getUserRatingLws($row_id,$db){
	$row_avg = $db->get_results("SELECT rfb.record_date, ROUND(AVG(ans.answr),2) as totl from wp_lws_recordfeedbacks rfb inner join wp_lws_answrs ans on rfb.id = ans.record_id where rfb.id = $row_id");
	if(!empty($row_avg[0]->totl)){
		return $row_avg[0]->totl;
	}else{
		return 0;
	}
}
//Individual Training
$row_training = $wpdb->get_results("SELECT  trns.name, ROUND(AVG(ans.answr),2) as ratng,rfb.trainer as totl from wp_lws_answrs ans  right join wp_lws_recordfeedbacks rfb on rfb.id = ans.record_id inner join wp_lws_trainers trns on rfb.trainer = trns.id  GROUP BY rfb.trainer");

foreach($row_training as $val){
	$trainr_name[]  = $val->name;
	if($val->ratng == NULL){
		$trainr_rating[] = "0";
	}else{
		$trainr_rating[] = $val->ratng;
	}
}

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php if(!empty($statusMsg)){
        echo '<div class="alert '.$statusMsgClass.'">'.$statusMsg.'</div>';
}?>
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
			<th>User Name</th>
			<th>Training Topic</th>
			<th>Trainer Name</th>
			<th>Date/Time</th>
			<th>Rating</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$id = 1;
			foreach($sql_get_title as $val){
			?>
			<tr>
			<td><?php echo $id; ?></td>
			<td><?php echo lwsUserName($val->user_id); ?></td>
			<td><?php echo $val->traing_topic; ?></td>
			<td><?php $trn_name = lws_getTrainerName($val->trainer,$wpdb); echo $trn_name[0]->name; ?></td>
			<td><?php echo date('d-M-y',strtotime($val->record_date)); ?></td>
			<td><?php echo getUserRatingLws($val->id,$wpdb); ?></td>
			</tr>
			<?php  $id ++; } ?>
		</tbody>
	</table>
	<nav aria-label="Page navigation">
		<ul class="pagination">
	  <?php if($curpage != $startpage){ ?>
		<li class="page-item">
		  <a class="page-link" href="<?php echo site_url();?>/wp-admin/admin.php?page=lws-dashboard_func&abc=<?php echo $startpage ?>" tabindex="-1" aria-label="Previous">
			<span aria-hidden="true">&laquo;</span>
			<span class="sr-only">First</span>
		  </a>
		</li>
		<?php } ?>
		<?php if($curpage >= 2){ ?>
		<li class="page-item"><a class="page-link" href="<?php echo site_url();?>/wp-admin/admin.php?page=lws-dashboard_func&abc=<?php echo $previouspage ?>"><?php echo $previouspage ?></a></li>
		<?php } ?>
		<li class="page-item active"><a class="page-link" href="<?php echo site_url();?>/wp-admin/admin.php?page=lws-dashboard_func&abc=<?php echo $curpage ?>"><?php echo $curpage ?></a></li>
		<?php if($curpage != $endpage){ ?>
		<li class="page-item"><a class="page-link" href="<?php echo site_url();?>/wp-admin/admin.php?page=lws-dashboard_func&abc=<?php echo $nextpage ?>"><?php echo $nextpage ?></a></li>
		<li class="page-item">
		  <a class="page-link" href="<?php echo site_url();?>/wp-admin/admin.php?page=lws-dashboard_func&abc=<?php echo $endpage ?>" aria-label="Next">
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
	
<div class="col-xl-6">
	<div class="percent-chart">
		<canvas id="feedbkpercent-chart"></canvas>
	</div>
</div>

</div>
<script src="http://localhost/HrFeedBackPortal/wp-content/themes/twentyseventeen/custom-admin-assets/vendor/chartjs/Chart.bundle.min.js"></script>
<script>
try {
var ctx = document.getElementById("feedbkpercent-chart");
    if (ctx) {
      ctx.height = 280;
      var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          datasets: [
            {
              label: "My First dataset",
              data: <?php echo json_encode($trainr_rating); ?>,
              backgroundColor: [
                '#2ea08d',
                '#b4d857',
				'#a950a8',
				'#00b5e9'
              ],
              hoverBackgroundColor: [
               '#2ea08d',
                '#b4d857',
				'#a950a8',
				'#00b5e9'
              ],
              borderWidth: [
                0, 0
              ],
              hoverBorderColor: [
                'transparent',
                'transparent'
              ]
            }
          ],
          labels: <?php echo json_encode($trainr_name); ?>
		  },
        options: {
          maintainAspectRatio: false,
          responsive: true,
          cutoutPercentage: 55,
          animation: {
            animateScale: true,
            animateRotate: true
          },
          legend: {
            display: false
          },
          tooltips: {
            titleFontFamily: "Poppins",
            xPadding: 0,
            yPadding: 8,
            caretPadding: 0,
            bodyFontSize: 13
          }
        }
      });
    }

  } catch (error) {
    console.log(error);
}
</script>