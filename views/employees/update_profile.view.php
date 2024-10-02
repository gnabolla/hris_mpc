<div class="content">
    <div class="container">
        <h2 class="page-title">Update My Profile</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger text-start">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="POST" action="/employees/update_profile">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Full Name</label>
                    <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($employee['full_name'] ?? '') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Contact Information</label>
                    <input type="text" name="contact_information" class="form-control" value="<?= htmlspecialchars($employee['contact_information'] ?? '') ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Position</label>
                    <input type="text" name="position" class="form-control" value="<?= htmlspecialchars($employee['position'] ?? '') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Department</label>
                    <input type="text" name="department" class="form-control" value="<?= htmlspecialchars($employee['department'] ?? '') ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Bank Account Details</label>
                <input type="text" name="bank_account_details" class="form-control" value="<?= htmlspecialchars($employee['bank_account_details'] ?? '') ?>" required>
            </div>

            <div class="mb-3">
                <label>Emergency Contact</label>
                <input type="text" name="emergency_contact" class="form-control" value="<?= htmlspecialchars($employee['emergency_contact'] ?? '') ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</div>
