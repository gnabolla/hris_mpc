<div class="content">
    <div class="container">
        <h2 class="page-title">Add New Employee</h2>
        <form method="POST" action="/employees/store">
            <!-- Include form fields -->
            <?php include 'form_fields.php'; ?>
            <button type="submit" class="btn btn-primary">Save Employee</button>
        </form>
    </div>
</div>
