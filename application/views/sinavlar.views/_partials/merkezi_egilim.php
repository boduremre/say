<h6 class="text-lg-start pt-2">Merkezi Eğilim Ölçütleri (Ortalama, Medyan, Mod)</h6>
<table class="table">
    <thead>
    <tr>
        <th>Ortalama (Mean)</th>
        <th>Medyan (Median)</th>
        <th>Mod (Mode)</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?php echo  $istatistikler["avg_puan"]; ?></td>
        <td><?php echo  $istatistikler["median_puan"]; ?></td>
        <td><?php echo  $istatistikler["mode"]->puan; ?></td>
    </tr>
    </tbody>
</table>
