<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Aktif Sınavlar</h4>
                <div class="card-header-action">
                    <a href="<?php echo site_url('sinavlar/create'); ?>" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Yeni Sınav Ekle">
                        <i class="fa fa-plus"></i> Yeni Sınav Ekle
                    </a>
                    <a href="<?php echo site_url('sinavlar/general-analysis-report'); ?>" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Genel Analiz">
                        <i class="fa fa-chart-bar"></i> Genel Analiz
                    </a>
                </div>
            </div>
            <div class="card-body p-3 pt-0">
                <!-- load sınavlar partial -->
                <?php $this->load->view("welcome.views/_partials/sinavlar"); ?>
            </div>
        </div>
    </div>
</div>