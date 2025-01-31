<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Aktif Sınavlar</h4>
            </div>
            <div class="card-body p-3 pt-0">
                <!-- load sınavlar partial -->
                <?php $this->load->view("welcome.views/_partials/sinavlar"); ?>
            </div>
        </div>
    </div>
</div>