<h6 class="text-lg-start pt-2">İlçe Puan Ortalamaları (Ortalama Puana Göre Sıralı)</h6>
<table class="table">
    <thead>
    <tr>
        <th>Sıra</th>
        <th>İlçe</th>
        <th>Öğrenci Sayısı</th>
        <th>En Düşük Puan</th>
        <th>En Yüksek Puan</th>
        <th>Puan Ortalaması</th>
    </tr>
    </thead>
    <tbody>
    <?php $i=1;?>
    <?php foreach ($istatistikler["puan_ilceler_sirali"] as $row) : ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row["ilce_adi"]; ?></td>
            <td><?php echo $row["ogr_sayisi"]; ?></td>
            <td><?php echo $row["min_puan"]; ?></td>
            <td><?php echo $row["max_puan"]; ?></td>
            <td><?php echo $row["ilce_ortalama"]; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
