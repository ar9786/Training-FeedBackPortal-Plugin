<?php
/**
* @package PortfolioFeedback
* Trigger this file on plugin activation
**/
class PortfolioFeedbackActivate {
	static function activate(){
		global $wpdb;
		//global $jal_db_version;
		//$jal_db_version = '1.0';
		$table_name_trainers = $wpdb->prefix . 'wp_lws_trainers';
		if($wpdb->get_var( "show tables like '$table_name_trainers'" ) != $table_name_trainers){
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE $table_name_trainers (id int(9) NOT NULL AUTO_INCREMENT,name tinytext NOT NULL,cur_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,status int(9) NOT NULL,PRIMARY KEY(id))$charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	//	add_option( 'jal_db_version', $jal_db_version );
		}
		
		$table_name_questions = $wpdb->prefix . 'wp_lws_questions';
		if($wpdb->get_var( "show tables like '$table_name_questions'" ) != $table_name_questions){
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE $table_name_questions (id int(9) NOT NULL AUTO_INCREMENT,ques_name VARCHAR(500) NOT NULL,status int(9) NOT NULL,PRIMARY KEY(id))$charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		}
		
		$table_name_questions = $wpdb->prefix . 'wp_lws_departments';
		if($wpdb->get_var( "show tables like '$table_name_questions'" ) != $table_name_questions){
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE $table_name_questions (id int(9) NOT NULL AUTO_INCREMENT,dept_name VARCHAR(200) NOT NULL,status int(9) NOT NULL,PRIMARY KEY(id))$charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		}
		
		$table_name_questions = $wpdb->prefix . 'wp_lws_recordfeedbacks';
		if($wpdb->get_var( "show tables like '$table_name_questions'" ) != $table_name_questions){
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE $table_name_questions (id int(9) NOT NULL AUTO_INCREMENT,trainer VARCHAR(250) NOT NULL,record_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,traing_topic VARCHAR(250) NOT NULL,user_id int(9) NOT NULL,curnt_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,status int(9) NOT NULL,PRIMARY KEY(id))$charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		}
		
		$table_name_questions = $wpdb->prefix . 'wp_lws_answrs';
		if($wpdb->get_var( "show tables like '$table_name_questions'" ) != $table_name_questions){
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE $table_name_questions (id int(9) NOT NULL AUTO_INCREMENT,ques_id int(9) NOT NULL,answr int(9) NOT NULL,record_id int(9) NOT NULL,PRIMARY KEY(id))$charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		}
		flush_rewrite_rules();
	}
}
?>