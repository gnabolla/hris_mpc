<!-- views/payslips/index.view.php -->
<div class="content">
    <div class="container-fluid">
        <h2>My Payslips</h2>

        <?php if (!empty($payslips)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Gross Pay</th>
                        <th>Deductions</th>
                        <th>Net Pay</th>
                        <th>Date Generated</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($payslips as $payslip): ?>
                        <tr>
                            <td><?= htmlspecialchars($payslip['period_start']) ?> - <?= htmlspecialchars($payslip['period_end']) ?></td>
                            <td><?= number_format($payslip['gross_pay'], 2) ?></td>
                            <td><?= number_format($payslip['deductions'], 2) ?></td>
                            <td><?= number_format($payslip['net_pay'], 2) ?></td>
                            <td><?= htmlspecialchars($payslip['created_at']) ?></td>
                            <td>
                                <!-- Add a Print link to /payslips/print?id=<payslip_id> -->
                                <a href="/payslips/print?id=<?= $payslip['id'] ?>" class="btn btn-sm btn-info">
                                    View/Print
                                </a>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">
                You have no payslips available.
            </div>
        <?php endif; ?>
    </div>
</div>