<div class="row">
    <div class="col-md-6 mb-3">
        <label>Full Name</label>
        <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($employee['full_name'] ?? '') ?>" required>
    </div>
    <div class="col-md-6 mb-3">
        <label>Employee ID</label>
        <input type="text" name="employee_id" class="form-control" value="<?= htmlspecialchars($employee['employee_id'] ?? '') ?>" required>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label>Date of Birth</label>
        <input type="date" name="date_of_birth" class="form-control" value="<?= htmlspecialchars($employee['date_of_birth'] ?? '') ?>" required>
    </div>
    <div class="col-md-6 mb-3">
        <label>Date of Hire</label>
        <input type="date" name="date_of_hire" class="form-control" value="<?= htmlspecialchars($employee['date_of_hire'] ?? '') ?>" required>
    </div>
</div>

<div class="mb-3">
    <label>Contact Information</label>
    <input type="text" name="contact_information" class="form-control" value="<?= htmlspecialchars($employee['contact_information'] ?? '') ?>" required>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label>Position/Job Title</label>
        <input type="text" name="position" class="form-control" value="<?= htmlspecialchars($employee['position'] ?? '') ?>" required>
    </div>
    <div class="col-md-6 mb-3">
        <label>Department</label>
        <input type="text" name="department" class="form-control" value="<?= htmlspecialchars($employee['department'] ?? '') ?>" required>
    </div>
</div>

<div class="mb-3">
    <label>Employment Status</label>
    <select name="employment_status" class="form-control" required>
        <option value="">Select Status</option>
        <option value="Full-time" <?= (isset($employee['employment_status']) && $employee['employment_status'] == 'Full-time') ? 'selected' : '' ?>>Full-time</option>
        <option value="Part-time" <?= (isset($employee['employment_status']) && $employee['employment_status'] == 'Part-time') ? 'selected' : '' ?>>Part-time</option>
        <option value="Contractual" <?= (isset($employee['employment_status']) && $employee['employment_status'] == 'Contractual') ? 'selected' : '' ?>>Contractual</option>
    </select>
</div>

<div class="row">
<!-- Pay Type -->
<div class="mb-3">
    <label>Pay Type</label>
    <select name="pay_type" class="form-control" required>
        <option value="Monthly" <?= (isset($employee['pay_type']) && $employee['pay_type'] == 'Monthly') ? 'selected' : '' ?>>Monthly</option>
        <option value="Daily" <?= (isset($employee['pay_type']) && $employee['pay_type'] == 'Daily') ? 'selected' : '' ?>>Daily</option>
        <option value="Hourly" <?= (isset($employee['pay_type']) && $employee['pay_type'] == 'Hourly') ? 'selected' : '' ?>>Hourly</option>
    </select>
</div>

<!-- Salary or Pay Rate -->
<div class="mb-3">
    <label>Salary/Rate</label>
    <input type="number" step="0.01" name="salary" class="form-control" 
           value="<?= htmlspecialchars($employee['salary'] ?? '') ?>" required>
    <small class="text-muted">If Monthly, enter the monthly salary (e.g., 15000.00). 
    If Daily, enter the daily rate (e.g., 500.00). If Hourly, enter the hourly rate (e.g., 70.00).</small>
</div>

    <div class="mb-3">
        <label>Bank Account Details</label>
        <input type="text" name="bank_account_details" class="form-control" value="<?= htmlspecialchars($employee['bank_account_details'] ?? '') ?>" required>
    </div>
</div>

<div class="row">
<div class="col-md-6 mb-3">
    <label>Emergency Contact Information</label>
    <input type="text" name="emergency_contact" class="form-control" value="<?= htmlspecialchars($employee['emergency_contact'] ?? '') ?>" required>
</div>
<div class="col-md-6 mb-3">
    <label for="rfid" class="form-label">RFID Code</label>
    <input type="text" name="rfid" class="form-control" placeholder="Enter RFID code">
</div>
</div>
