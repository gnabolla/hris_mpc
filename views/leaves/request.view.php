<div class="content">
    <div class="container">
        <h2 class="page-title">Request Leave</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger text-start">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="POST" action="/leaves/request">
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($_POST['start_date'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($_POST['end_date'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="reason" class="form-label">Reason for Leave</label>
                <textarea name="reason" class="form-control" rows="4" required><?= htmlspecialchars($_POST['reason'] ?? '') ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Request</button>
        </form>
    </div>
</div>
