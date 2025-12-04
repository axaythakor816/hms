<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>

                <!-- ✅ DASHBOARD -->
                <?php if (has_permission('dashboard','can_view')): ?>
                <li class="submenu">
                    <a href="#"><span class="menu-side"><img src="../assets/img/icons/menu-icon-01.svg"></span>
                        <span>Dashboard</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="home.php" class="nav-link">Admin Dashboard</a></li>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ✅ DOCTORS -->
                <?php if (has_permission('doctors','can_view')): ?>
                <li class="submenu">
                    <a href="#"><span class="menu-side"><img src="../assets/img/icons/menu-icon-02.svg"></span>
                        <span>Doctors</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="doctors/doctors.php" class="nav-link">Doctor List</a></li>

                        <?php if (has_permission('doctors','can_add')): ?>
                        <li><a href="doctors/add-doctor.php" class="nav-link">Add Doctor</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ✅ PATIENTS -->
                <?php if (has_permission('patients','can_view')): ?>
                <li class="submenu">
                    <a href="#"><span class="menu-side"><img src="../assets/img/icons/menu-icon-03.svg"></span>
                        <span>Patients</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="patients/patients.php" class="nav-link">Patients List</a></li>

                        <?php if (has_permission('patients','can_add')): ?>
                        <li><a href="patients/add-patient.php" class="nav-link">Add Patient</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ✅ STAFF -->
                <?php if (has_permission('staff','can_view')): ?>
                <li class="submenu">
                    <a href="#"><span class="menu-side"><img src="../assets/img/icons/menu-icon-08.svg"></span>
                        <span>Staff</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="staff/staff-list.php" class="nav-link">Staff List</a></li>

                        <?php if (has_permission('staff','can_add')): ?>
                        <li><a href="staff/add-staff.php" class="nav-link">Add Staff</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ✅ APPOINTMENTS -->
                <?php if (has_permission('appointments','can_view')): ?>
                <li class="submenu">
                    <a href="#"><span class="menu-side"><img src="../assets/img/icons/menu-icon-04.svg"></span>
                        <span>Appointments</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="appointments/appointments.php" class="nav-link">Appointment List</a></li>

                        <?php if (has_permission('appointments','can_add')): ?>
                        <li><a href="appointments/add-appointment.php" class="nav-link">Book Appointment</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ✅ DOCTOR SCHEDULE -->
                <?php if (!has_permission('schedule','can_view')): ?>
                <li class="submenu">
                    <a href="#"><span class="menu-side"><img src="../assets/img/icons/menu-icon-05.svg"></span>
                        <span>Doctor Schedule</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="schedule/schedule.php" class="nav-link">Schedule List</a></li>

                        <?php if (has_permission('schedule','can_add')): ?>
                        <li><a href="schedule/add-schedule.php" class="nav-link">Add Schedule</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ✅ DEPARTMENTS -->
                <?php if (has_permission('departments','can_view')): ?>
                <li class="submenu">
                    <a href="#"><span class="menu-side"><img src="../assets/img/icons/menu-icon-06.svg"></span>
                        <span>Departments</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="departments/departments.php" class="nav-link">Department List</a></li>

                        <?php if (has_permission('departments','can_add')): ?>
                        <li><a href="departments/add-department.php" class="nav-link">Add Department</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ✅ ACCOUNTS -->
                <?php if (has_permission('billing','can_view')): ?>
                <li class="submenu">
                    <a href="#"><span class="menu-side"><img src="../assets/img/icons/menu-icon-07.svg"></span>
                        <span>Accounts</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="invoices.php" class="nav-link">Invoices</a></li>
                        <li><a href="payments.php" class="nav-link">Payments</a></li>
                        <li><a href="taxes.php" class="nav-link">Taxes</a></li>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ✅ PAYROLL -->
                <?php if (!has_permission('salary','can_view')): ?>
                <li class="submenu">
                    <a href="#"><span class="menu-side"><img src="../assets/img/icons/menu-icon-09.svg"></span>
                        <span>Payroll</span> <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="salary/salary.php" class="nav-link">Employee Salary</a></li>
                        <li><a href="salary/salary-view.php" class="nav-link">Payslip</a></li>
                    </ul>
                </li>
                <?php endif; ?>

                <!-- ✅ SETTINGS (ADMIN ONLY) -->
                <?php if ($_SESSION['role_id'] == 1): ?>
                <li>
                    <a href="settings/settings.php" class="nav-link">
                        <span class="menu-side"><img src="../assets/img/icons/menu-icon-16.svg"></span>
                        <span>Settings</span>
                    </a>
                </li>
                <?php endif; ?>

            </ul>

            <div class="logout-btn">
                <a href="dashboard.php?action=logout">
                    <span class="menu-side">
                        <img src="../assets/img/icons/logout.svg">
                    </span>
                    <span>Logout</span>
                </a>
            </div>

        </div>
    </div>
</div>

