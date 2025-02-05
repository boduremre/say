<h6 class="text-lg-start pt-2">İlçe Öğrenci Sayıları</h6>
<table class="table">
    <thead>
    <tr>
        <th>İlçe</th>
        <th>Toplam Öğrenci Sayısı</th>
        <th>Katılan Öğrenci Sayısı</th>
        <th>Katılmayan Öğrenci Sayısı</th>
    </tr>
    </thead>
    <tbody>
        <?php $toplam = 0; ?>
        <?php $katilan_ogr_say = 0; ?>
        <?php $fark = 0; ?>
        <?php foreach ($istatistikler["ogr_say_ilceler"] as $row): ?>
        <?php  $toplam = $toplam + $row["ogr_say"]; ?>
        <?php  $katilan_ogr_say = $katilan_ogr_say + $row["katilan_ogr_say"]; ?>
        <?php  $fark = $fark + $row["fark"]; ?>
            <tr>
                <td><?php echo $row["ilce_adi"]; ?></td>
                <td><?php echo $row["ogr_say"]; ?></td>
                <td><?php echo $row["katilan_ogr_say"]; ?></td>
                <td><?php echo $row["fark"]; ?></td>
            </tr>
        <?php endforeach; ?>
    <tr class="bg-success fw-bold">
        <td>İl Geneli</td>
        <td><?php echo $toplam; ?></td>
        <td><?php echo $katilan_ogr_say; ?></td>
        <td><?php echo $fark; ?></td>
    </tr>
    </tbody>
</table>