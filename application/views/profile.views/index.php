<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="row mt-sm-4">
	<div class="col-12 col-md-12 col-lg-4">
		<div class="card author-box">
			<div class="card-body">
				<div class="author-box-center">
					<img alt="image" src="<?php echo base_url("assets"); ?>/img/Kullanici.png" class="rounded-circle author-box-picture">
					<div class="clearfix"></div>
					<div class="author-box-name">
						<a href="#">
							<?php echo $this->ion_auth->user()->row()->first_name . " " . $this->ion_auth->user()->row()->last_name; ?>
						</a>
					</div>
					<div class="author-box-job">
						<?php echo $this->ion_auth->is_admin() ? "Sistem Yöneticisi" : "Kullanıcı"; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h4>Kişisel Bilgieriniz</h4>
			</div>
			<div class="card-body">
				<div class="py-4">
					<p class="clearfix">
						<span class="float-left">
							Kurum
						</span>
						<span class="float-right text-muted">
							<?php echo $this->ion_auth->user()->row()->company; ?>
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
							Ünvan
						</span>
						<span class="float-right text-muted">
							<?php echo $this->ion_auth->is_admin() ? "Sistem Yöneticisi" : "Kullanıcı"; ?>
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
							E-posta
						</span>
						<span class="float-right text-muted">
							<?php echo $this->ion_auth->user()->row()->email; ?>
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
							Telefon
						</span>
						<span class="float-right text-muted">
							<?php echo $this->ion_auth->user()->row()->phone; ?>
						</span>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-12 col-lg-8">
		<div class="card">
			<div class="padding-20">
				<ul class="nav nav-tabs" id="myTab2" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="profile-tab2" data-bs-toggle="tab" href="#settings" role="tab" aria-selected="false">Kişisel Bilgilerim</a>
					</li>
				</ul>
				<div class="tab-content tab-bordered" id="myTab3Content">
					<div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
						<?php echo validation_errors(); ?>
						<?php echo form_open(site_url('profile/update'), array('class' => 'needs-validation', 'method' => 'post')); ?>
						<input type="hidden" id="id" name="id" value="<?php echo $this->ion_auth->user()->row()->id; ?>">
						
						<div class="card-body mb-1">
							<div class="row">
								<div class="form-group col-md-6 col-12">
									<label>Ad</label>
									<input type="text" class="form-control" name="first_name" value="<?php echo $this->ion_auth->user()->row()->first_name; ?>">
									<div class="invalid-feedback">
										Zorunlu Alan
									</div>
								</div>
								<div class="form-group col-md-6 col-12">
									<label>Soyad</label>
									<input type="text" class="form-control" name="last_name" value="<?php echo $this->ion_auth->user()->row()->last_name; ?>">
									<div class="invalid-feedback">
										Zorunlu Alan
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-7 col-12">
									<label>Eposta</label>
									<input type="email" class="form-control" name="email" value="<?php echo $this->ion_auth->user()->row()->email; ?>">
									<div class="invalid-feedback">
										Zorunlu Alan
									</div>
								</div>
								<div class="form-group col-md-5 col-12">
									<label>Telefon</label>
									<input type="tel" class="form-control" name="phone" value="<?php echo $this->ion_auth->user()->row()->phone; ?>">
								</div>
							</div>
							<div class="row ">
								<div class="text-small font-weight-bold text-danger">
									Yukarıdaki bilgiler size ait değilse lütfen güncelleme işlemi yapınız.
								</div>
							</div>
						</div>
						<div class="card-footer text-end mt-0">
							<button type="submit" class="btn btn-primary">Kaydet</button>
							<a href="<?php echo site_url("welcome/index"); ?>" class="btn btn-danger">
								İptal
							</a>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>