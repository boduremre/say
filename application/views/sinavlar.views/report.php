<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Sınav Analiz Raporu</h4>
                <div class="card-header-action">
                    <a href="<?php echo site_url('sinavlar/index'); ?>" class="btn btn-sm btn-primary">
                        Sınavları Listele
                    </a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-success btn-copy">
                        <i class="fa fa-clipboard"></i> Kopyala
                    </a>
                </div>
            </div>
            <div class="card-body" id="copyable-content">
                <h4 class="text-center"><?php echo $istatistikler["sinav_bilgisi"]->sinav_adi; ?> RAPORU</h4>
                <!-- load report partial -->
                <?php $this->load->view("sinavlar.views/_partials/temel_istatistikler"); ?>
                <?php $this->load->view("sinavlar.views/_partials/merkezi_egilim"); ?>
                <?php $this->load->view("sinavlar.views/_partials/dagilim_olcutleri"); ?>
                <?php $this->load->view("sinavlar.views/_partials/skewness"); ?>
                <?php $this->load->view("sinavlar.views/_partials/puan_dagilimi"); ?>
                <h5 class="text-center">İlçeler Bazında Sınav Bilgileri</h5>
                <?php $this->load->view("sinavlar.views/_partials/ilce_ogrenci_sayilari"); ?>
                <?php $this->load->view("sinavlar.views/_partials/ilce_puan_ort"); ?>
                <?php $this->load->view("sinavlar.views/_partials/ilce_puan_ort_sirali"); ?>
                <h5 class="text-center">Okul Bazında Sınav Bilgileri</h5>
                <?php $this->load->view("sinavlar.views/_partials/okul_puan_ort"); ?>
                <?php $this->load->view("sinavlar.views/_partials/okul_puan_ort_sirali"); ?>
            </div>
        </div>
    </div>
</div>
