<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Sınav Düzenle</h4>
                <div class="card-header-action">
                    <a href="<?php echo site_url('sinavlar/index'); ?>" class="btn btn-sm btn-primary">
                        Sınavları Listele
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php echo form_open(base_url('index.php/sinavlar/update'), 'id="form7"'); ?>
                <input type="hidden" name="dogrulama_kodu" value="<?php echo $sinav->dogrulama_kodu; ?>"/>
                <input type="hidden" name="sinav_kodu" value="<?php echo $sinav->sinav_kodu; ?>"/>
                <input type="hidden" name="onay_durumu" value="1"/>
                <input type="hidden" name="duzenlenebilir" value="1"/>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="control-label">Sınav Adı</label>
                        <input maxlength="100" type="text" class="form-control" placeholder="Sınav adını giriniz" name="sinav_adi" id="sinav_adi" required
                               value="<?php echo $sinav->sinav_adi; ?>"/>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="control-label">Açıklama</label>
                        <input maxlength="100" type="text" class="form-control" placeholder="Açıklama giriniz" name="aciklama" id="aciklama"
                               value="<?php echo $sinav->aciklama; ?>"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="control-label" for="ders_id">Ders</label>
                        <select id="ders_id" name="ders_id" class="form-control" style="width: 100%" required>
                            <?php
                            foreach ($dersler as $ders) {
                                if ($ders->ders_id == $sinav->ders_id)
                                    echo '<option selected value="' . $ders->ders_id . '">' . $ders->ders_adi . '</option>';
                                else
                                    echo '<option value="' . $ders->ders_id . '">' . $ders->ders_adi . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="control-label">Sınıf Düzeyi</label>
                        <select id="sinif_id" name="sinif_id" class="form-control" style="width: 100% " required>
                            <?php
                            foreach ($siniflar as $sinif) {
                                if ($sinif->sinif_id == $sinav->sinif_id)
                                    echo '<option selected value="' . $sinif->sinif_id . '">' . $sinif->sinif_adi . '</option>';
                                else
                                    echo '<option value="' . $sinif->sinif_id . '">' . $sinif->sinif_adi . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="control-label" for="soru_sayisi">Soru Sayısı</label>
                        <input maxlength="100" type="number" class="form-control" placeholder="Soru Sayısı Giriniz" name="soru_sayisi" id="soru_sayisi" required value="<?php echo $sinav->soru_sayisi; ?>"/>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="control-label">Sınav Tarihi</label>
                        <input type="datetime-local" class="form-control" name="baslangic_tarihi" value="<?php echo isset($sinav->baslangic_tarihi) ?
                            set_value('baslangic_tarihi', date('Y-m-d\TH:i', strtotime($sinav->baslangic_tarihi))) : set_value('baslangic_tarihi'); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <div class="pull-right">
                            <input type="submit" id="submit_button" name="submit" class="btn btn-primary" value="Güncelle"/>
                            <a href="<?php echo site_url("sinavlar/index"); ?>" class="btn btn-danger">İptal</a>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div><!-- .widget-body -->
        </div><!-- .widget -->
    </div>
    <!-- END column -->
</div>