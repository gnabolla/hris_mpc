<!-- views/payslips/admin.view.php -->
<div class="content">
  <div class="container-fluid">
    <h2>Payroll for <?= htmlspecialchars($year . '-' . $month) ?></h2>

        <!-- Button or link to generate payroll for current month. 
         Optionally, your filter form might change year/month. -->
         <a href="/payroll/generate?year=<?= $year ?>&month=<?= $month ?>" 
       class="btn btn-success mb-3">
       Generate Payslips Now
    </a>


    <!-- Optional filter form for different months -->
    <form method="GET" action="/payroll" class="row mb-3">
      <div class="col-md-2">
        <input type="number" name="year" class="form-control" placeholder="Year" value="<?= htmlspecialchars($year) ?>">
      </div>
      <div class="col-md-2">
        <input type="number" name="month" class="form-control" placeholder="Month" value="<?= htmlspecialchars($month) ?>">
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Filter</button>
      </div>
    </form>

    <?php if (!empty($payroll)): ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Employee</th>
            <th>Employee ID</th>
            <th>Period</th>
            <th>Gross Pay</th>
            <th>Deductions</th>
            <th>Net Pay</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($payroll as $row): ?>
            <tr>
              <td><?= htmlspecialchars($row['full_name']) ?></td>
              <td><?= htmlspecialchars($row['employee_id']) ?></td>
              <td><?= htmlspecialchars($row['period_start'] . ' - ' . $row['period_end']) ?></td>
              <td><?= number_format($row['gross_pay'], 2) ?></td>
              <td><?= number_format($row['deductions'], 2) ?></td>
              <td><?= number_format($row['net_pay'], 2) ?></td>
              <td><?= htmlspecialchars($row['created_at']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="alert alert-info">
        No payroll records found for this period.
      </div>
    <?php endif; ?>
  </div>
</div>
