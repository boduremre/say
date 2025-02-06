<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="card card-primary">
            <div class="card-header">
                <h4>Öğrenciler</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Öğr. No</th>
                            <th>Ad Soyad</th>
                            <th>Kurum Kodu</th>
                            <th>Kurum Adı</th>
                            <th>Puan</th>
                            <th>Durum</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($students as $student) { ?>
                            <tr>
                                <td><?php echo $student->id; ?></td>
                                <td><?php echo $student->ogr_no; ?></td>
                                <td><?php echo $student->ogr_adi_soyadi; ?></td>
                                <td><?php echo $student->kurum_kodu; ?></td>
                                <td class="text-nowrap"><?php echo $student->KURUM_ADI; ?></td>
                                <td><?php echo $student->puan; ?></td>
                                <td><?php echo $student->status ? '<span class="badge badge-success">Girdi</span>' : '<span class="badge badge-danger">Girmedi</span>'; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>