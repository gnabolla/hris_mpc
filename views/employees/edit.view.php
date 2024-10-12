<div class="content">
    <div class="container">
        <h2 class="page-title">Edit Employee</h2>
        <form method="POST" action="/employees/update" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $employee['id'] ?>">
            <!-- Include form fields with pre-filled values -->
            <?php include 'form_fields.view.php'; ?>
            
            <!-- Display Current Image -->
            <?php if (!empty($employee['image_path'])): ?>
                <div class="mb-3">
                    <label class="form-label">Current Profile Image</label><br>
                    <img src="<?= htmlspecialchars($employee['image_path']) ?>" alt="Profile Image" class="img-thumbnail" width="150">
                </div>
            <?php endif; ?>
            
            <!-- Image Upload Field -->
            <div class="mb-3">
                <label for="image" class="form-label">Change Profile Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="form-text text-muted">Leave blank to keep the current image. Allowed formats: JPG, JPEG, PNG. Max size: 2MB.</small>
            </div>
            
            <button type="submit" class="btn btn-primary">Update Employee</button>
        </form>
    </div>
</div>
