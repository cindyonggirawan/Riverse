<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    @include('admin.partials.logo')
    <!-- ./brand Logo -->

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-sort-numeric-down"></i>
                        <p>
                            Verification Table
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/waiting-for-verification/sukarelawans"
                                class="nav-link {{ $title === 'Waiting For Verification Sukarelawans' ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Sukarelawans</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/waiting-for-verification/fasilitators"
                                class="nav-link {{ $title === 'Waiting For Verification Fasilitators' ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Fasilitators</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/waiting-for-verification/activities"
                                class="nav-link {{ $title === 'Waiting For Verification Activities' ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Activities</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-sort-numeric-down"></i>
                        <p>
                            Benefit Table
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/benefits" class="nav-link {{ $title === 'Benefits' ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Benefits</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
