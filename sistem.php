<!DOCTYPE html>
<html lang="en">
<?php
	require_once('config/connection/connection.php');
	require_once('config/connection/security.php');
	require_once('config/function/data.php');
	require_once('config/function/date.php');
	$secu	= new Security;
	$base	= new DB;
	$data	= new Data;
	$date	= new Date;
	$menu	= $secu->injection(@$_GET['menu']);
	$sistem	= $data->sistem('url_sis');
	$admin	= $secu->injection(@$_COOKIE['adminkuy']);
	$kunci	= $secu->injection(@$_COOKIE['kuncikuy']);
	$level	= $secu->injection(@$_COOKIE['jeniskuy']);
    // add by suryo
    $self_apl    = $data->self_apl();
    // end
	$valid	= $secu->validadmin($admin, $kunci);
	if($valid==false){ header("location:$sistem/signout"); } else {
	$conn	= $base->open();
?>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Meta -->
        <meta name="description" content="Inventory System">
        <meta name="author" content="Fazlurr">
        <!-- Favicon -->
        <!-- <link rel="shortcut icon" type="image/x-icon" href="<?php echo("$sistem/berkas/sistem/".$data->sistem('favicon_sis')); ?>"> -->
        <title><?php echo($data->sistem('app_sis')); ?></title>
        <!-- vendor css -->
        <link href="<?php echo("$sistem/lib/@fortawesome/fontawesome-free/css/all.min.css"); ?>" rel="stylesheet">
        <link href="<?php echo("$sistem/lib/ionicons/css/ionicons.min.css"); ?>" rel="stylesheet">
        <link href="<?php echo("$sistem/lib/prismjs/themes/prism-tomorrow.css"); ?>" rel="stylesheet">
        <link href="<?php echo("$sistem/sweetalert/css/sweetalert.css"); ?>" rel="stylesheet">
        <link href="<?php echo("$sistem/lib/select2/css/select2.min.css"); ?>" rel="stylesheet">
        <link href="<?php echo("$sistem/config/css/fazlurr.css"); ?>" rel="stylesheet">
        <!-- template css -->
        <link rel="stylesheet" href="<?php echo("$sistem/assets/css/cassie.css"); ?>">
    </head>
	<body data-spy="scroll" data-target="#navSection" data-offset="100">
        <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-content-lg">
                </div>
            </div>
        </div>
        <div class="sidebar">
            <div class="sidebar-header">
                <div>
                    <a href="<?php echo("$sistem/home"); ?>" class="sidebar-logo"><span><?php echo($data->sistem('app_sis')); ?></span></a>
                    <small class="sidebar-logo-headline"><?php echo($data->sistem('tagline_sis')); ?></small>
                </div>
            </div>
            <!-- sidebar-header -->
            <div id="dpSidebarBody" class="sidebar-body">
			<?php require_once('config/frame/sidebar.php'); ?>
            </div>
            <!-- sidebar-body -->
        </div>
        <!-- sidebar -->

        <!-- content -->
        <div class="content">
        <?php
            require_once('config/frame/header.php');
            require_once('config/frame/content.php');
        ?>
            <div class="content-footer">
            &copy; 2022. All Rights Reserved. Created by <a href="#" target="_blank">ThemePixels Fazlurr X Tegar Satya Negara</a>
            </div><!-- content-footer -->
        </div>
        <!-- content -->
    

        <script type="text/javascript" src="<?php echo("$sistem/lib/jquery/jquery.min.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo("$sistem/lib/jqueryui/jquery-ui.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo("$sistem/lib/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo("$sistem/lib/feather-icons/feather.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo("$sistem/lib/perfect-scrollbar/perfect-scrollbar.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo("$sistem/lib/prismjs/prism.js"); ?>"></script>
	    <script type="text/javascript" src="<?php echo("$sistem/lib/parsleyjs/parsley.min.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo("$sistem/lib/select2/js/select2.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo("$sistem/lib/js-cookie/js.cookie.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo("$sistem/assets/js/cassie.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo("$sistem/sweetalert/js/sweetalert.min.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo("$sistem/config/js/jquery.maskedinput.js"); ?>"></script>
        <script type="text/javascript" src="<?php echo("$sistem/config/js/fazlurr.js"); ?>?t=<?=time()?>"></script>
        <script>
            $(function(){
                'use strict'
                $('.select2').select2({
                    placeholder: '-- Pilih Data --',
                    searchInputPlaceholder: 'Search options'
                });
                $('.datepicker').datepicker({
                    dateFormat: 'yy-mm-dd',
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    changeMonth: true,
                    changeYear: true
                });
            });
            // add by suryo
            $(function(){
                var self_apl = "<?php echo $self_apl["id_apl"]; ?>";
                var self_apl_name = "<?php echo $self_apl["nama_apl"]; ?>";
                $('#transfer_apl_type').on('change', function() {
                    var type = $("#transfer_apl_type option:selected").val();
                    transferType(type, self_apl);
                });
                $('#transfer_apl_from').on('change', function() {
                    var type = $("#transfer_apl_type option:selected").val();
                    checkTransferApl(type, 'from', self_apl, self_apl_name);
                });
                $('#transfer_apl_to').on('change', function() {
                    var type = $("#transfer_apl_type option:selected").val();
                    checkTransferApl(type, 'to', self_apl, self_apl_name);
                });
                $('#taxStatus').on('change', function() {
                    // 
                });
            });
            // $(document).ready(function(){
            //     setInterval(function(){
            //         loadTransferStokNotification('transferstok');
            //     }, 20000);
            // });
            // end
        </script>
    </body>
<?php $conn	= $base->close(); } ?>
</html>
