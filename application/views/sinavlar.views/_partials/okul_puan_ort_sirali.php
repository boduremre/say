<h6 class="text-lg-start pt-2">Okul Puan Ortalamaları (Ortalama Puana Göre Sıralı)</h6>
<table class="table">
    <thead>
    <tr>
        <th>Sıra</th>
        <th>İlçe</th>
        <th>Kurum Kodu</th>
        <th>Kurum</th>
        <th>Öğrenci Sayısı</th>
        <th>En Düşük Puan</th>
        <th>En Yüksek Puan</th>
        <th>Puan Ortalaması</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; ?>
    <?php foreach ($istatistikler["puan_kurumlar_sirali"] as $row) : ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row["ilce_adi"]; ?></td>
            <td><?php echo $row["kurum_kodu"]; ?></td>
            <td><?php echo $row["KURUM_ADI"]; ?></td>
            <td><?php echo $row["ogrenci_sayisi"]; ?></td>
            <td><?php echo $row["min_puan"]; ?></td>
            <td><?php echo $row["max_puan"]; ?></td>
            <td><?php echo $row["avg_puan"]; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
