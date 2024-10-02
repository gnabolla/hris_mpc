<?php if ($employee): ?>
    <div class="content">
        <div class="container">
            <h2 class="page-title">My Profile</h2>
            <div class="card">
                <div class="card-body">
                    <p><strong>Full Name:</strong> <?= htmlspecialchars($employee['full_name']) ?></p>
                    <p><strong>Employee ID:</strong> <?= htmlspecialchars($employee['employee_id']) ?></p>
                    <p><strong>Date of Birth:</strong> <?= htmlspecialchars($employee['date_of_birth']) ?></p>
                    <p><strong>Contact Information:</strong> <?= htmlspecialchars($employee['contact_information']) ?></p>
                    <p><strong>Position:</strong> <?= htmlspecialchars($employee['position']) ?></p>
                    <p><strong>Department:</strong> <?= htmlspecialchars($employee['department']) ?></p>
                    <p><strong>Date of Hire:</strong> <?= htmlspecialchars($employee['date_of_hire']) ?></p>
                    <p><strong>Employment Status:</strong> <?= htmlspecialchars($employee['employment_status']) ?></p>
                    <p><strong>Salary:</strong> <?= htmlspecialchars($employee['salary']) ?></p>
                    <p><strong>Bank Account Details:</strong> <?= htmlspecialchars($employee['bank_account_details']) ?></p>
                    <p><strong>Emergency Contact:</strong> <?= htmlspecialchars($employee['emergency_contact']) ?></p>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="content">
        <div class="container">
            <h2 class="page-title">My Profile</h2>
            <div class="alert alert-danger">
                <p>Your profile information is not available. Please contact the HR department.</p>
            </div>
        </div>
    </div>
<?php endif; ?>
