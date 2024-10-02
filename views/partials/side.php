<!-- sidebar navigation component -->
<nav id="sidebar" class="active">
    <div class="sidebar-header">
        <img src="/assets/img/bootstraper-logo.png" alt="bootraper logo" class="app-logo">
    </div>
    <ul class="list-unstyled components text-secondary">
        <li>
            <a href="/"><i class="fas fa-home"></i>Dashboard</a>
        </li>
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
            <li class="nav-item">
                <a href="/employees" class="nav-link"><i class="fas fa-users"></i> Employee Management</a>
            </li>

            <li>
                <a href="/settings"><i class="fas fa-cog"></i>Settings</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>