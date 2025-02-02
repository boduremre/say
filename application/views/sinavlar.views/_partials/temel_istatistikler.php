<h6 class="text-lg-start pt-2">Sınava Ait Sayısal Bilgiler</h6>
<table class="table">
    <thead>
    <tr>
        <th>Toplam Öğrenci Sayısı</th>
        <th>Sınava Katılan Öğrenci Sayısı</th>
        <th>Sınava Katılmayan Öğrenci Sayısı</th>
        <th>Başarılı Öğrenci Sayısı <i class="fa fa-info-circle" data-toggle="tooltip" title="Sınavda 50 puan ve üzerinde puan alan öğrenciler."></i></th>
        <th>Başarısız Öğrenci Sayısı <i class="fa fa-info-circle" data-toggle="tooltip" title="Sınavda 50 puan altında puan alan öğrenciler."></i></th>
        <th>Başarı Oranı (%)</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?php echo $istatistikler["toplam_ogrenci_sayisi"]; ?></td>
        <td><?php echo $istatistikler["katilan_ogrenci_sayisi"]; ?></td>
        <td><?php echo $istatistikler["katilmayan_ogrenci_sayisi"]; ?></td>
        <td><?php echo $istatistikler["basarili_ogrenci_sayisi"]; ?></td>
        <td><?php echo $istatistikler["basarisiz_ogrenci_sayisi"]; ?></td>
        <td><?php echo $istatistikler["basari_orani"]; ?></td>
    </tr>
    </tbody>
</table>
