<div class="content">
    <div class="container">
        <div class="col-md-12 page-header">
            <div class="page-title">
                <h3>Edit User</h3>
            </div>
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="box box-primary">
                <div class="box-body">
                    <form method="POST" action="/users/edit?id=<?= htmlspecialchars($user['id']) ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" class="form-control" required>
                                <option value="employee" <?= ($user['role'] === 'employee') ? 'selected' : '' ?>>Employee</option>
                                <option value="admin" <?= ($user['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </div>
                        <!-- Removed Employee ID Field -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="Active" <?= ($user['status'] === 'Active') ? 'selected' : '' ?>>Active</option>
                                <option value="Disabled" <?= ($user['status'] === 'Disabled') ? 'selected' : '' ?>>Disabled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                        </div>
                        <button type="submit" class="btn btn-primary">Update User</button>
                        <a href="/users" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
