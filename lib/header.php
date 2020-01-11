<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<title>ADMINISTRATOR CONTROL</title>
		<link rel="shortcut icon" href="assets1/images/favicon3.ico">
		<link href="http://localhost/tokol/assets1/plugins/morris/morris.css" rel="stylesheet" />
		<link href="http://localhost/tokol/assets1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="http://localhost/tokol/assets1/css/icons.css" rel="stylesheet" type="text/css" />
		<link href="http://localhost/tokol/assets1/css/style.css" rel="stylesheet" type="text/css" />
		<script src="http://localhost/tokol/assets1/js/modernizr.min.js"></script>
		<script src="http://localhost/tokol/assets1/js/jquery.min.js"></script>
		<script src="<?php echo $cfg_baseurl; ?>assets1/js/popper.min.js"></script>
		<script src="<?php echo $cfg_baseurl; ?>assets1/js/bootstrap.min.js"></script>
		<script src="<?php echo $cfg_baseurl; ?>assets1/js/waves.js"></script>
		<script src="<?php echo $cfg_baseurl; ?>assets1/js/jquery.slimscroll.js"></script>
		<script src="<?php echo $cfg_baseurl; ?>assets1/plugins/morris/morris.min.js"></script>
		<script src="<?php echo $cfg_baseurl; ?>assets1/plugins/raphael/raphael-min.js"></script>
        <link href="<?php echo $cfg_baseurl; ?>assets1/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $cfg_baseurl; ?>assets1/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo $cfg_baseurl; ?>assets1/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
		<style type="text/css">.hide{display:none!important}.show{display:block!important}</style>
		<style>
      #map {
        height: 1px;
        width: 1px;
      }
    </style>
	</head>
    <body>
        <header id="topnav">
			<div class="topbar-main">
				<div class="container-fluid">
					<div class="logo">
						<a href="/admin" class="logo">
							<span class="logo-small"><i class="fa fa-globe"></i></span>
							<span class="logo-large"><i class="fa fa-globe"></i> ADMIN</span>
						</a>
					</div>
					<div class="menu-extras topbar-custom">
						<ul class="list-unstyled topbar-right-menu float-right mb-0">
							<li class="menu-item">
								<a class="navbar-toggle nav-link">
									<div class="lines">
										<span></span>
										<span></span>
										<span></span>
									</div>
								</a>
							</li>
							<?php
					        if (isset($_SESSION['user'])) { ?>
							<li class="dropdown notification-list">
								<a class="nav-link dropdown-toggle waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
									aria-haspopup="false" aria-expanded="false">
								<i class="fa fa-user"></i> <span class="ml-1 pro-user-name"><?php echo $data_user['username']; ?> <i class="mdi mdi-chevron-down"></i> </span>
								</a>
								<div class="dropdown-menu dropdown-menu-right profile-dropdown">
									<a href="<?php echo $cfg_baseurl; ?>logout" class="dropdown-item notify-item"><i class="fa fa-sign-out fa-fw"></i> <span>Keluar</span></a>
								</div>
							</li>
							<?php 
        					}
        					?>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="navbar-custom">
				<div class="container-fluid">
					<div id="navigation">
						<ul class="navigation-menu">
                            <?php
			                if (isset($_SESSION[ 'user'])) {
			                ?>
			                <?php if ($page_type == "admin") { ?>
			                    <li>
                                    <a href="<?php echo $cfg_baseurl; ?>admin/index"><i class="fa fa-home"></i> Ringkasan</a>
                                </li>
                                <li>
                                    <a href="<?php echo $cfg_baseurl; ?>admin/usersss/data.php"><i class="fa fa-users"></i>Manajemen Pengguna</a>
                                </li>
								<li>
                                    <a href="<?php echo $cfg_baseurl; ?>admin/users/data.php"><i class="fa fa-list"></i>Manajemen Produk</a>
                                </li>
								<li>
                                    <a href="<?php echo $cfg_baseurl; ?>admin/userss/data.php"><i class="fa fa-shopping-cart"></i>Manajemen Transaksi</a>
                                </li>
                                
                            <?php } else { ?>
    
							
							<?php if ($page_type == "homepage") { ?>
			                <li class="has-submenu active">
			                <?php } else { ?>
                            <li class="has-submenu">
                            <?php } ?>
                                <a href="<?php echo $cfg_baseurl; ?>admin"><i class="fa fa-home"></i> <span> Halaman Utama </span> </a>
                            </li>
                            
                            <?php
                            }
							} else {
							?>
							
							<?php if ($page_type == "homepage") { ?>
			                <li class="has-submenu active">
			                <?php } else { ?>
                            <li class="has-submenu">
                            <?php } ?>
                                <a href="<?php echo $cfg_baseurl; ?>admin"><i class="fa fa-home"></i> <span> Halaman Utama </span> </a>
                            </li>
                            
							<?php if ($page_type == "user_login") { ?>
			                <li class="has-submenu active">
			                <?php } else { ?>
                            <li class="has-submenu">
                            <?php } ?>
                                <a href="<?php echo $cfg_baseurl; ?>login"><i class="fa fa-sign-in"></i> <span> Masuk </span> </a>
                            </li>
                            <?php
							}
							?>
							
							<?php
			                if (isset($_SESSION[ 'user'])) {
			                ?>
			               
                            <?php
			                }
			                ?>
                            
                            </ul>
					</div>
				</div>
			</div>
		</header>

        <div class="wrapper">
            <div class="container-fluid" style="padding-top: 30px;">