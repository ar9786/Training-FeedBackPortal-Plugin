<?php
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
if(empty($user_id)){
	echo "<strong>Denied</strong>";
	die;
}
/*
if($user_id == 1){
	echo "<strong>Not valid user</strong>";
	die;
}*/
global $wpdb;
// Fetch Department
deptFetch($wpdb);
function deptFetch(	$wpdb){
$dept_fetch = $wpdb->get_results("select * from wp_lws_departments where status=0");
return $dept_fetch;
}
//Fetch Trainer's
//trainerFetch($wpdb);
function trainerFetch(	$wpdb){
	$dept_fetch = $wpdb->get_results("select * from wp_lws_trainers where status=0");
	return $dept_fetch;
}

//Fetch User Name By id
function lwsUserName($id){
	$user_detail = get_user_by('id',$id);
	return $user_detail->user_login;
}

//Fetch Trainer Name By id
function lws_getTrainerName($id,$wpdb){
	$dept_fetch = $wpdb->get_results("select * from wp_lws_trainers where status=0 and id = $id");
	return $dept_fetch;
}
// Time Slot 
$array_time = array("11:00:00"=>"11:00 am","11:30:00"=>"11:30 am","12:00:00"=>"12:00 pm","12:30:00"=>"12:30 pm","1:00:00"=>"1:00 pm","1:30:00"=>"1:30 pm","2:00:00"=>"2:00 pm","2:30:00"=>"2:30 pm","3:00:00"=>"3:00 pm","3:30:00"=>"3:30 pm","4:00:00"=>"4:00 pm","4:30 :00"=>"4:30 pm","5:00:00"=>"5:00 pm","5:30:00"=>"5:30 pm","6:00:00"=>"6:00 pm","6:30:00"=>"6:30 pm");

$ques_bank = $wpdb->get_results("select * from wp_lws_questions where status=0");
?>
<style>
.update-nag{
	display:none;
}
</style>
