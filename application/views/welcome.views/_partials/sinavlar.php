<div class="table-responsive">
    <table class="table table-hover datatable" data-order-column="0" data-order-direction="asc">
        <thead>
        <tr>
            <th>ID</th>
            <th>Sınav Adı</th>
            <th class="text-center">Sınav Tarihi</th>
            <th class="text-center">Sınıf</th>
            <th class="text-center">Soru Say.</th>
            <th class="text-center">Katılan Öğr. Say.</th>
            <th class="text-center">Ortalama Puan <i class="fa fa-info-circle" data-toggle="tooltip" title="Sınavda başarı kriteri 50 puan olarak alınmıştır."></i></th>
            <th class="text-center">Durumu</th>
            <th>İşlemler</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($sinavlar as $sinav) { ?>
            <tr>
                <td><?php echo $sinav->id; ?></td>
                <td class="text-nowrap">
                        <span data-toggle="tooltip" title="<?php echo $sinav->aciklama; ?>">
                            <?php echo $sinav->sinav_adi; ?>
                        </span>
                </td>
                <td class="text-nowrap text-center">
                    <?php echo date("d.m.Y H:i", strtotime($sinav->baslangic_tarihi)); ?>
                </td>
                <td class="text-center"><?php echo $sinav->sinif_adi; ?></td>
                <td class="text-center"><?php echo $sinav->soru_sayisi; ?></td>
                <td class="text-center"><?php echo $sinav->ogrenci_sayisi; ?></td>
                <td class="text-center">
                    <?php if ($sinav->ortalama_puan > 49): ?>
                        <span class="badge badge-success">
                            <?php echo number_format($sinav->ortalama_puan, 2, ","); ?>
                        </span>
                    <?php else: ?>
                        <span class="badge badge-danger">
                            <?php echo number_format($sinav->ortalama_puan, 2, ","); ?>
                        </span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <?php if ($sinav->yayin_durumu == 0) { ?>
                        <span class="badge badge-primary">Beklemede</span>
                    <?php } elseif ($sinav->yayin_durumu == 1) { ?>
                        <span class="badge badge-success">Analiz Tamamlandı</span>
                    <?php } elseif ($sinav->yayin_durumu == 2) { ?>
                        <span class="badge badge-info">Puan Listesi Yüklendi</span>
                    <?php } ?>
                </td>
                <td>
                    <a href="<?php echo site_url('sinavlar/edit/') . $sinav->id; ?>" class="btn btn-info btn-xs" data-toggle="tooltip" title="Düzenle">
                        <i class="fa fa-edit"></i>
                    </a>
                    <?php if ($sinav->yayin_durumu == 0) { ?>
                        <a href="<?php echo site_url('sinavlar/analyze/') . $sinav->id; ?>" data-toggle="tooltip" title="Analiz İşlemi"
                           class="btn btn-dark btn-xs">
                            <i class="fa fa-share"></i>
                        </a>
                        <a href="javascript:void(0)"
                           data-url="<?php echo site_url('sinavlar/delete/') . $sinav->id; ?>"
                           class="btn btn-danger btn-xs remove-btn"
                           data-toggle="tooltip"
                           title="Sil (Analiz Yapılmayan Sınav Silinebilir)">
                            <i class="fa fa-trash"></i>
                        </a>
                    <?php } else if ($sinav->yayin_durumu == 2) { ?>
                        <a href="<?php echo site_url('sinavlar/analyze/') . $sinav->id; ?>" data-toggle="tooltip" title="Analiz İşlemi"
                           class="btn btn-dark btn-xs">
                            <i class="fa fa-share"></i>
                        </a>
                    <?php } else { ?>
                        <a href="<?php echo site_url('sinavlar/do/analyze/') . $sinav->id; ?>" data-toggle="tooltip" title="Analiz Sonucunu Görüntüle" class="btn btn-primary btn-xs">
                            <i class="fa fa-chart-pie"></i>
                        </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>