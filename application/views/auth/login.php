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
    <link rel='shortcut icon' type='image/x-icon' href="<?php echo base_url('assets/img/favicon.ico'); ?>"/>
</head>
<body>
<div class="loader"></div>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row mb-1">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 d-flex justify-content-center">
                    <img src="<?php echo base_url('assets/img/odm-logo.png'); ?>" alt="Logo" style="height: 100px; width: auto;">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>Sınav Analiz Yazılımı - Giriş</h4>
                        </div>
                        <div class="card-body">
                            <div id="infoMessage"><?php echo $message; ?></div>

                            <?php echo form_open("auth/login"); ?>
                                <div class="form-group">
                                    <label for="identity"><?php echo lang('login_identity_label', 'identity'); ?></label>
                                    <input id="identity" type="email" class="form-control" name="identity" tabindex="1" required autofocus placeholder="E-posta/Kullanıcı Adı">
                                </div>
                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label"><?php echo lang('login_password_label', 'password'); ?></label>
                                        <div class="float-right">
                                            <a href="forgot_password" class="text-small">
                                                <?php echo lang('login_forgot_password'); ?>
                                            </a>
                                        </div>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required placeholder="Parola">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember" checked>
                                        <label class="custom-control-label" for="remember">
                                            <?php echo lang('login_remember_label', 'remember'); ?>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group pull-right">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        <?php echo lang('login_submit_btn'); ?>
                                    </button>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 d-flex justify-content-center">
                    <img src="<?php echo base_url('assets/img/yuzuncu_yil_logo_renkli.png'); ?>" alt="Logo" style="height: auto; width: 20%;">
                </div>
            </div>
        </div>
    </section>
</div>
<script src="<?php echo base_url('assets/js/app.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/scripts.js'); ?>"></script>
</body>
</html>