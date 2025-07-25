<?php

include("con.php");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$reg = $_GET['reg'] ?? '';
$start_date = $_GET['start_date'] ?? date('Y-m-d', strtotime('-7 days'));
$end_date = $_GET['end_date'] ?? date('Y-m-d');

$student = [];
$attendance = [];
$stats = [
    'full_day_absent' => 0,
    'half_day_absent' => 0,
    'total_day_absent' => 0,
    'od_applied' => 0,
    'leave_applied' => 0,
    'total_present_hours' => 0,
    'total_applicable_hours' => 0,
    'day_wise_present' => 0,
    'total_days' => 0,
    'holidays' => 0,
    'last_attendance_date' => 'N/A'
];

if ($reg && $start_date && $end_date) {
    // Fetch student details
    $stmt = $conn->prepare("SELECT * FROM students WHERE reg_no = ?");
    $stmt->bind_param("s", $reg);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();

    if ($student) {
        // Fetch attendance records
        $stmt = $conn->prepare("SELECT * FROM attendance WHERE reg_no = ? AND date BETWEEN ? AND ? ORDER BY date DESC");
        $stmt->bind_param("sss", $reg, $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();
        $attendance = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        foreach ($attendance as $record) {
            $periods = array_slice($record, 4, 7); // Get period_1 to period_7
            $period_values = array_values($periods);
            
            // Check for holiday
            if (count(array_unique($period_values)) === 1 && $period_values[0] === 'H') {
                $stats['holidays']++;
                continue;
            }

            $stats['total_days']++;
            $all_present = true;
            $any_od = false;
            $any_leave = false;
            $absent_count = 0;

            foreach ($period_values as $status) {
                switch ($status) {
                    case 'P':
                        $stats['total_present_hours']++;
                        $stats['total_applicable_hours']++;
                        break;
                    case 'A':
                        $absent_count++;
                        $stats['total_applicable_hours']++;
                        $all_present = false;
                        break;
                    case 'O':
                        $any_od = true;
                        break;
                    case 'L':
                        $any_leave = true;
                        break;
                    case 'H':
                        break;
                    default:
                        $stats['total_applicable_hours']++;
                        $all_present = false;
                        break;
                }
            }

            if ($all_present) $stats['day_wise_present']++;
            if ($any_od) $stats['od_applied']++;
            if ($any_leave) $stats['leave_applied']++;

            if ($absent_count === 7) {
                $stats['full_day_absent']++;
            } elseif ($absent_count > 0) {
                $stats['half_day_absent']++;
            }
        }

        // Calculate statistics
        $stats['total_day_absent'] = $stats['full_day_absent'] + $stats['half_day_absent'];
        
        $total_day_percentage = 0;
        $valid_days_count = 0; // To calculate average only over valid days
        
        foreach ($attendance as $record) {
            $periods = array_slice($record, 4, 7); // period_1 to period_7
            $period_values = array_values($periods);
        
            // Check for full holiday
            if (count(array_unique($period_values)) === 1 && $period_values[0] === 'H') {
                $stats['holidays']++;
                continue;
            }
        
            $stats['total_days']++;
            $valid_days_count++;
        
            $present_count = 0;
            $absent_count = 0;
            $od_count = 0;
            $leave_count = 0;
        
            foreach ($period_values as $status) {
                switch ($status) {
                    case 'P':
                        $present_count++;
                        break;
                    case 'A':
                        $absent_count++;
                        break;
                    case 'O':
                        $od_count++;
                        break;
                    case 'L':
                        $leave_count++;
                        break;
                }
            }
        
            // If all 7 OD => 100%
            if ($od_count === 7) {
                $day_percentage = 100;
            }
            // If all 7 Present => 100%
            elseif ($present_count === 7) {
                $day_percentage = 100;
            }
            // If all 7 Absent => 0%
            elseif ($absent_count === 7) {
                $day_percentage = 0;
            }
            // Mixed case (P, A, O)
            else {
                $present_like = $present_count + $od_count; // Treat OD like present
                $day_percentage = round(($present_like / 7) * 100, 2);
            }
        
            $total_day_percentage += $day_percentage;
        
            // Other stat calculations
            if ($absent_count === 7) {
                $stats['full_day_absent']++;
            } elseif ($absent_count > 0 && $absent_count < 7) {
                $stats['half_day_absent']++;
            }
        
            if ($present_count === 7) {
                $stats['day_wise_present']++;
            }
        
            if ($od_count > 0) $stats['od_applied']++;
            if ($leave_count > 0) $stats['leave_applied']++;
        }
        
        // Final Hour Wise Percentage:
        $stats['hour_wise_percentage'] = $valid_days_count > 0 
            ? round($total_day_percentage / $valid_days_count, 2)
            : 0;

        $stats['day_wise_percentage'] = $stats['total_days'] > 0
            ? round(($stats['day_wise_present'] / $stats['total_days']) * 100, 2)
            : 0;

        // Last attendance date
        if (!empty($attendance)) {
            $first_record = reset($attendance); // This gives the most recent date because of DESC order
            $stats['last_attendance_date'] = date('d/m/Y', strtotime($first_record['date']));
        }
    }
}

$status_classes = [
    'P' => 'present',
    'A' => 'absent',
    'H' => 'holiday',
    'L' => 'leave',
    'O' => 'od'
];
?>



<!DOCTYPE html>
<html lang="en">
    <?php include("head.php")?>
    <body>
        <?php include("nav.php")?>
        <style>
            .legend {
                 margin-top: 15px; 
            }

            .legend span {
                padding: 5px 10px;
                border-radius: 5px;
                color: #fff;
                margin-right: 10px;
            }
            .present {
                background-color:#4CAF50;
                }
                .absent {
              background-color: #f44336;
                 }

              .holiday {
              background-color: #9e9e9e;
                  }

              .leave {
             background-color:orange;
                  }

             .od {
              background-color: #f32144;
                }
                .attendance-table {
               width: 100%;
               margin-top: 15px;
              border-collapse: collapse;
}

              .attendance-table th, .attendance-table td {
             border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

.attendance-table th {
    background-color: #654caf;
    color: white;
}

.card_wht {
                background: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                margin: 20px 0;
            }
            .form-row {
                display: flex;
                gap: 15px;
                margin-bottom: 20px;
                flex-wrap: wrap;
            }
            
            .form-row div {
                flex: 1;
                min-width: 200px;
            }
            input[type="text"], 
            input[type="date"],
            select {
                width: 100%;
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 5px;
                margin-top: 5px;
            }
            
            button {
                background-color: #1b06ff;
                color: white;
                border: none;
                padding: 10px 20px;
                cursor: pointer;
                border-radius: 5px;
                height: fit-content;
            }
            
            button:hover {
                background-color: #74b9ff;
            }
        </style>
        <div class="frame_body">
            <?php include("sidenav.php"); ?>
            <div class="cnt_frame_main">
            <div class="cnt_sec">
                        <div class="card_wht">
                            <div class="head_main">
                                <h4 class="heading">Search Attendance</h4>
                            </div>
                            <div class="card_cnt">
                                <form method="GET" class="date-range">
                                    <div class="form-row">
                                        <div>
                                            <label>Register Number</label>
                                            <input type="text" name="reg" 
                                                   value="<?= htmlspecialchars($reg) ?>" required>
                                        </div>
                                        <div>
                                            <label>From Date</label>
                                            <input type="date" name="start_date" 
                                                   value="<?= htmlspecialchars($start_date) ?>" required>
                                        </div>
                                        <div>
                                            <label>To Date</label>
                                            <input type="date" name="end_date" 
                                                   value="<?= htmlspecialchars($end_date) ?>" required>
                                        </div>
                                        <div style="align-self: flex-end">
                                            <button type="submit">View Attendance</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    <div class="cnt_sec">
                        <?php if ($student): ?>
                        <div class="card_wht">
                            <div class="head_main">
                                <h4 class="heading">ATTENDANCE MODULE</h4>
                            </div>
                            <div class="card_cnt">
                                <div class="row">
                                    <div class="col-6">
                                        <p><strong>NAME:</strong> <?= $student['name'] ?></p>
                                        <p><strong>DEPARTMENT:</strong> <?= $student['branch'] ?></p>
                                        <p><strong>HALF DAY ABSENT:</strong> <?= $stats['half_day_absent'] ?></p>
                                        <p><strong>OD APPLIED:</strong> <?= $stats['od_applied'] ?></p>
                                        <p><strong>HOUR WISE PERCENTAGE:</strong> <?= $stats['hour_wise_percentage'] ?>%</p>
                                        <p><strong>DAY WISE PRESENT:</strong> <?= $stats['day_wise_present'] ?></p>
                                    </div>
                                    <div class="col-6">
                                        <p><strong>BRANCH:</strong> <?= $student['branch'] ?></p>
                                        <p><strong>FULL DAY ABSENT:</strong> <?= $stats['full_day_absent'] ?></p>
                                        <p><strong>TOTAL DAY ABSENT:</strong> <?= $stats['total_day_absent'] ?></p>
                                        <p><strong>LEAVE APPLIED:</strong> <?= $stats['leave_applied'] ?></p>
                                        <p><strong>LAST ATTENDANCE DATE:</strong> <?= $stats['last_attendance_date'] ?></p>
                                        <p><strong>DAY WISE PERCENTAGE:</strong> <?= $stats['day_wise_percentage'] ?>%</p>
                                    </div>
                                </div>  
                            </div>
                        </div>
                        <div class="card_wht">
                            <div class="head_main">
                                <div class="legend">
                                    <?php foreach ($status_classes as $code => $class): ?>
                                    <span class="<?= $class ?>"><?= $code ?></span> <?= ucfirst($class) ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="card_cnt">
                                <table class="attendance-table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <?php for ($i = 1; $i <= 7; $i++): ?>
                                            <th>H<?= $i ?></th>
                                            <?php endfor; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($attendance as $record): ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($record['date'])) ?></td>
                                            <?php for ($i = 1; $i <= 7; $i++): 
                                                $status = $record["period_$i"];
                                                $class = $status_classes[$status] ?? 'absent';
                                            ?>
                                            <td class="<?= $class ?>"><?= $status ?></td>
                                            <?php endfor; ?>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php elseif ($reg): ?>
    <div class="card_wht">
        <div class="card_cnt text-center">
            <p>No student found with the provided registration number.</p>
        </div>
    </div>
<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        
        
    </body>
</html>