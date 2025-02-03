<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sınav Analiz Yazılımı | <?= $title; ?></title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/app.min.css">
    <!-- Template CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/components.css">

    <!-- Datatables CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/bundles/datatables/dataTables.min.css">

    <!-- Custom style CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='<?php echo base_url('assets'); ?>/img/favicon.ico'/>
</head>

<body>
<div class="loader"></div>
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <!-- load navbar -->
        <?php $this->load->view("layouts/navbar"); ?>
        <!-- load asidebar/menu -->
        <?php $this->load->view("layouts/aside"); ?>
        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <ul class="breadcrumb breadcrumb-style ">
                    <li class="breadcrumb-item">
                        <h5 class="page-title m-b-0">SAY</h5>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?php echo site_url('welcome'); ?>">
                            <i data-feather="home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        <?= $title; ?>
                    </li>
                </ul>
                <div class="section-body">
                    <!-- add content here -->
                    <?php $this->load->view($view, $data); ?>
                </div>
            </section>
            <!-- load setting sidebar -->
            <?php //$this->load->view("layouts/setting_sidebar");
            ?>
        </div>
        <!-- load footer -->
        <?php $this->load->view("layouts/footer"); ?>
    </div>
</div>
<script>
    const BASE_URL = "<?php echo base_url(); ?>";
    const SITE_URL = "<?php echo site_url(); ?>";
</script>
<?php $CI = &get_instance(); ?>
<script>
    const csrf_name = "<?php echo $CI->security->get_csrf_token_name(); ?>";
    const csrf_hash = "<?php echo $CI->security->get_csrf_hash(); ?>";
</script>
<!-- General JS Scripts -->
<script src="<?php echo base_url('assets'); ?>/js/app.min.js"></script>

<!-- JS Libraies -->
<script src="<?php echo base_url('assets'); ?>/bundles/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo base_url('assets'); ?>/bundles/datatables/dataTables.min.js"></script>

<!-- Page Specific JS File -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
    
<!-- Template JS File -->
<script src="<?php echo base_url('assets'); ?>/js/scripts.js"></script>
<!-- Custom JS File -->
<script src="<?php echo base_url('assets'); ?>/js/custom.js"></script>
<!-- load alert -->
<?php $this->load->view("layouts/alert"); ?>
</body>

</html>