<h6 class="text-lg-start pt-2">Puan Dağılımı</h6>
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>Puan Aralığı</th>
            <th>Öğrenci Sayısı</th>
            <th class="text-lg-start">Puan Dağılım Grafiği</th>
        </tr>
        </thead>
        <tbody>
        <?php $firstRow = true; ?>
        <?php foreach ($istatistikler["puan_dagilimi"] as $puan_dagilimi) : ?>
            <tr>
                <td><?php echo $puan_dagilimi["puan_araligi"]; ?></td>
                <td><?php echo $puan_dagilimi["ogrenci_sayisi"]; ?></td>
                <?php if ($firstRow) : ?>
                    <td class="text-lg-start" rowspan="<?php echo count($istatistikler["puan_dagilimi"]); ?>">
                        <img src="<?php echo base_url($istatistikler["puan_dagilim_grafigi"]); ?>" alt="Puan Dağılım Grafiği">
                    </td>
                    <?php $firstRow = false; ?>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>