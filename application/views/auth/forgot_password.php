<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Sınav Analiz Yazılımı - <?php echo lang('forgot_password_heading');?></title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/app.min.css'); ?>">
    <!-- Template CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/components.css'); ?>">
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
                            <h4><?php echo lang('forgot_password_heading');?></h4>
                        </div>
                        <div class="card-body">
                            <p class="text-muted"><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
                            <?php echo form_open("auth/forgot_password");?>
                                <div class="form-group">
                                    <label for="identity">
                                        <?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?>
                                    </label>
                                    <input id="identity" type="email" class="form-control" name="identity" tabindex="1" required autofocus>
                                </div>
                                <div class="form-group pull-right">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        <?php echo lang('forgot_password_submit_btn');?>
                                    </button>
                                    <a href="<?php echo site_url('auth/login'); ?>"  class="btn btn-danger btn-lg btn-block" tabindex="5">
                                        <?php echo lang('forgot_password_identity_cancel');?>
                                    </a>
                                </div>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url('assets/js/app.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/scripts.js'); ?>"></script>
</body>
</html>