<?php
global $wpdb;
if(isset($_POST['submit_trainer'])){
	$trainer = trim($_POST['trainer']);
	$wpdb->query("insert into wp_lws_trainers set name = '$trainer',cur_time = NOW()");
	$statusMsgClass = 'alert-success';
    $statusMsg = 'Data inserted successfully';
}
if(isset($_POST['submit_ques_file'])){
	    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    if(!empty($_FILES['ques_name']['name']) && in_array($_FILES['ques_name']['type'],$csvMimes)){
        if(is_uploaded_file($_FILES['ques_name']['tmp_name'])){
            
            //open uploaded csv file with read only mode
            $csvFile = fopen($_FILES['ques_name']['tmp_name'], 'r');
          
            //skip first line
            fgetcsv($csvFile);
            
            //parse data from csv file line by line
            while(($line = fgetcsv($csvFile)) !== FALSE){
                //check whether member already exists in database with same email
                $prevQuery = "SELECT ques_name FROM wp_lws_questions WHERE ques_name = '".$line[1]."'";
                $wpdb->query($prevQuery);
                if($wpdb->num_rows > 0){					
                    //update member data
                  //  $wpdb->query("UPDATE wp_custom_post_title SET name = '".$line[0]."', phone = '".$line[2]."', created = '".$line[3]."', modified = '".$line[3]."', status = '".$line[4]."' WHERE email = '".$line[1]."'");
                }else{
                    //insert member data into database
                    $wpdb->query("INSERT INTO wp_lws_questions (ques_name) VALUES ('".$line[1]."')");
                }
            }
            //close opened csv file
            fclose($csvFile);

            $qstring = 'succ';
        }else{
            $qstring = 'err';
        }
    }else{
     $qstring = 'invalid_file';
    }
}
if(isset($qstring)){
    switch($qstring){
        case 'succ':
            $statusMsgClass = 'alert-success';
            $statusMsg = 'Members data has been inserted successfully.';
            break;
        case 'err':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Some problem occurred, please try again.';
            break;
        case 'invalid_file':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Please upload a valid CSV file.';
            break;
        default:
            $statusMsgClass = '';
            $statusMsg = '';
    }
}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
 <?php if(!empty($statusMsg)){
        echo '<div class="alert '.$statusMsgClass.'">'.$statusMsg.'</div>';
} ?>  
  
<div class="row">
	<div class="col-lg-6">
		<div class="card">
			<div class="card-header">Add Trainer</div>
			<div class="card-body">
				<div class="card-title">
					<h3 class="text-center title-2">Trainer Details</h3>
				</div>
				<hr>
				<form action="" method="post" >
					<div class="form-group">
						<label  class="control-label mb-1">Trainer Name</label>
						<input  name="trainer" type="text" class="form-control" >
					</div>
					<div>
						<button  type="submit" name="submit_trainer" class="btn btn-lg btn-info btn-block">
							<i class="fa fa-lock fa-lg"></i>&nbsp;
							<span id="payment-button-amount">Submit</span>
							<span id="payment-button-sending" style="display:none;">Submit…</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
			<div class="card">
		<div class="card-header">Add Trainer By uploading file</div>
		<div class="card-body">
			<div class="card-title">
				<h3 class="text-center title-2">Trainer Details</h3>
			</div>
			<hr>
			<form action="" method="post" >
				<div class="form-group">
					<label  class="control-label mb-1">Trainer Name</label>
					<input  name="trainer" type="text" class="form-control" >
				</div>
				<div>
					<button  type="submit" name="submit_trainer" class="btn btn-lg btn-info btn-block">
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

<div class="row">
	<div class="col-lg-6">
		<div class="card">
			<div class="card-header">Add Question's</div>
			<div class="card-body">
				<div class="card-title">
					<h3 class="text-center title-2">Question</h3>
				</div>
				<hr>
				<form action="" method="post" >
					<div class="form-group">
						<label  class="control-label mb-1">Question</label>
						<input  name="depart_name" type="text" class="form-control" >
					</div>
					<div>
						<button  type="submit" name="submit_trainer" class="btn btn-lg btn-info btn-block">
							<i class="fa fa-lock fa-lg"></i>&nbsp;
							<span id="payment-button-amount">Submit</span>
							<span id="payment-button-sending" style="display:none;">Submit…</span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="card">
			<div class="card-header">Add Question's By Uploading File
			<div class="download-sample" ><a href="<?php echo site_url(); ?>/wp-content/plugins/PortfolioFeedback/assets/files/SampleCSVFile.csv" download="SampleCSVFile.csv"/>Click here to download sample</div>
			</a></div>
			<div class="card-body">
				<div class="card-title">
					<h3 class="text-center title-2">Question</h3>
				</div>
				<hr>
				<form action="" method="post"  enctype="multipart/form-data">
					<div class="form-group">
						<label  class="control-label mb-1">Question</label>
						<input  type="file" name="ques_name"  class="form-control" >
					</div>
					<div>
						<button  type="submit" name="submit_ques_file" class="btn btn-lg btn-info btn-block">
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