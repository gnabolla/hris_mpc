<div class="content">
    <div class="container">
        <h2 class="page-title">Manage Leave Requests</h2>
        <div class="col-md-3 mb-3">
            <form method="GET" action="/leaves/manage" class="d-flex">
                <input type="text" class="form-control me-2" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Search by Name or Employee ID">
                <button type="submit" class="btn btn-secondary">Search</button>
            </form>
        </div>

        <div class="card">
            <div class="card-header">Leave Requests</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Requested On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leaves as $leave): ?>
                                <tr>
                                    <td><?= htmlspecialchars($leave['employee_id']) ?></td>
                                    <td><?= htmlspecialchars($leave['full_name']) ?></td>
                                    <td><?= htmlspecialchars($leave['start_date']) ?></td>
                                    <td><?= htmlspecialchars($leave['end_date']) ?></td>
                                    <td><?= htmlspecialchars($leave['reason']) ?></td>
                                    <td><?= htmlspecialchars($leave['status']) ?></td>
                                    <td><?= htmlspecialchars($leave['created_at']) ?></td>
                                    <td>
                                        <?php if ($leave['status'] === 'Pending'): ?>
                                            <form method="POST" action="/leaves/approve" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= $leave['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                            </form>
                                            <form method="POST" action="/leaves/reject" style="display:inline;">
                                                <input type="hidden" name="id" value="<?= $leave['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                            </form>
                                        <?php else: ?>
                                            <span>N/A</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($leaves)): ?>
                                <tr>
                                    <td colspan="8" class="text-center">No leave requests found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
