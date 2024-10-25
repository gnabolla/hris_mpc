<div class="content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h1 class="display-4">Attendance System</h1>
                <p class="lead">Please scan your RFID card to clock in.</p>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Scanning UI and Live Clock -->
            <div class="col-md-4 col-lg-4 mb-4">
                <div class="card shadow-lg mb-4">
                    <div class="card-body text-center">
                        <h3 class="card-title mb-4"><i class="fas fa-id-card-alt"></i> Scan Your RFID Card</h3>
                        <form id="attendance-form" method="POST" action="/attendance/log">
                            <input type="text" id="rfid-input" name="rfid" class="form-control form-control-lg text-center" autofocus autocomplete="off" placeholder="Scan RFID here..." style="height: 60px; font-size: 1.5rem;" />
                        </form>
                        <div id="attendance-message" class="mt-3"></div>
                    </div>
                </div>
                <div class="card shadow-lg">
                    <div class="card-body text-center">
                        <h4 class="card-title mb-3"><i class="fas fa-clock"></i> Current Date and Time</h4>
                        <div id="live-clock" class="display-6 text-primary"></div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Recently Tapped Employee and List of Clocked-In Employees -->
            <div class="col-md-8 col-lg-8 mb-4">
                <!-- Recently Tapped Employee -->
                <div class="card shadow-lg mb-4">
                    <div class="card-body text-center">
                        <h4 class="card-title mb-3"><i class="fas fa-user-check"></i> Welcome!</h4>
                        <div id="recent-employee">
                            <!-- This section will be updated via JavaScript when an employee taps in -->
                            <p class="text-muted">Awaiting scan...</p>
                        </div>
                    </div>
                </div>

                <!-- List of Clocked-In Employees -->
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-users"></i> Employees Clocked In Today</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row" id="clocked-in-employees">
                            <!-- Content will be dynamically loaded via JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Clock Script -->
    <script>
        function updateClock() {
            const clockElement = document.getElementById('live-clock');
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            clockElement.textContent = now.toLocaleDateString('en-US', options);
        }

        setInterval(updateClock, 1000); // Update every second
        updateClock(); // Initial call
    </script>

    <!-- AJAX for RFID Submission and Real-Time Updates -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rfidInput = document.getElementById('rfid-input');
            const attendanceForm = document.getElementById('attendance-form');
            const messageDiv = document.getElementById('attendance-message');
            const recentEmployeeDiv = document.getElementById('recent-employee');
            const clockedInEmployeesContainer = document.getElementById('clocked-in-employees');

            // Focus the input field on page load
            rfidInput.focus();

            // Initial load of clocked-in employees
            refreshClockedInEmployees();

            // Listen for Enter key to submit the form
            rfidInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    submitRFID();
                }
            });

            function submitRFID() {
                const rfid = rfidInput.value.trim();
                if (rfid === '') {
                    showMessage('Please scan your RFID card.', 'danger');
                    return;
                }

                // Send AJAX request
                fetch('/attendance/log', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({
                        'rfid': rfid
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        showMessage(data.message, 'success');
                        displayRecentEmployee(data.employee);
                        refreshClockedInEmployees();
                    } else {
                        showMessage(data.message, 'danger');
                    }
                    rfidInput.value = '';
                    rfidInput.focus();
                })
                .catch(error => {
                    showMessage('An error occurred while recording attendance.', 'danger');
                    console.error('Error:', error);
                });
            }

            function showMessage(message, type) {
                messageDiv.innerHTML = `<div class="alert alert-${type}" role="alert">${message}</div>`;
                // Automatically hide the message after 5 seconds
                setTimeout(() => {
                    messageDiv.innerHTML = '';
                }, 5000);
            }

            function displayRecentEmployee(employee) {
                const imagePath = employee.image_path ? escapeHtml(employee.image_path) : '/assets/img/default_avatar.png';
                const html = `
                    <div class="d-flex align-items-center flex-column">
                        <img src="${imagePath}" alt="Employee Image" class="img-thumbnail mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                        <h3>${escapeHtml(employee.full_name)}</h3>
                        <p class="text-muted">Clock-In Time: ${escapeHtml(employee.clock_in_time)}</p>
                    </div>
                `;
                recentEmployeeDiv.innerHTML = html;
            }

            // Function to refresh the list of clocked-in employees
            function refreshClockedInEmployees() {
                fetch('/attendance/clocked_in')
                    .then(response => response.json())
                    .then(data => {
                        // Clear the container before adding new content
                        clockedInEmployeesContainer.innerHTML = '';
                        
                        if (data.clocked_in_employees && data.clocked_in_employees.length > 0) {
                            data.clocked_in_employees.forEach(employee => {
                                const cardHTML = `
                                    <div class="col-md-4 col-lg-3 mb-4">
                                        <div class="card h-100">
                                            <img src="${employee.image_path ? escapeHtml(employee.image_path) : '/assets/img/default_avatar.png'}" class="card-img-top" alt="Employee Image" style="height: 150px; object-fit: cover;">
                                            <div class="card-body text-center">
                                                <h6 class="card-title mb-0">${escapeHtml(employee.full_name)}</h6>
                                                <small class="text-muted">${escapeHtml(employee.clock_in_time)}</small>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                clockedInEmployeesContainer.innerHTML += cardHTML;
                            });
                        } else {
                            clockedInEmployeesContainer.innerHTML = '<p class="text-center">No employees have clocked in yet.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching clocked-in employees:', error);
                        clockedInEmployeesContainer.innerHTML = '<p class="text-center text-danger">Error loading clocked-in employees.</p>';
                    });
            }

            // Function to escape HTML to prevent XSS
            function escapeHtml(text) {
                var map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return text.replace(/[&<>"']/g, function(m) {
                    return map[m];
                });
            }

            // Set up periodic refresh of clocked-in employees (every 30 seconds)
            setInterval(refreshClockedInEmployees, 30000);
        });
    </script>
</div>