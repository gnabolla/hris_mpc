<div class="content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="page-title">Attendance Logs</h2>
            </div>
        </div>

        <!-- Date Filter Form -->
        <form method="GET" action="/attendance_logs" class="row mb-4">
            <div class="col-md-3">
                <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($date) ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter by Date</button>
            </div>
        </form>

        <!-- Attendance Logs Table -->
        <div class="card">
            <div class="card-header">Attendance Logs for <?= htmlspecialchars($date) ?></div>
            <div class="card-body">
                <?php if (!empty($attendance_logs)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Event Type</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($attendance_logs as $log): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?= !empty($log['image_path']) ? htmlspecialchars($log['image_path']) : '/assets/img/default_avatar.png' ?>" alt="Profile Image" class="img-thumbnail" width="50">
                                                <span class="ms-2"><?= htmlspecialchars($log['full_name']) ?></span>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $log['event_type']))) ?></td>
                                        <td><?= htmlspecialchars(date('Y-m-d H:i:s', strtotime($log['timestamp']))) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>No attendance logs found for this date.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
