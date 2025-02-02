<h6 class="text-lg-start pt-2">Çarpıklık (Skewness) ve Ranj</h6>
<table class="table">
    <thead>
    <tr>
        <th>Değişim Aralığı (Ranj)</th>
        <th>Çarpıklık (Skewness) Değeri</th>
        <th>Dağılım Yönü</th>
        <th>Dağılım Grafiği</th>
        <th>Sınav Zorluk Derecesi</th>
        <th>Açıklama</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?php echo  $istatistikler["ranj"]; ?></td>
        <td><?php echo  $istatistikler["skewness"]; ?></td>
        <td><?php echo  $istatistikler["interpret_skewness"]; ?></td>
        <td>
            <a href="<?php echo  $istatistikler['skewness_graph_link']; ?>" class="btn btn-primary btn-sm" role="button" target="_blank">
                <i class="fa fa-chart-bar" data-toggle="tooltip" title="Dağılım Grafiğini Göster"></i>
            </a>
        </td>
        <td><?php echo  $istatistikler["determine_exam_difficulty_variance_skewness"]; ?></td>
        <td><i class="fa fa-info-circle" data-toggle="tooltip" title="<?php echo $istatistikler['DİKKAT'];?>"></i></td>
    </tr>
    </tbody>
</table>
