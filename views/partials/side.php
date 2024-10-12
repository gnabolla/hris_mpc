<!-- sidebar navigation component -->
<nav id="sidebar" class="active">
    <div class="sidebar-header">
        <img src="/assets/img/bootstraper-logo.png" alt="bootraper logo" class="app-logo">
    </div>
    <ul class="list-unstyled components text-secondary">
        <li>
            <a href="/"><i class="fas fa-home"></i> Dashboard</a>
        </li>
        <?php if (hasRole('admin')): ?>
            <li>
                <a href="#employeemenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-user-shield"></i> Employee Management</a>
                <ul class="collapse list-unstyled" id="employeemenu">
                    <li>
                        <a href="/employees"><i class="fas fa-users"></i> Employee Management</a>
                    </li>
                    <li>
                        <a href="/leaves/manage"><i class="fas fa-calendar"></i> Manage Leave Requests</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/attendance_logs">
                    <i class="fas fa-clock"></i> Attendance Logs
                </a>
            </li>
            <li class="nav-item">
                <a href="/users" class="nav-link"><i class="fas fa-user-friends"></i> Users</a>
            </li>
            <li>
                <a href="/settings"><i class="fas fa-cog"></i> Settings</a>
            </li>
        <?php elseif (hasRole('employee')): ?>

            <li>
                <a href="#leavemenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-calendar-check"></i> Leave</a>
                <ul class="collapse list-unstyled" id="leavemenu">

                    <li class="nav-item">
                        <a href="/leaves/request" class="nav-link"><i class="fas fa-calendar-plus"></i> Request Leave</a>
                    </li>
                    <li>
                        <a href="/leaves/list"><i class="fas fa-calendar-alt"></i>My Leave Requests</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="/employees/profile" class="nav-link"><i class="fas fa-user"></i> My Profile</a>
            </li>
            <li class="nav-item">
                <a href="/employees/update_profile" class="nav-link"><i class="fas fa-edit"></i> Update Profile</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>