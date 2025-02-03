<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?php echo site_url('welcome/index'); ?>">
                <img alt="image" src="<?php echo base_url("assets"); ?>/img/logo.png" class="header-logo" />
                <span class="logo-name">SAY</span>
            </a>
        </div>
        <!-- <div class="sidebar-user">
						<div class="sidebar-user-picture">
							<img alt="image" src="<?php echo base_url("assets"); ?>/img/Kullanici.png">
						</div>
						<div class="sidebar-user-details">
							<div class="user-name">
								<?php echo $this->ion_auth->user()->row()->first_name . " " . $this->ion_auth->user()->row()->last_name; ?>
							</div>
							<div class="user-role">
								<?php echo $this->ion_auth->is_admin() ? "Sistem Yöneticisi" : "Kullanıcı"; ?>
							</div>
						</div>
					</div> -->
        <ul class="sidebar-menu">
            <li class="menu-header">Menü</li>
            <li class="<?php echo $this->router->fetch_class() == 'welcome' ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo site_url('welcome/index'); ?>">
                    <i data-feather="file"></i><span>Anasayfa</span>
                </a>
            </li>

            <li class="dropdown <?php echo $this->router->fetch_class() == 'okullar' ? 'active' : ''; ?>">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="home"></i><span>Kurum İşlemleri</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="<?php echo site_url('okullar/index'); ?>">Kurum Tanımlama</a></li>
                    <!--                    <li><a class="nav-link" href="--><?php //echo site_url('welcome/index'); 
                                                                                ?><!--">Öğr. Kütük Güncelleme</a></li>-->
                </ul>
            </li>
            <!--            <li class="dropdown">-->
            <!--                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="command"></i><span>Apps</span></a>-->
            <!--                <ul class="dropdown-menu">-->
            <!--                    <li><a class="nav-link" href="chat.html">Chat</a></li>-->
            <!--                    <li><a class="nav-link" href="portfolio.html">Portfolio</a></li>-->
            <!--                    <li><a class="nav-link" href="blog.html">Blog</a></li>-->
            <!--                    <li><a class="nav-link" href="calendar.html">Calendar</a></li>-->
            <!--                    <li><a class="nav-link" href="drag-drop.html">Drag & Drop</a></li>-->
            <!--                </ul>-->
            <!--            </li>-->
            <!--            <li class="dropdown">-->
            <!--                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>Email</span></a>-->
            <!--                <ul class="dropdown-menu">-->
            <!--                    <li><a class="nav-link" href="email-inbox.html">Inbox</a></li>-->
            <!--                    <li><a class="nav-link" href="email-compose.html">Compose</a></li>-->
            <!--                    <li><a class="nav-link" href="email-read.html">read</a></li>-->
            <!--                </ul>-->
            <!--            </li>-->
            <li class="dropdown <?php echo $this->router->fetch_class() == 'sinavlar' ? 'active' : ''; ?>">
                <a href="#" class="menu-toggle nav-link has-dropdown">
                    <i data-feather="copy"></i><span>Sınav İşlemleri</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="<?php echo site_url('sinavlar/index'); ?>">Sınavlar</a></li>
                </ul>
            </li>
            <!--            <li class="dropdown">-->
            <!--                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="shopping-bag"></i><span>Advanced</span></a>-->
            <!--                <ul class="dropdown-menu">-->
            <!--                    <li><a class="nav-link" href="avatar.html">Avatar</a></li>-->
            <!--                    <li><a class="nav-link" href="card.html">Card</a></li>-->
            <!--                    <li><a class="nav-link" href="modal.html">Modal</a></li>-->
            <!--                    <li><a class="nav-link" href="sweet-alert.html">Sweet Alert</a></li>-->
            <!--                    <li><a class="nav-link" href="toastr.html">Toastr</a></li>-->
            <!--                    <li><a class="nav-link" href="empty-state.html">Empty State</a></li>-->
            <!--                    <li><a class="nav-link" href="multiple-upload.html">Multiple Upload</a></li>-->
            <!--                    <li><a class="nav-link" href="pricing.html">Pricing</a></li>-->
            <!--                    <li><a class="nav-link" href="tabs.html">Tab</a></li>-->
            <!--                </ul>-->
            <!--            </li>-->
            <li class="menu-header">Yönetici</li>
            <!--            <li class="dropdown">-->
            <!--                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="layout"></i><span>Forms</span></a>-->
            <!--                <ul class="dropdown-menu">-->
            <!--                    <li><a class="nav-link" href="basic-form.html">Basic Form</a></li>-->
            <!--                    <li><a class="nav-link" href="forms-advanced-form.html">Advanced Form</a></li>-->
            <!--                    <li><a class="nav-link" href="forms-editor.html">Editor</a></li>-->
            <!--                    <li><a class="nav-link" href="forms-validation.html">Validation</a></li>-->
            <!--                    <li><a class="nav-link" href="form-wizard.html">Form Wizard</a></li>-->
            <!--                </ul>-->
            <!--            </li>-->
            <!--            <li class="dropdown">-->
            <!--                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="grid"></i><span>Tables</span></a>-->
            <!--                <ul class="dropdown-menu">-->
            <!--                    <li><a class="nav-link" href="basic-table.html">Basic Tables</a></li>-->
            <!--                    <li><a class="nav-link" href="advance-table.html">Advanced Table</a></li>-->
            <!--                    <li><a class="nav-link" href="datatables.html">Datatable</a></li>-->
            <!--                    <li><a class="nav-link" href="export-table.html">Export Table</a></li>-->
            <!--                    <li><a class="nav-link" href="footable.html">Footable</a></li>-->
            <!--                    <li><a class="nav-link" href="editable-table.html">Editable Table</a></li>-->
            <!--                </ul>-->
            <!--            </li>-->
            <!--            <li class="dropdown">-->
            <!--                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="pie-chart"></i><span>Charts</span></a>-->
            <!--                <ul class="dropdown-menu">-->
            <!--                    <li><a class="nav-link" href="chart-amchart.html">amChart</a></li>-->
            <!--                    <li><a class="nav-link" href="chart-apexchart.html">apexchart</a></li>-->
            <!--                    <li><a class="nav-link" href="chart-echart.html">eChart</a></li>-->
            <!--                    <li><a class="nav-link" href="chart-chartjs.html">Chartjs</a></li>-->
            <!--                    <li><a class="nav-link" href="chart-sparkline.html">Sparkline</a></li>-->
            <!--                    <li><a class="nav-link" href="chart-morris.html">Morris</a></li>-->
            <!--                </ul>-->
            <!--            </li>-->
            <?php if ($this->ion_auth->is_admin()) { ?>
                <li class="dropdown <?php echo $this->router->fetch_class() == 'auth' ? 'active' : ''; ?>">
                    <a href="#" class="menu-toggle nav-link has-dropdown "><i data-feather="users"></i><span>Kullanıcılar</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="<?php echo site_url('auth/index'); ?>">Kullanıcılar</a></li>
                        <li><a class="nav-link" href="<?php echo site_url('auth/index'); ?>">Material Design</a></li>
                        <li><a class="nav-link" href="<?php echo site_url('auth/index'); ?>">Ion Icons</a></li>
                        <li><a class="nav-link" href="<?php echo site_url('auth/index'); ?>">Feather Icons</a></li>
                        <li><a class="nav-link" href="<?php echo site_url('auth/index'); ?>">Weather Icon</a></li>
                    </ul>
                </li>
            <?php } ?>
            <hr>
            <li>
                <a class="nav-link text-danger" href="<?php echo site_url('auth/logout'); ?>">
                    <i data-feather="file"></i><span>Güvenli Çıkış</span>
                </a>
            </li>
        </ul>
    </aside>
</div>