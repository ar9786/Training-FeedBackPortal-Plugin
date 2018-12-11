<?php
/**
 * @package PortfolioFeedback
 * @version 1.0
*/
/*
Plugin Name: PortfolioFeedback
Plugin URI: 
Description: For sending feedback to users
Author: Arvind Rawat
Version: 1.0
Author URI: 
Licence: GPLv2 or later
Text-domain:PortfolioFeedback
*/

if( !defined( 'ABSPATH' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'inc/activate.php';
register_activation_hook( __FILE__, array('PortfolioFeedbackActivate','activate') );
require_once plugin_dir_path( __FILE__ ) . 'inc/deactivate.php';
register_deactivation_hook( __FILE__, array('PortfolioFeedbackDeactivate','deactivate') );

class PortfolioFeedback {
	function register(){
		//for backend
		add_action( 'admin_enqueue_scripts', array($this,'backendEnqueue'));
		//for frontend
		add_action( 'wp_enqueue_scripts', array($this,'frontendEnqueue'));
		add_action('admin_menu',array($this,'add_admin_pages')); 
	}
	function add_admin_pages(){
		add_menu_page( 'Feedback Portfolio', 'Feedback Portfolio', 'manage_options', 'lws_feedbackportfolio', 'feedBackPortfolio', '');
		function feedBackPortfolio() {
			require_once('templates/feedBackPortfolio.php');
		}
		add_submenu_page( 'lws_feedbackportfolio', 'Edit Trainer Details', 'Edit Trainer details', 'manage_options', 'lws_edit-trainer-details', 'edittrainr_func' );
		
		add_submenu_page( 'lws_feedbackportfolio', 'Edit Questions Details', 'Edit Questions Details', 'manage_options', 'lws_edit-question-details', 'editQuestion_func' );
		
		add_submenu_page( 'lws_feedbackportfolio', 'Department', 'Department', 'manage_options', 'lws_department', 'department' );
		
		add_submenu_page( 'lws_feedbackportfolio', 'Dashboard', 'Dashboard', 'manage_options', 'lws-dashboard_func', 'dashboard_func','dashicons-dashboard' );
		
		function dashboard_func(){
			require_once('templates/lws_dashboard.php');
		}
		
		function edittrainr_func(){
			require_once('templates/editTrainer.php');
		}
		
		function editQuestion_func(){
			require_once('templates/editQuestions.php');
		}
		
		function department(){
			require_once('templates/department.php');
		}
	}
	
	function backendEnqueue(){
		wp_enqueue_style( 'PortfolioFeedbackStyle', plugins_url( '/assets/css/admin_mystyle.css', __FILE__ ));
		wp_enqueue_script( 'PortfolioFeedbackScript', plugins_url( '/assets/js/admin_myscript.js', __FILE__ ));
	}
	function frontendEnqueue(){
		wp_enqueue_style( 'PortfolioFeedbackStyle', plugins_url( '/assets/css/front_mystyle.css', __FILE__ ));
		wp_enqueue_script( 'PortfolioFeedbackScript', plugins_url( '/assets/js/front_myscript.js', __FILE__ ));
	}
}
if(class_exists('PortfolioFeedback')){
	$portfoliofeedback=new PortfolioFeedback();
	$portfoliofeedback->register();
}

add_action( 'wp_ajax_updateTrainer', 'updateTrainer' );
add_action( 'wp_ajax_nopriv_updateTrainer', 'updateTrainer' );
function updateTrainer() {
 global  $wpdb;
 $result = $wpdb->get_results("SELECT * FROM `wp_lws_trainers` where id = '".$_POST['id']."'");
 echo json_encode($result);
 die;
}

add_action( 'wp_ajax_updateQuestion', 'updateQuestion' );
add_action( 'wp_ajax_nopriv_updateQuestion', 'updateQuestion' );
function updateQuestion() {
 global  $wpdb;
 $result = $wpdb->get_results("SELECT * FROM `wp_lws_questions` where id = '".$_POST['id']."'");
 echo json_encode($result);
 die;
}

add_action( 'wp_ajax_departments_FP', 'departments_FP' );
add_action( 'wp_ajax_nopriv_departments_FP', 'departments_FP' );
function departments_FP() {
 global  $wpdb;
 $result = $wpdb->get_results("SELECT * FROM `wp_lws_departments` where id = '".$_POST['id']."'");
 echo json_encode($result);
 die;
}


add_action( 'wp_ajax_lws_viewUserRating', 'lws_viewUserRating' );
add_action( 'wp_ajax_nopriv_lws_viewUserRating', 'lws_viewUserRating' );
function lws_viewUserRating() {
 global  $wpdb;
// $sql_lws = "SELECT wp_lws_answrs.*,wp_lws_recordfeedbacks.id,wp_lws_questions.* from wp_lws_answrs inner join wp_lws_recordfeedbacks  on wp_lws_answrs.record_id = wp_lws_recordfeedbacks.id inner join wp_lws_questions on wp_lws_questions.id = wp_lws_answrs.ques_id where wp_lws_recordfeedbacks.user_id = 2 and wp_lws_recordfeedbacks.record_date = '".$_POST['date']."'";
	$sql_lws = "SELECT wp_lws_answrs.*,wp_lws_questions.* from wp_lws_answrs inner join wp_lws_questions on wp_lws_questions.id = wp_lws_answrs.ques_id where wp_lws_answrs.record_id = '".$_POST['ids']."'";
	$result = $wpdb->get_results($sql_lws);
	echo json_encode($result);
	die;
}