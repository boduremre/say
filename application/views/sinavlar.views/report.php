<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Sınav Analiz Raporu</h4>
                <div class="card-header-action">
                    <a href="<?php echo site_url('sinavlar/index'); ?>" class="btn btn-sm btn-primary">
                        <i class="fa fa-list"></i> Sınavları Listele
                    </a>
                    <?php if ($istatistikler["sinav_bilgisi"]->yayin_durumu == 1): ?>
                        <button type="button" class="btn btn-sm btn-success btn-copy" data-clipboard-target="#copyable-content">
                            <i class="fa fa-clipboard"></i> Kopyala
                        </button>
                        <a href="<?php echo site_url('sinavlar/download_json/'). $istatistikler['sinav_bilgisi']->id; ; ?>" class="btn btn-sm btn-info">
                            <i class="fa fa-download"></i> Verileri İndir
                        </a>
                        <button type="submit" class="btn btn-sm btn-danger" form="truncate-form">
                            <i class="fa fa-trash"></i> Analizi Sıfırla
                        </button>
                        <?php echo form_open(site_url('sinavlar/truncate/analyze/'), array("id" => "truncate-form")); ?>
                            <input type="hidden" name="sinav_id" value="<?php echo $istatistikler['sinav_bilgisi']->id; ?>">
                        <?php echo form_close(); ?>
                    <?php endif; ?>
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
                <h5 class="text-center">Genel Müdürlük Bazında Sınav Bilgileri</h5>
                <?php $this->load->view("sinavlar.views/_partials/genel_mudurluk_puan_ort"); ?>
            </div>
        </div>
    </div>
</div>
