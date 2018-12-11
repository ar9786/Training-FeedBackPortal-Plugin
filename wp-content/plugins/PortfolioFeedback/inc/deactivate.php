<?php

/**
* @package AtiBlogTest
* Trigger this file on plugin deactivation
**/
class PortfolioFeedbackDeactivate {

	static function deactivate(){
		flush_rewrite_rules();
	}
}