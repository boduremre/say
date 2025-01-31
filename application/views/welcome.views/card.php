<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Aktif Sınavlar</h4>
                    <div class="card-header-form">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Sınav Ara">
                            <div class="input-group-btn">
                                <a data-collapse="#mycard-collapse" class="btn btn-icon btn-success" href="#"><i class="fas fa-minus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse">
                    <div class="card-body">
                        <!-- load sınavlar partial -->
                        <?php $this->load->view("welcome.views/_partials/sinavlar"); ?>
                    </div>
                    <div class="card-footer pull-right">
                        Sayfa <strong>{elapsed_time}</strong> saniyede oluşturuldu. <?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter Sürümü <strong>' . CI_VERSION . '</strong>' : '' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>