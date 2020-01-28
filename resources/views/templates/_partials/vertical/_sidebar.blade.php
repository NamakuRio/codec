<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    <div class="slimscroll-menu">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
                <li class="menu-title">Navigasi</li>
                <li>
                    <a href="@route('admin.dashboard')">
                        <i class="fe-airplay"></i>
                        <span> Beranda </span>
                    </a>
                </li>
                <li>
                    <a href="@route('admin.account.index')">
                        <i class="fe-user"></i>
                        <span> Akun </span>
                    </a>
                </li>
                <li class="menu-title">Pengaturan</li>
                <li>
                    <a href="javascript: void(0);">
                        <i class="fe-users"></i>
                        <span> Kelola Pengguna </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-second-level nav" aria-expanded="false">
                        <li>
                            <a href="@route('admin.users.index')">
                                <span> Pengguna </span>
                            </a>
                        </li>
                        <li>
                            <a href="@route('admin.roles.index')">
                                <span> Peran </span>
                            </a>
                        </li>
                        <li>
                            <a href="@route('admin.permissions.index')">
                                <span> Izin </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="@route('admin.settings.index')">
                        <i class="fe-settings"></i>
                        <span> Pengaturan </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End -->
