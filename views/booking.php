<?php
/*
 * Created on Mon Jul 26 2021
 *
 * The MIT License (MIT)
 * Copyright (c) 2021 MartDevelopers Inc
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
check_login();

/* Accept Booking */
if (isset($_POST['Authorize'])) {
    $accepted_booking_booking_id = $_POST['accepted_booking_booking_id'];
    $accepted_booking_staff_id = $_POST['accepted_booking_staff_id'];
    $accepted_booking_doctor_id = $_POST['accepted_booking_doctor_id'];
    $accepted_booking_actual_date = $_POST['accepted_booking_actual_date'];

    /* Booking Status */
    $booking_status = 'Accepted';

    $query = 'INSERT INTO Accepted_Booking (accepted_booking_booking_id, accepted_booking_staff_id, accepted_booking_doctor_id, accepted_booking_actual_date) VALUES(?,?,?,?)';
    $status = "UPDATE Bookings SET booking_status = ? WHERE booking_id= ?";

    $stmt = $mysqli->prepare($query);
    $status_stmt = $mysqli->prepare($status);

    $rc = $stmt->bind_param('ssss', $accepted_booking_booking_id, $accepted_booking_staff_id, $accepted_booking_doctor_id, $accepted_booking_actual_date);
    $rc = $status_stmt->bind_param('ss', $booking_status, $accepted_booking_booking_id);

    $stmt->execute();
    $status_stmt->execute();

    if ($stmt && $status_stmt) {
        $success = "Booking Accepted";
    } else {
        $info = 'Please Try Again Or Try Later';
    }
}

/* Reject Booking */
if (isset($_POST['RejectBooking'])) {

    $booking_status = 'Rejected';
    $booking_id = $_POST['booking_id'];

    $query = 'UPDATE Bookings SET booking_status = ? WHERE booking_id = ?';
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ss', $booking_status, $booking_id);
    $stmt->execute();
    if ($stmt) {
        $success = "Booking Rejected";
    } else {
        $info = 'Please Try Again Or Try Later';
    }
}


require_once('../partials/head.php');
$view = $_GET['view'];
$ret = "SELECT * FROM Bookings b 
INNER JOIN Clients c ON b.booking_client_id = c.client_id 
INNER JOIN Hospital_Service s ON s.hos_serv_id = b.booking_hos_serv_id 
INNER JOIN Hospital h ON s.hos_serv_hospital_id = h.hospital_id
INNER JOIN Services se ON se.service_id = s.hos_serv_service_id WHERE b.Booking_id = '$view'";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($booking = $res->fetch_object()) {
?>

    <body>
        <!-- Preloader-->
        <div class="preloader d-flex align-items-center justify-content-center" id="preloader">
            <div class="spinner-grow text-primary" role="status">
                <div class="sr-only">Loading...</div>
            </div>
        </div>
        <!-- Internet Connection Status-->
        <div class="internet-connection-status" id="internetStatus"></div>
        <!-- Header Area-->
        <div class="header-area" id="headerArea">
            <div class="container">
                <!-- Header Content-->
                <div class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
                    <!-- Back Button-->
                    <div class="back-button">
                        <a href="bookings">
                            <svg width="32" height="32" viewBox="0 0 16 16" class="bi bi-arrow-left-short" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
                            </svg>
                        </a>
                    </div>
                    <!-- Page Title-->
                    <div class="page-heading">
                        <h6 class="mb-0">Booking REF: <?php echo $booking->booking_ref; ?> Details</h6>
                    </div>
                    <!-- Navbar Toggler-->
                    <div class="navbar--toggler" id="affanNavbarToggler"><span class="d-block"></span><span class="d-block"></span><span class="d-block"></span></div>
                </div>
            </div>
        </div>
        <!-- Dark mode switching-->
        <div class="dark-mode-switching">
            <div class="d-flex w-100 h-100 align-items-center justify-content-center">
                <div class="dark-mode-text text-center"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-moon" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M14.53 10.53a7 7 0 0 1-9.058-9.058A7.003 7.003 0 0 0 8 15a7.002 7.002 0 0 0 6.53-4.47z" />
                    </svg>
                    <p class="mb-0">Switching to dark mode</p>
                </div>
                <div class="light-mode-text text-center"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16">
                        <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
                    </svg>
                    <p class="mb-0">Switching to light mode</p>
                </div>
            </div>
        </div>
        <!-- Sidenav Black Overlay-->
        <div class="sidenav-black-overlay"></div>
        <!-- Side Nav Wrapper-->
        <?php require_once('../partials/side_nav.php'); ?>

        <!-- Reject Modal-->
        <div class="modal fade" id="reject_booking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">CONFIRM BOOKING REJECTION</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body text-center text-danger">
                        <h4>Reject <?php echo $booking->client_full_name; ?> Booking ?</h4>
                        <br>
                        <p>Heads Up, You are about to reject <?php echo $booking->client_full_name . " Booking REF: " . $booking->booking_ref; ?>.<br> </p>
                        <form method="POST">
                            <input name="booking_id" value="<?php echo $booking->booking_id; ?>" type="hidden">
                            <input name="booking_status" value="Rejected" type="hidden">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">No</button>
                            <button type="submit" class="text-center btn btn-danger" name="RejectBooking">Reject Booking</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
        <!-- Accept Modal -->
        <div class="modal fade" id="accept_booking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Accept Booking Request</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body text-center text-danger">
                        <form method="POST">
                            <input name="accepted_booking_booking_id" value="<?php echo $booking->booking_id; ?>" type="hidden">
                            <input name="booking_status" value="Authorized" type="hidden">
                            <?php
                            $login_id = $_SESSION['login_id'];
                            $ret = "SELECT *  FROM Clinic_Staff WHERE staff_login_id = '$login_id' ";
                            $stmt = $mysqli->prepare($ret);
                            $stmt->execute(); //ok
                            $res = $stmt->get_result();
                            while ($user = $res->fetch_object()) {
                            ?>
                                <input name="accepted_booking_staff_id" value="<?php echo $user->staff_id; ?>" type="hidden">
                            <?php
                            } ?>
                            <div class="form-group mb-3">
                                <label class="form-label">Doctor Authorized</label>
                                <select name="accepted_booking_doctor_id" required class="form-control" type="text">
                                    <?php
                                    /* Load All Doctors */
                                    $ret = "SELECT * FROM `Doctors`";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($doctor = $res->fetch_object()) {
                                    ?>
                                        <option value="<?php echo $doctor->doctor_id; ?>"><?php echo $doctor->doctor_full_name; ?></option>
                                    <?php
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label">Actual Date</label>
                                <input name="accepted_booking_actual_date" required class="form-control" type="date">
                            </div>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                            <button type="submit" class="text-center btn btn-success" name="Authorize">Authorize Booking </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
        <div class="page-content-wrapper py-3">
            <div class="container">
                <div class="card product-details-card mb-3 direction-rtl">
                    <div class="card-body">
                        <h3><?php echo $booking->client_full_name; ?> Booking</h3>
                    </div>
                </div>

                <div class="card product-details-card mb-3 direction-rtl">
                    <div class="card-body">
                        <h5>Booking Details</h5><br>
                        <p>Ref # : <?php echo $booking->booking_ref; ?></p>
                        <p>Date Created: <?php echo date('d-M-Y', strtotime($booking->booking_date)); ?></p>
                        <p>Booking Status:
                            <?php
                            if ($booking->booking_status == 'New') {
                                echo "<span class='badge bg-primary'>$booking->booking_status</span>";
                            } else if ($booking->booking_status == 'Rejected') {
                                echo "<span class='badge bg-danger'>$booking->booking_status</span>";
                            } else {
                                echo "<span class='badge bg-success'>$booking->booking_status</span>";
                            }
                            ?>
                        </p>
                        <p>Service Date: <?php echo $booking->booking_service_date; ?></p>
                    </div>
                </div>
                <div class="card product-details-card mb-3 direction-rtl">
                    <div class="card-body">
                        <h5>Client Details</h5>
                    </div>
                    <div class="row">
                        <div class="col-6 card-body">

                            <p>Name: <?php echo $booking->client_full_name; ?></p>
                            <p>Email: <?php echo $booking->client_email; ?></p>
                            <p>Phone No: <?php echo $booking->client_phone_no; ?></p>
                        </div>
                        <div class="col-6 card-body">
                            <p>Gender: <?php echo $booking->client_gender; ?></p>
                            <p>Address: <?php echo $booking->client_location; ?></p>
                        </div>
                    </div>
                </div>

                <div class="card product-details-card mb-3 direction-rtl">
                    <div class="card-body">
                        <h5>Hospital Offering Booked Service Details</h5><br>
                        <p>Hospital Name: <?php echo $booking->hospital_name; ?></p>
                        <p>Hospital Email: <?php echo $booking->hospital_email; ?></p>
                        <p>Hospital Mobile: <?php echo $booking->hospital_mobile; ?></p>
                        <p>Hospital Contacts: <?php echo $booking->hospital_contact; ?></p>
                        <hr>
                        <p><?php echo $booking->hospital_desc; ?></p>
                    </div>
                </div>

                <div class="card product-details-card mb-3 direction-rtl">
                    <div class="card-body">
                        <h5>Booked Hospital Service Details</h5><br>
                        <p><?php echo $booking->service_name; ?></p>
                        <hr>
                        <p><?php echo $booking->service_desc; ?></p>
                    </div>
                </div>
                <?php
                if ($booking->booking_status != 'Accepted') {
                ?>
                    <div class="card product-details-card mb-3 direction-rtl">
                        <div class="card-body">
                            <h5 class="text-center">Booking Status</h5>
                            <div class="text-center">
                                <button type="button" href="#" data-bs-toggle="modal" data-bs-target="#reject_booking" class="btn btn-danger">Reject Booking</button>
                                <button type="button" href="#" data-bs-toggle="modal" data-bs-target="#accept_booking" class="btn btn-success">Accept Booking</button>
                            </div>
                        </div>
                    </div>
                <?php
                }
                $ret = "SELECT * FROM Accepted_Booking ab 
                INNER JOIN Clinic_Staff s ON ab.accepted_booking_staff_id = s.staff_id
                INNER JOIN Doctors d ON ab.accepted_booking_doctor_id = d.doctor_id
                WHERE ab.accepted_booking_booking_id = '$view' ";
                $stmt = $mysqli->prepare($ret);
                $stmt->execute(); //ok
                $res = $stmt->get_result();
                while ($accepted_booking = $res->fetch_object()) {
                ?>
                    <div class="card product-details-card mb-3 direction-rtl">
                        <div class="card-body">
                            <h5>Accepted Booking Details</h5> <br>
                            <p>Clinic Staff Name : <?php echo $accepted_booking->staff_full_name; ?></p>
                            <p>Clinic Staff Email : <?php echo $accepted_booking->staff_email; ?></p>
                            <p>Clinic Staff Phone : <?php echo $accepted_booking->staff_phone_no; ?></p>
                            <hr>
                            <p>Doctor Name : <?php echo $accepted_booking->doctor_full_name; ?></p>
                            <p>Doctor Email : <?php echo $accepted_booking->doctor_email; ?></p>
                            <hr>
                            <p>Booking Actual Date : <?php echo date('d-M-Y', strtotime($accepted_booking->accepted_booking_actual_date)); ?></p>

                        </div>
                    </div>
                <?php
                } ?>

            </div>
        </div>
        <!-- Footer Nav-->
        <?php require_once('../partials/footer_nav.php'); ?>
        <!-- All JavaScript Files-->
        <?php require_once('../partials/scripts.php'); ?>
    </body>
<?php
}
?>

</html>