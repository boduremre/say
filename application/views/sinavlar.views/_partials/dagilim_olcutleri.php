<h6 class="text-lg-start pt-2">Yayılım (Dağılım) Ölçütleri</h6>
<table class="table">
    <thead>
    <tr>
        <th>En Düşük Puan</th>
        <th>En Yüksek Puan</th>
        <th>Standart Sapma</th>
        <th>Varyans</th>
        <th>Sınav Zorluk Derecesi (Varyans)</th>
        <th>Açıklama</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?php echo  $istatistikler["min_puan"]; ?></td>
        <td><?php echo  $istatistikler["max_puan"]; ?></td>
        <td><?php echo  $istatistikler["standart_sapma"]; ?></td>
        <td><?php echo  $istatistikler["varyans"]; ?></td>
        <td><?php echo  $istatistikler["determine_exam_difficulty_based_on_variance"]; ?></td>
        <td><i class="fa fa-info-circle" data-toggle="tooltip" title="Varyans, zorluk derecesi hakkında daha doğrudan ve güvenilir bir bilgi verir. Çünkü varyans, sınavın zorluğu hakkında net bir gösterge sunar: Eğer varyans yüksekse, sınav zor olmuştur; eğer varyans düşükse, sınav kolay ya da orta düzeyde olmuştur. Çarpıklık ise sınavın zorluğu hakkında dolaylı bir gösterge olabilir ve yalnızca dağılımın şeklini analiz eder. "></i></td>
    </tr>
    </tbody>
</table>
