<h6 class="text-lg-start pt-2">İlçe Öğrenci Sayıları</h6>
<table class="table">
    <thead>
        <tr>
            <th>İlçe</th>
            <th>Toplam Öğrenci Sayısı</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($istatistikler["ogr_say_ilceler"] as $row) : ?>
            <tr>
                <td><?php echo $row["ilce_adi"]; ?></td>
                <td><?php echo $row["ogr_say"]; ?></td>
            </tr>
        <?php endforeach; ?>
        <tr class="bg-success fw-bold">
            <td>İl Geneli</td>
            <td><?php echo $istatistikler["katilan_ogrenci_sayisi"]; ?></td>
        </tr>
    </tbody>
</table>