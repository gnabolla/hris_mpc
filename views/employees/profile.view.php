<?php if ($employee): ?>
    <div class="content">
        <div class="container-fluid">
            <h2 class="page-title">My Dashboard</h2>
            
            <!-- Profile Header -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <?php if (!empty($employee['image_path'])): ?>
                                <img src="<?= htmlspecialchars($employee['image_path']) ?>" alt="Profile Image" class="img-thumbnail mb-3" width="150">
                            <?php else: ?>
                                <img src="/assets/img/default_avatar.png" alt="Profile Image" class="img-thumbnail mb-3" width="150">
                            <?php endif; ?>
                            <h4 class="card-title"><?= htmlspecialchars($employee['full_name']) ?></h4>
                            <p class="card-text"><?= htmlspecialchars($employee['position']) ?> - <?= htmlspecialchars($employee['department']) ?></p>
                        </div>
                    </div>
                </div>
                
                <!-- Key Metrics Cards -->
                <div class="col-md-8">
                    <div class="row">
                        <!-- Latest Leave Application -->
                        <div class="col-sm-6 mb-3">
                            <div class="card text-white bg-info">
                                <div class="card-body">
                                    <h5 class="card-title">Latest Leave Request</h5>
                                    <?php if ($latestLeave): ?>
                                        <p class="card-text">
                                            <strong>Type:</strong> <?= htmlspecialchars($latestLeave['reason']) ?><br>
                                            <strong>Status:</strong> 
                                            <?php if ($latestLeave['status'] === 'Approved'): ?>
                                                <span class="badge bg-success">Approved</span>
                                            <?php elseif ($latestLeave['status'] === 'Pending'): ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Rejected</span>
                                            <?php endif; ?>
                                        </p>
                                        <p class="card-text"><small><?= date('F d, Y', strtotime($latestLeave['created_at'])) ?></small></p>
                                    <?php else: ?>
                                        <p class="card-text">No leave requests found.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Today's Attendance Status -->
                        <div class="col-sm-6 mb-3">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Today's Attendance</h5>
                                    <p class="card-text">
                                        <strong>Status:</strong> 
                                        <?php if ($attendanceStatus === 'Absent'): ?>
                                            <span class="badge bg-danger">Absent</span>
                                        <?php elseif ($attendanceStatus === 'Present (Not Clocked Out)'): ?>
                                            <span class="badge bg-warning">Present (Not Clocked Out)</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Present</span>
                                        <?php endif; ?>
                                    </p>
                                    <?php if ($todayAttendance['clock_in']): ?>
                                        <p class="card-text">
                                            <strong>Clock In:</strong> <?= date('h:i A', strtotime($todayAttendance['clock_in'])) ?><br>
                                            <?php if ($todayAttendance['clock_out']): ?>
                                                <strong>Clock Out:</strong> <?= date('h:i A', strtotime($todayAttendance['clock_out'])) ?>
                                            <?php else: ?>
                                                <strong>Clock Out:</strong> Not Clocked Out
                                            <?php endif; ?>
                                        </p>
                                    <?php else: ?>
                                        <p class="card-text">You have not clocked in today.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Additional Metrics (Optional) -->
                        <div class="col-sm-6 mb-3">
                            <div class="card text-white bg-success">
                                <div class="card-body">
                                    <h5 class="card-title">Total Leaves Taken</h5>
                                    <p class="card-text"><?= htmlspecialchars($totalLeaves) ?> Days</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="card text-white bg-secondary">
                                <div class="card-body">
                                    <h5 class="card-title">Pending Leaves</h5>
                                    <p class="card-text"><?= htmlspecialchars($pendingLeaves) ?> Requests</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Detailed Tables -->
            <div class="row">
                <!-- Attendance History -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Attendance History (Last 30 Days)</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Clock In</th>
                                            <th>Clock Out</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Organize attendance by date
                                        $attendanceByDate = [];
                                        foreach ($attendanceHistory as $log) {
                                            $date = date('F d, Y', strtotime($log['date']));
                                            if (!isset($attendanceByDate[$date])) {
                                                $attendanceByDate[$date] = ['clock_in' => null, 'clock_out' => null];
                                            }
                                            if ($log['event_type'] === 'clock_in') {
                                                $attendanceByDate[$date]['clock_in'] = date('h:i A', strtotime($log['timestamp']));
                                            } elseif ($log['event_type'] === 'clock_out') {
                                                $attendanceByDate[$date]['clock_out'] = date('h:i A', strtotime($log['timestamp']));
                                            }
                                        }

                                        foreach ($attendanceByDate as $date => $times):
                                            if (!$times['clock_in']) {
                                                $status = '<span class="badge bg-danger">Absent</span>';
                                            } elseif (!$times['clock_out']) {
                                                $status = '<span class="badge bg-warning">Present (Not Clocked Out)</span>';
                                            } else {
                                                $status = '<span class="badge bg-success">Present</span>';
                                            }
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($date) ?></td>
                                                <td><?= htmlspecialchars($times['clock_in'] ?? '-') ?></td>
                                                <td><?= htmlspecialchars($times['clock_out'] ?? '-') ?></td>
                                                <td><?= $status ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (empty($attendanceByDate)): ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No attendance records found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Leave History -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Leave History (Last 10 Requests)</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Reason</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($leaveHistory as $leave): ?>
                                            <tr>
                                                <td><?= htmlspecialchars(date('F d, Y', strtotime($leave['start_date']))) ?></td>
                                                <td><?= htmlspecialchars(date('F d, Y', strtotime($leave['end_date']))) ?></td>
                                                <td><?= htmlspecialchars($leave['reason']) ?></td>
                                                <td>
                                                    <?php if ($leave['status'] === 'Approved'): ?>
                                                        <span class="badge bg-success">Approved</span>
                                                    <?php elseif ($leave['status'] === 'Pending'): ?>
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Rejected</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (empty($leaveHistory)): ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No leave requests found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Optional: Additional Sections (e.g., Notifications, Upcoming Events) -->
        </div>
    </div>
<?php else: ?>
    <div class="content">
        <div class="container">
            <h2 class="page-title">My Dashboard</h2>
            <div class="alert alert-danger">
                <p>Your profile information is not available. Please contact the HR department.</p>
            </div>
        </div>
    </div>
<?php endif; ?>
