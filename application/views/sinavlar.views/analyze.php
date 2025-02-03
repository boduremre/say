<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Sınav Bilgileri</h4>
                <div class="card-header-action">
                    <a href="<?php echo site_url('sinavlar/index'); ?>" class="btn btn-sm btn-primary">
                        Sınavları Listele
                    </a>
                    <?php if ($sinav->yayin_durumu == 2): ?>
                        <a href="<?php echo site_url('sinavlar/do/analyze/') . $sinav->id; ?>" class="btn btn-sm btn-success">
                            Analizi Başlat
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sınav Adı</th>
                            <th>Sınav Tarihi</th>
                            <th>Sınıf</th>
                            <th>Soru Say.</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $sinav->id; ?></td>
                            <td class="text-nowrap">
                                        <span data-toggle="tooltip" title="<?php echo $sinav->aciklama; ?>">
                                            <?php echo $sinav->sinav_adi; ?>
                                        </span>
                            </td>
                            <td class="text-nowrap"><?php echo date("d.m.Y H:i", strtotime($sinav->baslangic_tarihi)); ?></td>
                            <td><?php echo $sinav->sinif_adi; ?></td>
                            <td><?php echo $sinav->soru_sayisi; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-12 col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Puan Listesi Yükle</h4>
            </div>
            <div class="card-body">
                <?php echo form_open_multipart(site_url('sinavlar/excel/upload')); ?>
                <input type="hidden" name="sinav_id" value="<?php echo $sinav->id; ?>"/>
                <div class="row">
                    <div class="col-md-12">
                        <input type="file" class="form-control" name="file" id="file" required/>
                    </div>
                </div>
                <div class="row pull-right mt-2">
                    <div class="col-md-12 ">
                        <input type="submit" class="btn btn-primary" value="Gönder"/>
                        <a href="<?php echo site_url("sinavlar/index"); ?>" class="btn btn-danger">İptal</a>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>