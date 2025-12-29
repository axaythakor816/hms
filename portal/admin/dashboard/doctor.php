<?php
require_once '../../../core/init.php';

// Doctor must be logged in
require_login();
require_role([2]); // Doctor role
?>

<div class="page-wrapper">
    <div class="content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#" class="nav-link">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                        <li class="breadcrumb-item active">Doctor Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Greeting -->
        <div class="good-morning-blk">
            <div class="row">
                <div class="col-md-6">
                    <div class="morning-user">
                        <h2>Good Morning, <span>Dr. John Doe</span></h2>
                        <p>Have a productive day!</p>
                    </div>
                </div>
                <div class="col-md-6 position-blk">
                    <div class="morning-img">
                        <img src="../assets/img/morning-img-01.png" alt="">
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Widgets -->
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <div class="dash-boxs comman-flex-center">
                        <img src="../assets/img/icons/calendar.svg" alt="">
                    </div>
                    <div class="dash-content dash-count">
                        <h4>Today’s Appointments</h4>
                        <h2><span class="counter-up">5</span></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <div class="dash-boxs comman-flex-center">
                        <img src="../assets/img/icons/profile-add.svg" alt="">
                    </div>
                    <div class="dash-content dash-count">
                        <h4>New Patients</h4>
                        <h2><span class="counter-up">3</span></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <div class="dash-boxs comman-flex-center">
                        <img src="../assets/img/icons/patients.svg" alt="">
                    </div>
                    <div class="dash-content dash-count">
                        <h4>Total Patients</h4>
                        <h2><span class="counter-up">45</span></h2>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="dash-widget">
                    <div class="dash-boxs comman-flex-center">
                        <img src="../assets/img/icons/money.svg" alt="">
                    </div>
                    <div class="dash-content dash-count">
                        <h4>Earnings</h4>
                        <h2>$<span class="counter-up">1200</span></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <div class="col-12 col-md-12 col-lg-6 col-xl-9">
                <div class="card">
                   <div class="card-body">
                        <div class="chart-title patient-visit">
                            <h4>Patient Visit by Gender</h4>
                            <div >
                                <ul class="nav chat-user-total">
                                    <li><i class="fa fa-circle current-users" aria-hidden="true"></i>Male 75%</li>
                                    <li><i class="fa fa-circle old-users" aria-hidden="true"></i> Female 25%</li>
                                </ul>
                            </div>
                            
                        </div>	
                        <div id="patient-chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-6 col-xl-3 d-flex">
                <div class="card">
                   <div class="card-body">
                        <div class="chart-title">
                            <h4>Patient by Department</h4>
                        </div>	
                        <div id="donut-chart-dash" class="chart-user-icon">
                            <img src="../assets/img/icons/user-icon.svg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline-block">Upcoming Appointments</h4>
                        <a href="#" class="patient-views float-end nav-link">Show all</a>
                    </div>
                    <div class="card-body p-0 table-dash">
                        <div class="table-responsive">
                            <table class="table mb-0 border-0 custom-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Patient Name</th>
                                        <th>Department</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Alex Johnson</td>
                                        <td>Cardiology</td>
                                        <td>26-12-2025</td>
                                        <td>10:00 AM</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Mary Smith</td>
                                        <td>General Physician</td>
                                        <td>26-12-2025</td>
                                        <td>11:30 AM</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>David Lee</td>
                                        <td>Dentist</td>
                                        <td>26-12-2025</td>
                                        <td>01:00 PM</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Patients Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="card-title d-inline-block">Recent Patients</h4>
                        <a href="#" class="float-end patient-views nav-link">Show all</a>
                    </div>
                    <div class="card-block table-dash">
                        <div class="table-responsive">
                            <table class="table mb-0 border-0 custom-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Patient Name</th>
                                        <th>Department</th>
                                        <th>Date of Birth</th>
                                        <th>Gender</th>
                                        <th>Last Visit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Alex Johnson</td>
                                        <td>Cardiology</td>
                                        <td>12-05-1990</td>
                                        <td>Male</td>
                                        <td>20-12-2025</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Mary Smith</td>
                                        <td>General Physician</td>
                                        <td>08-03-1985</td>
                                        <td>Female</td>
                                        <td>19-12-2025</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>David Lee</td>
                                        <td>Dentist</td>
                                        <td>23-09-1992</td>
                                        <td>Male</td>
                                        <td>18-12-2025</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="../assets/plugins/apexchart/apexcharts.min.js"></script>
<script src="../assets/plugins/apexchart/chart-data.js"></script>
