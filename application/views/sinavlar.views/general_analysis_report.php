<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Kurum Kodu</th>
                    <th>Kurum Adı</th>
                    <th>İlçe Adı</th>
                    <?php if (!empty($results)) : ?>
                        <?php foreach ($results[0] as $key => $value) : ?>
                            <?php if (!in_array($key, ['kurum_kodu', 'KURUM_ADI', 'ilce_adi'])) : ?>
                                <th><?php echo str_replace('_', ' ', $key); ?></th>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($results)) : ?>
                    <?php foreach ($results as $row) : ?>
                        <tr>
                            <td><?php echo $row['kurum_kodu']; ?></td>
                            <td><?php echo $row['KURUM_ADI']; ?></td>
                            <td><?php echo $row['ilce_adi']; ?></td>
                            <?php foreach ($row as $key => $value) : ?>
                                <?php if (!in_array($key, ['kurum_kodu', 'KURUM_ADI', 'ilce_adi'])) : ?>
                                    <td><?php echo is_numeric($value) ? number_format($value, 2) : $value; ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="100%">Veri bulunamadı.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
