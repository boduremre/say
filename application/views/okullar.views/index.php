<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Okullar</h4>
                <div class="card-header-action">
                    <a href="<?php echo site_url('okullar/index'); ?>" class="btn btn-sm btn-primary disabled" disabled="disabled">
                        <i class="fa fa-plus"></i> Yeni Okul Ekle
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                        <tr>
                            <th>İlçe</th>
                            <th>Kurum Türü</th>
                            <th>Kurum Kodu</th>
                            <th>Kurum Adı</th>
                            <th>Durum</th>
                            <th>İşlemler</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($okullar as $okul) { ?>
                            <tr>
                                <td class="text-nowrap"><?php echo $okul->ilce_adi; ?></td>
                                <td><?php echo $okul->kurum_turu; ?></td>
                                <td><?php echo $okul->kurum_kodu; ?></td>
                                <td class="text-nowrap"><?php echo $okul->kurum_adi; ?></td>
                                <td>
                                    <?php echo $okul->durum == 0 ? "<span class='badge badge-danger text-center'>Pasif</span>" : "<span class='badge badge-success text-center'>Aktif</span>"; ?>
                                </td>
                                <td>
                                    <a href="<?php echo base_url(); ?>index.php/okullar/edit/<?php echo $okul->id; ?>"
                                       class="btn btn-info btn-xs" data-toggle="tooltip" title="Düzenle">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <?php if (isset($items)) {
        foreach ($items as $item) { ?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class="user-card contact-item p-md">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $item->kurum_kodu; ?></h4>
                            <h5 class="media-heading"><?php echo $item->kurum_adi; ?></h5>
                            <small class="media-meta"><?php echo $item->il_adi . "/" . $item->ilce_adi; ?></small><br/>
                        </div>
                    </div>
                    <div class="contact-item-actions">
                        <a data-toggle="tooltip" title="Düzenle"
                           href="<?php echo base_url("index.php/okullar/edit/"); ?><?php echo $item->id; ?>"
                           class="btn btn-xs btn-success">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a data-toggle="tooltip" title="Eposta Gönder"
                           href="mailto:<?php echo $item->eposta; ?>" class="btn btn-xs btn-primary">
                            <i class="fa fa-send"></i>
                        </a>
                        <a data-toggle="tooltip" title="Ara"
                           href="tel:<?php echo $item->telefon; ?>" class="btn btn-xs btn-primary">
                            <i class="fa fa-phone"></i>
                        </a>
                        <a data-toggle="tooltip" title="Sil (Geri Alınamaz)"
                           href="<?php echo base_url("index.php/okullar/delete/"); ?><?php echo $item->id; ?>"
                           class="btn btn-xs btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php }
    } ?>
</div>
