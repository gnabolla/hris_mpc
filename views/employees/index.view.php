<div class="page-title">
    <h2 class="page-title">Employee Management</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add New Employee</button>
    <div class="col-md-3">
        <form method="GET" action="/employees" class="mb-3 d-flex">
            <input type="text" class="form-control me-2" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Search...">
            <button type="submit" class="btn btn-secondary">Search</button>
        </form>
    </div>
</div>

<!-- Employee Table -->


<div class="card">
    <div class="card-header">Employee List</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Employee ID</th>
                        <th>RFID Code</th>
                        <th>Full Name</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Employment Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td>
                                <?php if (!empty($employee['image_path'])): ?>
                                    <img src="<?= htmlspecialchars($employee['image_path']) ?>" alt="Profile Image" class="img-thumbnail" width="50">
                                <?php else: ?>
                                    <img src="/assets/img/default_avatar.png" alt="Default Image" class="img-thumbnail" width="50">
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($employee['employee_id']) ?></td>
                            <td><?= htmlspecialchars($employee['rfid'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($employee['full_name']) ?></td>
                            <td><?= htmlspecialchars($employee['department']) ?></td>
                            <td><?= htmlspecialchars($employee['position']) ?></td>
                            <td><?= htmlspecialchars($employee['employment_status']) ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn" data-id="<?= $employee['id'] ?>">Edit</button>
                                <form method="POST" action="/employees/delete" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $employee['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($employees)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No employees found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <!-- Add enctype attribute for file upload -->
        <form method="POST" action="/employees/store" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php $employee = []; // Empty array for new employee ?>
                    <?php include 'form_fields.view.php'; ?>

                    <!-- Image Upload Field -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Profile Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Allowed formats: JPG, JPEG, PNG. Max size: 2MB.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Employee</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <!-- Add enctype attribute -->
        <form method="POST" action="/employees/update" enctype="multipart/form-data">
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php include 'form_fields.view.php'; ?>

                    <!-- Display Current Image -->
                    <div class="mb-3">
                        <label class="form-label">Current Profile Image</label><br>
                        <img id="current-image" src="" alt="Profile Image" class="img-thumbnail" width="150">
                    </div>

                    <!-- Image Upload Field -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Change Profile Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="form-text text-muted">Leave blank to keep the current image. Allowed formats: JPG, JPEG, PNG. Max size: 2MB.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Employee</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- JavaScript to handle Edit button clicks -->
<script>
    $(document).ready(function() {
    $('.edit-btn').click(function() {
        var id = $(this).data('id');
        // Load employee data via AJAX
        $.ajax({
            url: '/employees/get?id=' + id,
            method: 'GET',
            dataType: 'json',
            success: function(employee) {
                console.log('Employee data received:', employee);
                try {
                    // Populate the form fields
                    $('#edit-id').val(employee.id);
                    $('#editEmployeeModal input[name="full_name"]').val(employee.full_name);
                    $('#editEmployeeModal input[name="employee_id"]').val(employee.employee_id);
                    $('#editEmployeeModal input[name="date_of_birth"]').val(employee.date_of_birth);
                    $('#editEmployeeModal input[name="contact_information"]').val(employee.contact_information);
                    $('#editEmployeeModal input[name="position"]').val(employee.position);
                    $('#editEmployeeModal input[name="department"]').val(employee.department);
                    $('#editEmployeeModal input[name="date_of_hire"]').val(employee.date_of_hire);
                    $('#editEmployeeModal select[name="employment_status"]').val(employee.employment_status);
                    $('#editEmployeeModal input[name="salary"]').val(employee.salary);
                    $('#editEmployeeModal input[name="bank_account_details"]').val(employee.bank_account_details);
                    $('#editEmployeeModal input[name="emergency_contact"]').val(employee.emergency_contact);
                    $('#editEmployeeModal input[name="rfid"]').val(employee.rfid);

                    // Set the current image
                    if (employee.image_path && employee.image_path !== '') {
                        $('#current-image').attr('src', employee.image_path);
                    } else {
                        $('#current-image').attr('src', '/assets/img/default_avatar.png');
                    }

                    // Show the modal
                    $('#editEmployeeModal').modal('show');
                } catch (e) {
                    console.error('Error processing employee data:', e);
                    alert('An error occurred while processing employee data.');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('Failed to fetch employee data.');
            }
        });
    });
});


</script>