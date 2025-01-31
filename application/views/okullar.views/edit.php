<div class="row">
    <?php echo form_open(base_url('index.php/okullar/update')); ?>
    <input type="hidden" name="id" value="<?php echo $okul->id; ?>"/>
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h4>Okullar</h4>
                <div class="card-header-action">
                    <a href="<?php echo site_url('okullar/index'); ?>" class="btn btn-sm btn-primary">
                        Kurum Listesi
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label">İl</label>
                    <select id="il_id" name="il_id" class="form-control" data-plugin="select2"
                            style="width: 100%" required>
                        <option value="">Seçiniz...</option>
                        <option <?php echo $okul->il_id == "27" ? "selected" : ""; ?> value="27">Düzce</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="maxlength-demo-3">İlçe</label>
                    <select id="ilce_id" name="ilce_id" class="form-control" data-plugin="select2"
                            style="width: 100%" required>
                        <option value="">Seçiniz...</option>
                        <option value="<?php echo $okul->ilce_id; ?>" selected><?php echo $okul->ilce_adi; ?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="maxlength-demo-1">Okul/Kurum Adı</label>
                    <input type="text" class="form-control" name="kurum_adi" value="<?php echo $okul->kurum_adi; ?>"/>
                </div>
                <div class="form-group">
                    <label class="form-label" for="maxlength-demo-2">Kurum Kodu</label>
                    <input type="text" class="form-control" name="kurum_kodu" value="<?php echo $okul->kurum_kodu; ?>"/>
                </div>
                <div class="form-group">
                    <label class="form-label" for="maxlength-demo-2">Adres</label>
                    <input type="text" class="form-control" name="adres" value="<?php echo $okul->adres; ?>"/>
                </div>
                <div class="form-group">
                    <label class="form-label" for="maxlength-demo-3">Eposta</label>
                    <input type="email" class="form-control text-lowercase" name="eposta"
                           value="<?php echo $okul->eposta; ?>"/>
                </div>
                <div class="form-group">
                    <label class="form-label" for="maxlength-demo-3">Eposta 2</label>
                    <input type="email" class="form-control text-lowercase" name="eposta2"
                           value="<?php echo $okul->eposta2; ?>"/>
                </div>
                <div class="form-group">
                    <label class="form-label">Telefon</label>
                    <input type="text" class="form-control" name="telefon" id="telefon"
                           value="<?php echo $okul->telefon; ?>"/>
                </div>
                <div class="form-group">
                    <label class="form-label">Web</label>
                    <input type="text" class="form-control" name="web" id="web"
                           value="<?php echo $okul->web; ?>"/>
                </div>
                <div class="form-group">
                    <label class="form-label">Müdür</label>
                    <input type="text" class="form-control" name="mudur" id="mudur"
                           value="<?php echo $okul->mudur; ?>"/>
                </div>
                <div class="form-group">
                    <label class="form-label">Müdür Cep Telefonu</label>
                    <input type="text" class="form-control" name="mudur_cep" id="mudur_cep"
                           value="<?php echo $okul->mudur_cep; ?>"/>
                </div>
                <div class="form-group">
                    <label class="form-label">Müdür Yardımcısı</label>
                    <input type="text" class="form-control" name="mudur_yrd" id="mudur_yrd"
                           value="<?php echo $okul->mudur_yrd; ?>"/>
                </div>
                <div class="form-group">
                    <label class="form-label">Müdür Yardımcısı Cep Telefonu</label>
                    <input type="text" class="form-control" name="mudur_yrd_cep" id="mudur_yrd_cep"
                           value="<?php echo $okul->mudur_yrd_cep; ?>"/>
                </div>
                <div class="form-group">
                    <label class="form-label">Durum</label>
                    <select id="durum" name="durum" class="form-control" data-plugin="select2" style="width: 100%" required>
                        <option value="">Seçiniz...</option>
                        <option value="1" <?php echo $okul->durum == 1 ? "selected" : ""; ?>>Aktif</option>
                        <option value="0" <?php echo $okul->durum == 0 ? "selected" : ""; ?>>Pasif</option>
                    </select>
                </div>
                <div class="form-group pull-right">
                    <input type="submit" id="submit_button" name="submit" value="Güncelle" class="btn btn-success"/>
                    <a href="<?php echo site_url('okullar/index'); ?>" class="btn btn-danger">İptal</a>
                </div>
            </div><!-- .widget-body -->
        </div><!-- .widget -->
    </div>
    <?php echo form_close(); ?>

    <!-- END column -->
</div>
