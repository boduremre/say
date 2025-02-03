<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sınav Analiz Yazılımı - Giriş</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/app.min.css'); ?>">
    <!-- Template CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/components.css'); ?>">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css'); ?>">
    <link rel='shortcut icon' type='image/x-icon' href="<?php echo base_url('assets/img/favicon.ico'); ?>"/>
</head>
<body>
<div class="loader"></div>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Login</h4>
                        </div>
                        <div class="card-body">
                            <h1><?php echo lang('login_heading'); ?></h1>
                            <p><?php echo lang('login_subheading'); ?></p>

                            <div id="infoMessage"><?php echo $message; ?></div>

                            <?php echo form_open("auth/login"); ?>

                            <p>
                                <?php echo lang('login_identity_label', 'identity'); ?>
                                <?php echo form_input($identity); ?>
                            </p>

                            <p>
                                <?php echo lang('login_password_label', 'password'); ?>
                                <?php echo form_input($password); ?>
                            </p>

                            <p>
                                <?php echo lang('login_remember_label', 'remember'); ?>
                                <?php echo form_checkbox('remember', '1', TRUE, 'id="remember"'); ?>
                            </p>

                            <p><?php echo form_submit('submit', lang('login_submit_btn')); ?></p>

                            <?php echo form_close(); ?>
                            <div class="mt-5 text-muted text-center">
                                Don't have an account? <a href="auth-register.html">Create One</a>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
</div>
<!-- General JS Scripts -->
<script src="<?php echo base_url('assets/js/app.min.js'); ?>"></script>
<!-- JS Libraies -->
<!-- Page Specific JS File -->
<!-- Template JS File -->
<script src="<?php echo base_url('assets/js/scripts.js'); ?>"></script>
<!-- Custom JS File -->
<script src="<?php echo base_url('assets/js/custom.js'); ?>"></script>
</body>

</html>
<p><a href="forgot_password"><?php echo lang('login_forgot_password'); ?></a></p>