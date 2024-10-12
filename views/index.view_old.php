<?php
// Assuming $db is an instance of the Database class and session is already started

// Fetch total number of employees
$totalEmployees = $db->select('employees');
$totalEmployeesCount = count($totalEmployees);

// Fetch number of active employees
$activeEmployees = $db->select('employees', ['employment_status' => 'Full-time']);
$activeEmployeesCount = count($activeEmployees);

// Fetch number of pending leave requests
$pendingLeaves = $db->select('leave_requests', ['status' => 'Pending']);
$pendingLeavesCount = count($pendingLeaves);

// Fetch number of approved leave requests
$approvedLeaves = $db->select('leave_requests', ['status' => 'Approved']);
$approvedLeavesCount = count($approvedLeaves);

// Fetch employee distribution by department over time (for simplicity, current distribution)
$departmentCounts = array_count_values(array_map(function($emp) {
    return $emp['department'];
}, $totalEmployees));

// Fetch latest leave requests for overview
$latestLeaves = $db->query("SELECT lr.*, e.full_name FROM leave_requests lr JOIN employees e ON lr.employee_id = e.id ORDER BY lr.created_at DESC LIMIT 10")->fetchAll();
?>

<div class="row">
    <div class="col-md-12 page-header">
        <div class="page-pretitle">Dashboard</div>
        <h2 class="page-title">HRIS of MPC Inc.</h2>
    </div>
</div>
<div class="row">
    <!-- Total Employees Card -->
    <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="icon-big text-center">
                            <i class="blue fas fa-users"></i>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="detail">
                            <p class="detail-subtitle">Total Employees</p>
                            <span class="number"><?= htmlspecialchars($totalEmployeesCount) ?></span>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="fas fa-users"></i> All Employees
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Active Employees Card -->
    <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="icon-big text-center">
                            <i class="green fas fa-user-check"></i>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="detail">
                            <p class="detail-subtitle">Active Employees</p>
                            <span class="number"><?= htmlspecialchars($activeEmployeesCount) ?></span>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="fas fa-user-check"></i> Currently Active
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pending Leave Requests Card -->
    <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="icon-big text-center">
                            <i class="orange fas fa-hourglass-half"></i>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="detail">
                            <p class="detail-subtitle">Pending Leave Requests</p>
                            <span class="number"><?= htmlspecialchars($pendingLeavesCount) ?></span>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="fas fa-hourglass-half"></i> Awaiting Approval
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Approved Leave Requests Card -->
    <div class="col-sm-6 col-md-6 col-lg-3 mt-3">
        <div class="card">
            <div class="content">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="icon-big text-center">
                            <i class="teal fas fa-check-circle"></i>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="detail">
                            <p class="detail-subtitle">Approve Leave Request</p>
                            <span class="number"><?= htmlspecialchars($approvedLeavesCount) ?></span>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <hr />
                    <div class="stats">
                        <i class="fas fa-check-circle"></i> Recently Approved
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="content">
                <h4 class="card-title">Recent Leave Requests</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Reason</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($latestLeaves as $leave): ?>
                                <tr>
                                    <td><?= htmlspecialchars($leave['full_name']) ?></td>
                                    <td><?= htmlspecialchars($leave['start_date']) ?></td>
                                    <td><?= htmlspecialchars($leave['end_date']) ?></td>
                                    <td><?= htmlspecialchars($leave['reason']) ?></td>
                                    <td>
                                        <?php if ($leave['status'] === 'Approved'): ?>
                                            <span class="badge bg-success">Approved</span>
                                        <?php elseif ($leave['status'] === 'Pending'): ?>
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Rejected</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($latestLeaves)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">No leave requests found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Additional Dashboard Components -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="content">
                <h4 class="card-title">Employee Distribution by Department</h4>
                <canvas id="departmentChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="content">
                <h4 class="card-title">Leave Requests Status</h4>
                <canvas id="leaveStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>
<!-- Leave Requests Overview -->


<!-- Chart Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Department Distribution Chart
    const departmentCtx = document.getElementById('departmentChart').getContext('2d');
    const departmentData = {
        labels: <?= json_encode(array_keys($departmentCounts)) ?>,
        datasets: [{
            label: 'Number of Employees',
            data: <?= json_encode(array_values($departmentCounts)) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    };

    const departmentChart = new Chart(departmentCtx, {
        type: 'bar',
        data: departmentData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision:0
                }
            }
        }
    });

    // Leave Status Chart
    const leaveStatusCtx = document.getElementById('leaveStatusChart').getContext('2d');
    const leaveStatusCounts = <?= json_encode(array_count_values(array_map(function($leave) { return $leave['status']; }, $db->select('leave_requests')))) ?>;

    const leaveStatusData = {
        labels: Object.keys(leaveStatusCounts),
        datasets: [{
            label: 'Leave Requests',
            data: Object.values(leaveStatusCounts),
            backgroundColor: [
                'rgba(255, 159, 64, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(255, 99, 132, 0.6)'
            ],
            borderColor: [
                'rgba(255, 159, 64, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    };

    const leaveStatusChart = new Chart(leaveStatusCtx, {
        type: 'pie',
        data: leaveStatusData,
        options: {
            responsive: true
        }
    });
</script>
