<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Sistem Değişkenleri</h4>
            </div>
            <div class="card-body">
                <pre><?php echo $title; ?></pre>
                <pre><?php echo $view; ?></pre>

                <?php pa($data); ?>
            </div>
            <div class="card-footer pull-right">
                Sayfa <strong>{elapsed_time}</strong> saniyede
                oluşturuldu. <?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter Sürümü <strong>' . CI_VERSION . '</strong>' : '' ?>
            </div>
        </div>
    </div>
</div>
