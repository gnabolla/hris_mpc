<?php
// views/partials/side.php
?>
<!-- Sidebar navigation component -->
<nav id="sidebar" class="active">
    <div class="sidebar-header">
        <img src="<?= BASE_URL ?>/assets/img/bootstraper-logo.png" alt="bootstraper logo" class="app-logo">
    </div>
    <ul class="list-unstyled components text-secondary">
        <li>
            <a href="<?= BASE_URL ?>/"><i class="fas fa-home"></i> Dashboard</a>
        </li>

        <?php if (hasRole('admin')): ?>
            <!-- Admin-specific menu -->
            <li>
                <a href="#employeemenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down">
                    <i class="fas fa-user-shield"></i> Employee Management
                </a>
                <ul class="collapse list-unstyled" id="employeemenu">
                    <li>
                        <a href="<?= BASE_URL ?>/employees"><i class="fas fa-users"></i> Employee Management</a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/leaves/manage"><i class="fas fa-calendar"></i> Manage Leave Requests</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/attendance">
                    <i class="fas fa-user-check"></i> Attendance Scan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/attendance/logs">
                    <i class="fas fa-clock"></i> Attendance Logs
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= BASE_URL ?>/users" class="nav-link">
                    <i class="fas fa-user-friends"></i> Users
                </a>
            </li>
            <!-- Admin link to payroll -->
            <li>
                <a href="<?= BASE_URL ?>/payroll"><i class="fas fa-file-invoice-dollar"></i> Payroll</a>
            </li>
        <?php elseif (hasRole('employee')): ?>
            <!-- Employee-specific menu -->
            <li>
                <a href="#leavemenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down">
                    <i class="fas fa-calendar-check"></i> Leave
                </a>
                <ul class="collapse list-unstyled" id="leavemenu">
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>/leaves/request" class="nav-link">
                            <i class="fas fa-calendar-plus"></i> Request Leave
                        </a>
                    </li>
                    <li>
                        <a href="<?= BASE_URL ?>/leaves/list" class="nav-link">
                            <i class="fas fa-calendar-alt"></i> My Leave Requests
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="<?= BASE_URL ?>/employees/profile" class="nav-link">
                    <i class="fas fa-user"></i> My Profile
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= BASE_URL ?>/employees/update_profile" class="nav-link">
                    <i class="fas fa-edit"></i> Update Profile
                </a>
            </li>
            <!-- Employee link to My Payslips -->
            <li class="nav-item">
                <a href="<?= BASE_URL ?>/payslips" class="nav-link">
                    <i class="fas fa-money-bill-alt"></i> My Payslips
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
