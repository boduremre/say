<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar sticky">
    <div class="form-inline me-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="#" data-bs-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"> <i data-feather="menu"></i>
                </a>
            </li>
            <li>
                <form class="form-inline me-auto">
                    <div class="search-element d-flex">
                        <input class="form-control" type="search" placeholder="Ara" aria-label="Ara" data-width="200">
                        <button class="btn" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </li>
        </ul>
    </div>
    <ul class="navbar-nav navbar-right">
        <li>
            <a href="#" class="nav-link nav-link-lg fullscreen-btn" data-toggle="tooltip" title="Tam Ekran" data-bs-placement="bottom">
                <i data-feather="maximize"></i>
            </a>
        </li>
        <li class="dropdown">
            <a href="#" data-bs-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="<?php echo base_url("assets"); ?>/img/Kullanici.png" class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
                <div class="dropdown-title">
                    <?php echo $this->ion_auth->user()->row()->first_name . " " . $this->ion_auth->user()->row()->last_name; ?>
                </div>
                <a href="<?php echo site_url('profile'); ?>" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profil
                </a>
                <a href="#" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                    Activities
                </a>
                <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                    Ayarlar
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo site_url('auth/logout'); ?>" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    Çıkış
                </a>
            </div>
        </li>
    </ul>
</nav>