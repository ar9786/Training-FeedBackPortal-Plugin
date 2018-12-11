<style>
#adminmenumain,#wpadminbar,#wpfooter {
	display:none;
}
</style>
<?php
require_once ABSPATH .'wp-content/plugins/PortfolioFeedback/common.php';
require_once('admin_sidebar.php');
//First chart in user dashboard page
$str_candidate_ratigs = $wpdb->get_results("SELECT MONTHNAME(record_date) AS m, COUNT(id) 
AS cnt FROM wp_lws_recordfeedbacks where user_id = $user_id GROUP BY m desc");
$totl_attempts = $wpdb->get_results("select COUNT(id) as tolt_sm FROM wp_lws_recordfeedbacks");
foreach($str_candidate_ratigs as $val){
	$str_candidate_ratg[] = $val->m;
	$str_candidate_labels[] = $val->cnt;
}
//Second chart in user dashboard page
$dng_ratigs = $wpdb->get_results("SELECT rfb.record_date, ROUND(AVG(ans.answr),2) as totl from wp_lws_recordfeedbacks rfb inner join wp_lws_answrs ans on rfb.id = ans.record_id where rfb.user_id = $user_id GROUP BY rfb.record_date");
foreach($dng_ratigs as $val){
	$dng_ratigs_ratg[] = $val->totl;
	$dng_ratigs_labels[] = date('d-M',strtotime($val->record_date)).' Rating ';
}
?>
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                       
                        <div class="row">
						<div class="col-sm-6 col-lg-3">
                                <div class="overview-item overview-item--c2">
                                    <div class="overview__inner">
                                        <div class="overview-box clearfix">
                                            <div class="icon">
                                                <i class="zmdi zmdi-shopping-cart"></i>
                                            </div>
                                            <div class="text">
                                                <span><strong style="color:black"><?php echo $totl_attempts[0]->tolt_sm; ?> </strong>Feedback Recorded</span>
                                            </div>
                                        </div>
                                        <div class="overview-chart">
                                            <canvas id="lws_ratings"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="au-card chart-percent-card">
                                    <div class="au-card-inner">
                                        <h3 class="title-2 tm-b-5">char by %</h3>
                                        <div class="row no-gutters">
                                            <div class="col-xl-6">
                                                <div class="chart-note-wrap">
                                                    <div class="chart-note mr-0 d-block">
                                                        <span class="dot dot--blue"></span>
                                                        <span>products</span>
                                                    </div>
                                                    <div class="chart-note mr-0 d-block">
                                                        <span class="dot dot--red"></span>
                                                        <span>services</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="percent-chart">
                                                    <canvas id="feedbkpercent-chart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
<?php include('admin_footer.php'); ?>
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
              data: <?php echo json_encode($dng_ratigs_ratg); ?>,
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
          labels: <?php echo json_encode($dng_ratigs_labels); ?>
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
  
try {
var ctx = document.getElementById("lws_ratings");
    if (ctx) {
      ctx.height = 130;
      var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: <?php echo json_encode($str_candidate_ratg); ?>,
          type: 'line',
          datasets: [{
            data: <?php echo json_encode($str_candidate_labels); ?>,
            label: 'No of Feedbacks',
            backgroundColor: 'transparent',
            borderColor: 'rgba(255,255,255,.55)',
          },]
        },
        options: {

          maintainAspectRatio: false,
          legend: {
            display: false
          },
          responsive: true,
          tooltips: {
            mode: 'index',
            titleFontSize: 12,
            titleFontColor: '#000',
            bodyFontColor: '#000',
            backgroundColor: '#fff',
            titleFontFamily: 'Montserrat',
            bodyFontFamily: 'Montserrat',
            cornerRadius: 3,
            intersect: false,
          },
          scales: {
            xAxes: [{
              gridLines: {
                color: 'transparent',
                zeroLineColor: 'transparent'
              },
              ticks: {
                fontSize: 2,
                fontColor: 'transparent'
              }
            }],
            yAxes: [{
              display: false,
              ticks: {
                display: false,
              }
            }]
          },
          title: {
            display: false,
          },
          elements: {
            line: {
              tension: 0.00001,
              borderWidth: 1
            },
            point: {
              radius: 4,
              hitRadius: 10,
              hoverRadius: 4
            }
          }
        }
      });
    }} catch (error) {
    console.log(error);
  }
</script>