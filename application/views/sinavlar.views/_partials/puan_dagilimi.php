<div class="row">
    <div class="col-12">
        <h6 class="text-lg-start pt-2">Puan Dağılımı</h6>
    </div>
    <div class="col-6">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Puan Aralığı</th>
                    <th>Öğrenci Sayısı</th>
                </tr>
                </thead>
                <tbody>
                <?php $firstRow = true; ?>
                <?php foreach ($istatistikler["puan_dagilimi"] as $puan_dagilimi) : ?>
                    <tr>
                        <td><?php echo $puan_dagilimi["puan_araligi"]; ?></td>
                        <td><?php echo $puan_dagilimi["ogrenci_sayisi"]; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-6">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Puan Dağılım Grafiği</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <img src="<?php echo base_url($istatistikler["puan_dagilim_grafigi"]); ?>" alt="Puan Dağılım Grafiği" style="width: 100%; height: auto;">
                    </td>
                </tr>
                </tbody>
            </table>
    </div>
</div>
