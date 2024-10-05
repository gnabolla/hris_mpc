<div class="content">
    <div class="container">
        <h2 class="page-title">My Leave Requests</h2>
        
        <?php if (empty($leaveRequests)): ?>
            <div class="alert alert-info">
                <p>You have not submitted any leave requests yet.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Requested On</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leaveRequests as $leave): ?>
                            <tr>
                                <td><?= htmlspecialchars($leave['start_date']) ?></td>
                                <td><?= htmlspecialchars($leave['end_date']) ?></td>
                                <td><?= htmlspecialchars($leave['reason']) ?></td>
                                <td>
                                    <?php
                                        switch ($leave['status']) {
                                            case 'Approved':
                                                echo '<span class="badge bg-success">Approved</span>';
                                                break;
                                            case 'Rejected':
                                                echo '<span class="badge bg-danger">Rejected</span>';
                                                break;
                                            default:
                                                echo '<span class="badge bg-warning text-dark">Pending</span>';
                                        }
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($leave['created_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
