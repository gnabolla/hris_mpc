<?php
// We have $payslips from the controller, plus a form to specify the period
?>
<div class="row">
    <div class="col-md-12">
        <h1>Payroll Generation</h1>
    </div>
</div>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<div class="row mt-3">
    <div class="col-md-6">
        <!-- Form to generate payroll -->
        <form method="POST" action="/payroll/generate">
            <div class="mb-3">
                <label for="period_start" class="form-label">Start Date</label>
                <input type="date" class="form-control" name="period_start" required />
            </div>
            <div class="mb-3">
                <label for="period_end" class="form-label">End Date</label>
                <input type="date" class="form-control" name="period_end" required />
            </div>
            <button class="btn btn-primary" type="submit">Generate Payroll</button>
        </form>
    </div>
</div>

<hr />

<div class="row">
    <div class="col-md-12">
        <h2>Recent Payslips</h2>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Period</th>
                        <th>Days</th>
                        <th>Hours</th>
                        <th>Gross Pay</th>
                        <th>Deductions</th>
                        <th>Net Pay</th>
                        <th>Lates</th>
                        <th>Late Deductions</th>
                        <th>Pay Type</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($payslips)): ?>
                        <?php foreach ($payslips as $index => $p): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($p['full_name']) ?></td>
                                <td>
                                    <?= htmlspecialchars($p['period_start']) ?>
                                    to
                                    <?= htmlspecialchars($p['period_end']) ?>
                                </td>
                                <td><?= htmlspecialchars($p['total_days']) ?></td>
                                <td><?= htmlspecialchars($p['total_hours']) ?></td>
                                <td><?= number_format($p['gross_pay'], 2) ?></td>
                                <td><?= number_format($p['deductions'], 2) ?></td>
                                <td><?= number_format($p['net_pay'], 2) ?></td>
                                <td><?= htmlspecialchars($p['total_lates']) ?></td>
                                <td><?= number_format($p['late_deductions'], 2) ?></td>
                                <td><?= htmlspecialchars($p['pay_type']) ?></td>
                                <td><?= htmlspecialchars($p['created_at']) ?></td>
                                <td>
                                    <a href="/payroll/print?id=<?= $p['id'] ?>" class="btn btn-sm btn-secondary">
                                        View/Print
                                    </a>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="12" class="text-center">No payslips found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>