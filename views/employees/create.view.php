<div class="content">
    <div class="container">
        <h2 class="page-title">Add New Employee</h2>
        <form method="POST" action="/employees/store" enctype="multipart/form-data">
            <!-- Include form fields -->
            <?php include 'form_fields.view.php'; ?>
            
            <!-- Image Upload Field -->
            <div class="mb-3">
                <label for="image" class="form-label">Profile Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="form-text text-muted">Allowed formats: JPG, JPEG, PNG. Max size: 2MB.</small>
            </div>
            
            <button type="submit" class="btn btn-primary">Save Employee</button>
        </form>
    </div>
</div>
