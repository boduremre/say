<h6 class="text-lg-start pt-2">Okul Puan Ortalamaları (İlçe Adı ve Okul Adı Alfabetik Sıralı)</h6>
<table class="table">
    <thead>
    <tr>
        <th>Sıra</th>
        <th>İlçe</th>
        <th>Kurum Kodu</th>
        <th>Kurum</th>
        <th>Şube Sayısı</th>
        <th>Öğrenci Sayısı</th>
        <th>En Düşük Puan</th>
        <th>En Yüksek Puan</th>
        <th>Puan Ortalaması</th>
    </tr>
    </thead>
    <tbody>
    <?php $i = 1; ?>
    <?php foreach ($istatistikler["puan_kurumlar"] as $row) : ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $row["ilce_adi"]; ?></td>
            <td><?php echo $row["kurum_kodu"]; ?></td>
            <td><?php echo $row["KURUM_ADI"]; ?></td>
            <td><?php echo $istatistikler["sube_sayilari"][$row["kurum_kodu"]] ?? 0; ?></td>
            <td>
                <a href="<?php echo site_url('sinavlar/students/') . $row["kurum_kodu"] . '/' . $istatistikler["sinav_bilgisi"]->id; ?>"
                   class="btn btn-link"
                   target="_blank"
                   data-toggle="tooltip"
                   title="Öğrenci Listesi">
                    <?php echo $row["ogrenci_sayisi"]; ?>
                </a>
            </td>
            <td><?php echo $row["min_puan"]; ?></td>
            <td><?php echo $row["max_puan"]; ?></td>
            <td><?php echo number_format($row["avg_puan"], 2); ?></td>
        </tr>
    <?php endforeach; ?>
    <tr class="bg-success fw-bold">
        <td><?php echo $i++; ?></td>
        <td colspan="3">İl Geneli</td>
        <td><?php echo $istatistikler["toplam_sube_sayisi"]; ?></td>
        <td><?php echo $istatistikler["katilan_ogrenci_sayisi"]; ?></td>
        <td><?php echo $istatistikler["min_puan"]; ?></td>
        <td><?php echo $istatistikler["max_puan"]; ?></td>
        <td><?php echo number_format($istatistikler["avg_puan"], 2); ?></td>
    </tr>
    </tbody>
</table>