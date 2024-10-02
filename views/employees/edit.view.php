<div class="content">
    <div class="container">
        <h2 class="page-title">Edit Employee</h2>
        <form method="POST" action="/employees/update">
            <input type="hidden" name="id" value="<?= $employee['id'] ?>">
            <!-- Include form fields with pre-filled values -->
            <?php include 'form_fields.php'; ?>
            <button type="submit" class="btn btn-primary">Update Employee</button>
        </form>
    </div>
</div>
