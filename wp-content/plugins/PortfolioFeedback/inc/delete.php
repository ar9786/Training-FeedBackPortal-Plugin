<?php
class PortfolioFeedbackActivate {
	static function delete(){
	$table_name = $wpdb->prefix . 'trainers';
	$sql = "Drop TABLE $table_name";
	flush_rewrite_rules();
}