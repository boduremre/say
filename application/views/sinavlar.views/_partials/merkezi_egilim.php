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
            <td><?php echo  number_format($istatistikler["avg_puan"],2,","); ?></td>
            <td><?php echo  $istatistikler["median_puan"]; ?></td>
            <td><?php echo  $istatistikler["mode"]->puan . " (" . $istatistikler["mode"]->tekrar_sayisi . ")"; ?></td>
        </tr>
    </tbody>
</table>