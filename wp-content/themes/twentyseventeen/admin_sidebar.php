<?php 
// Update Profile
if(isset($_POST['user_profile'])){
update_user_meta( $user_id, 'first_name',$_REQUEST['first_name'] );
update_user_meta( $user_id, 'last_name',$_REQUEST['last_name'] );
update_user_meta( $user_id, 'user_department',$_REQUEST['user_department'] );
}
// Profile Pic
if(isset($_POST['user_pic'])){
	$path_parts = pathinfo($_FILES["user_image"]["name"]);
	$allowedExts = array("jpeg", "jpg", "png");
	if($_FILES['user_image']['size'] > (1024000)){
		$message = 'Oops! Your file\'s size is to large.';
	}else if(!$_FILES['user_image']['error'] && in_array($path_parts['extension'], $allowedExts)){
		$image_path = $path_parts['filename'].'_'.time().'.'.$path_parts['extension'];
		$target_path = WP_CONTENT_DIR .'/userPics/' . $image_path;
		move_uploaded_file($_FILES['user_image']['tmp_name'], $target_path);
		if(!empty($current_user->user_meta_image)){
		unlink(WP_CONTENT_DIR .'/userPics/'.$current_user->user_meta_image);
		}
		update_user_meta( $user_id, 'user_meta_image', $image_path );
		$message = 'Congratulations! Your file was accepted.';
	}else{
		$message = 'Only jpeg,jpg,png supported';
	}
}
?>

<link href="<?php echo get_template_directory_uri(); ?>/custom-admin-assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
<link href="<?php echo get_template_directory_uri(); ?>/custom-admin-assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
<link href="<?php echo get_template_directory_uri(); ?>/custom-admin-assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

<!-- Bootstrap CSS-->
<link href="<?php echo get_template_directory_uri(); ?>/custom-admin-assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

<!-- Vendor CSS-->
<link href="<?php echo get_template_directory_uri(); ?>/custom-admin-assets/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
<link href="<?php echo get_template_directory_uri(); ?>/custom-admin-assets/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
<link href="<?php echo get_template_directory_uri(); ?>/custom-admin-assets/vendor/wow/animate.css" rel="stylesheet" media="all">
<link href="<?php echo get_template_directory_uri(); ?>/custom-admin-assets/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
<link href="<?php echo get_template_directory_uri(); ?>/custom-admin-assets/vendor/slick/slick.css" rel="stylesheet" media="all">
<link href="<?php echo get_template_directory_uri(); ?>/custom-admin-assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
<link href="<?php echo get_template_directory_uri(); ?>/custom-admin-assets/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

<!-- Main CSS-->
<link href="<?php echo get_template_directory_uri(); ?>/custom-admin-assets/css/theme.css" rel="stylesheet" media="all">
	
	<div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="">
                            <img src="https://lws-abt5wcf.netdna-ssl.com/wp-content/uploads/2018/05/logo-1-1.png" height="100%" width="100%" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="has-sub">
                            <a class="js-arrow" href="<?php echo site_url(); ?>/record-feedback/">
                                <i class="fas fa-tachometer-alt"></i>Record FeedBack</a>
                        </li>
                        <li>
							<a href="">
                               <i class="fas fa-chart-bar"></i>Total FeedBack Recorded</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="<?php echo site_url();?>/wp-admin/admin.php?page=Dashboard">
                    <img src="https://lws-abt5wcf.netdna-ssl.com/wp-content/uploads/2018/05/logo-1-1.png" height="100%" width="100%"/>
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
						<li><a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=Dashboard"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
						</li>
                        <li><a href="<?php echo site_url(); ?>/record-feedback/"><i class="fas fa-tachometer-alt"></i>Record FeedBack</a>
                        </li>
						<li><a href="<?php echo site_url(); ?>/feedback-recorded/"><i class="fas fa-chart-bar"></i>Total FeedBack Recorded</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" method="POST">
                                <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas &amp; reports..." />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                            <div class="header-button">
                                <div class="noti-wrap">
                                <!-- <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-comment-more"></i>
                                        <span class="quantity">1</span>
                                        <div class="mess-dropdown js-dropdown">
                                            <div class="mess__title">
                                                <p>You have 2 news message</p>
                                            </div>
                                            <div class="mess__item">
                                                <div class="image img-cir img-40">
                                                    <img src="images/icon/avatar-06.jpg" alt="Michelle Moreno" />
                                                </div>
                                                <div class="content">
                                                    <h6>Michelle Moreno</h6>
                                                    <p>Have sent a photo</p>
                                                    <span class="time">3 min ago</span>
                                                </div>
                                            </div>
                                            <div class="mess__item">
                                                <div class="image img-cir img-40">
                                                    <img src="images/icon/avatar-04.jpg" alt="Diane Myers" />
                                                </div>
                                                <div class="content">
                                                    <h6>Diane Myers</h6>
                                                    <p>You are now connected on message</p>
                                                    <span class="time">Yesterday</span>
                                                </div>
                                            </div>
                                            <div class="mess__footer">
                                                <a href="#">View all messages</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-email"></i>
                                        <span class="quantity">1</span>
                                        <div class="email-dropdown js-dropdown">
                                            <div class="email__title">
                                                <p>You have 3 New Emails</p>
                                            </div>
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="images/icon/avatar-06.jpg" alt="Cynthia Harvey" />
                                                </div>
                                                <div class="content">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, 3 min ago</span>
                                                </div>
                                            </div>
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="images/icon/avatar-05.jpg" alt="Cynthia Harvey" />
                                                </div>
                                                <div class="content">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, Yesterday</span>
                                                </div>
                                            </div>
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="images/icon/avatar-04.jpg" alt="Cynthia Harvey" />
                                                </div>
                                                <div class="content">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, April 12,,2018</span>
                                                </div>
                                            </div>
                                            <div class="email__footer">
                                                <a href="#">See all emails</a>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-notifications"></i>
                                        <span class="quantity">3</span>
                                        <div class="notifi-dropdown js-dropdown">
                                            <div class="notifi__title">
                                                <p>You have 3 Notifications</p>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c1 img-cir img-40">
                                                    <i class="zmdi zmdi-email-open"></i>
                                                </div>
                                                <div class="content">
                                                    <p>You got a email notification</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c2 img-cir img-40">
                                                    <i class="zmdi zmdi-account-box"></i>
                                                </div>
                                                <div class="content">
                                                    <p>Your account has been blocked</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c3 img-cir img-40">
                                                    <i class="zmdi zmdi-file-text"></i>
                                                </div>
                                                <div class="content">
                                                    <p>You got a new file</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__footer">
                                                <a href="#">All notifications</a>
                                            </div>
                                        </div>
                                    </div>-->
                                </div>
								
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
										<?php if(!empty($current_user->user_meta_image)){?>
                                            <img src="<?php echo site_url() .'/wp-content/userPics/'.$current_user->user_meta_image; ?>" alt="<?php echo $current_user->display_name; ?>" />
										<?php }else {?>
											<img src="<?php echo site_url() .'/wp-content/userPics/user.png' ?>" alt="<?php echo $current_user->display_name; ?>" />
										<?php } ?>
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="#"><?php echo $current_user->display_name; ?></a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#" id="myModalPic">
                                                        <?php if(!empty($current_user->user_meta_image)){?>
                                            <img src="<?php echo site_url() .'/wp-content/userPics/'.$current_user->user_meta_image; ?>" alt="<?php echo $current_user->display_name; ?>" />
										<?php }else {?>
											<img src="<?php echo site_url() .'/wp-content/userPics/user.png' ?>" alt="<?php echo $current_user->display_name; ?>" />
										<?php } ?>
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#"><?php echo $current_user->display_name; ?></a>
                                                    </h5>
                                                    <span class="email"><?php echo $current_user->user_email; ?></span>
                                                </div>
                                            </div>
											
                                            <div class="account-dropdown__body">
                                                
                                                <div class="account-dropdown__item">
												
                                                   <a href="#" id="pop_setting" >
                                                        <i class="zmdi zmdi-settings"></i>Setting</a>
                                                </div>
                                                
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="#">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
<div class="modal fade" id="myModal" role="dialog" tabindex=-1>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <div class="col-lg-12">
			<div class="card">
				<div class="card-header">Your Profile</div>
				<div class="card-body card-block">
						<form action="" method="post" class="">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-user"></i>
									</div>
									<input type="text" id="username" name="first_name" placeholder="First Name" class="form-control" value="<?php echo $current_user->first_name; ?>"autocomplete="off">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-user"></i>
									</div>
									<input type="text" id="username" name="last_name" placeholder="Last Name" class="form-control" value="<?php echo $current_user->last_name; ?>" autocomplete="off">
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-envelope"></i>
									</div>
									<input type="email" id="email" name="email" placeholder="Email" class="form-control" value="<?php echo $current_user->user_email; ?>" disabled>
								</div>
							</div>
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-envelope"></i>
									</div>
									<select name="user_department" class="form-control">
									<?php $dept_fetch = deptFetch($wpdb);
									foreach($dept_fetch as $val){ ?>
									<option <?php if($current_user->user_department == $val->id){ echo "selected";}?> value="<?php echo $val->id; ?>"><?php echo $val->dept_name; ?></option>
									<?php }?>
									</select>
								</div>
							</div>
							<div class="form-actions form-group">
								<button type="submit" name="user_profile" class="btn btn-success btn-sm">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
        </div>
	<div class="modal-footer">
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
      </div>
  </div>
</div>
<div class="modal fade" id="myModalPics" role="dialog" tabindex=-1>
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <div class="col-lg-12">
			<div class="card">
				<div class="card-header">Your Profile Pic</div>
				<div class="card-body card-block">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-user"></i>
									</div>
									<input type="file" id="user_image" name="user_image"  class="form-control">
								</div>
							</div>
							<div class="form-actions form-group">
								<button type="submit" name="user_pic" class="btn btn-success btn-sm">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
        </div>
	<div class="modal-footer">
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
      </div>
  </div>
</div>