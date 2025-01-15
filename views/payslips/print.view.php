<!-- views/payslips/print.view.php -->
<div class="payslip-container">
  <div class="payslip-header">
    <h1>Mallig Plains Colleges Inc.</h1>
    <h2>Payslip</h2>
  </div>

  <p><span class="field-label">Employee:</span> 
    <?= htmlspecialchars($payslip['full_name']) ?>
  </p>
  <p><span class="field-label">Period:</span> 
    <?= htmlspecialchars($payslip['period_start']) ?> 
    to <?= htmlspecialchars($payslip['period_end']) ?>
  </p>
  <p><span class="field-label">Gross Pay:</span> 
    <?= number_format($payslip['gross_pay'], 2) ?>
  </p>
  <p><span class="field-label">Deductions:</span> 
    <?= number_format($payslip['deductions'], 2) ?>
  </p>
  <p><span class="field-label">Net Pay:</span> 
    <?= number_format($payslip['net_pay'], 2) ?>
  </p>
  <p><span class="field-label">Date Generated:</span> 
    <?= htmlspecialchars($payslip['created_at']) ?>
  </p>

  <!-- Print Button (visible only on screen, hidden in print) -->
  <button class="no-print" onclick="window.print();">Print This Payslip</button>
</div>
