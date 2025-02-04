<h6 class="text-lg-start pt-2">Genel Müdürlük Puan Ortalamaları (Puan Sıralı)</h6>
<table class="table">
    <thead>
        <tr>
            <th>Sıra</th>
            <th>Genel Müdürlük</th>
            <th>Öğrenci Sayısı</th>
            <th>En Düşük Puan</th>
            <th>En Yüksek Puan</th>
            <th>Puan Ortalaması</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php foreach ($istatistikler["genel_mudurluk_ortalama"] as $row) : ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row["genel_mudurluk_adi"]; ?></td>
                <td><?php echo $row["ogr_sayisi"]; ?></td>
                <td><?php echo $row["min_puan"]; ?></td>
                <td><?php echo $row["max_puan"]; ?></td>
                <td><?php echo $row["genel_mudurluk_ortalama"]; ?></td>
            </tr>
        <?php endforeach; ?>
        <tr class="bg-success fw-bold">
            <td><?php echo $i++; ?></td>
            <td>İl Geneli</td>
            <td><?php echo $istatistikler["katilan_ogrenci_sayisi"]; ?></td>
            <td><?php echo  $istatistikler["min_puan"]; ?></td>
            <td><?php echo  $istatistikler["max_puan"]; ?></td>
            <td><?php echo  $istatistikler["avg_puan"]; ?></td>
        </tr>
    </tbody>
</table>