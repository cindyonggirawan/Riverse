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
                </li>

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-sort-numeric-down"></i>
                        <p>
                            Ordinal Table
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/users" class="nav-link {{ $title === 'Users' ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/sukarelawans" class="nav-link {{ $title === 'Sukarelawans' ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Sukarelawans</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/fasilitators" class="nav-link {{ $title === 'Fasilitators' ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Fasilitators</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/levels" class="nav-link {{ $title === 'Levels' ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Levels</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/benefits" class="nav-link {{ $title === 'Benefits' ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Benefits</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-sort-alpha-down"></i>
                        <p>
                            Categorical Table
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/roles" class="nav-link {{ $title === 'Roles' ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/fasilitator-types"
                                class="nav-link {{ $title === 'Fasilitator Types' ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Fasilitator Types</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/verification-statuses"
                                class="nav-link {{ $title === 'Verification Statuses' ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Verification Statuses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/activity-statuses"
                                class="nav-link {{ $title === 'Activity Statuses' ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Activity Statuses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/sukarelawan-statuses"
                                class="nav-link {{ $title === 'Sukarelawan Statuses' ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Sukarelawan Statuses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/experience-point-statuses"
                                class="nav-link {{ $title === 'Experience Point Statuses' ? 'active' : '' }}">
                                <i class="fas fa-table nav-icon"></i>
                                <p>Experience Point Statuses</p>
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
