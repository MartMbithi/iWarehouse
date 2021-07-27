<?php
/*
 * Created on Sat Jul 03 2021
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
require_once('../partials/analytics.php');
require_once('../partials/head.php');
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
    <?php require_once('../partials/header.php'); ?>
    <!-- Sidenav Black Overlay-->
    <div class="sidenav-black-overlay"></div>
    <!-- Side Nav Wrapper-->
    <?php require_once('../partials/side_nav.php'); ?>

    <div class="page-content-wrapper">
        <!-- Hero Slides-->
        <div class="owl-carousel-one owl-carousel">
            <div class="single-hero-slide bg-overlay" style="background-image: url('../public/img/bg-img/clinic_staff.jpg')">
                <div class="slide-content h-100 d-flex align-items-center text-center">
                    <div class="container">
                        <h4 class="text-white mb-1" data-animation="fadeInUp" data-delay="100ms" data-wow-duration="500ms">Clinic Staffs</h4>
                        <a class="btn btn-creative btn-warning" href="staffs" data-animation="fadeInUp" data-delay="800ms" data-wow-duration="500ms"><?php echo $staff; ?></a>
                    </div>
                </div>
            </div>
            <div class="single-hero-slide bg-overlay" style="background-image: url('../public/img/bg-img/doctors.png')">
                <div class="slide-content h-100 d-flex align-items-center text-center">
                    <div class="container">
                        <h4 class="text-white mb-1" data-animation="fadeInUp" data-delay="100ms" data-wow-duration="1000ms">Qualified Doctors</h4>
                        <a class="btn btn-creative btn-warning" href="doctors" data-animation="fadeInUp" data-delay="800ms" data-wow-duration="500ms"><?php echo $doc; ?></a>
                    </div>
                </div>
            </div>
            <div class="single-hero-slide bg-overlay" style="background-image: url('../public/img/bg-img/clients.jpeg')">
                <div class="slide-content h-100 d-flex align-items-center text-center">
                    <div class="container">
                        <h4 class="text-white mb-1" data-animation="fadeInUp" data-delay="100ms" data-wow-duration="1000ms">Registered Clients</h4>
                        <a class="btn btn-creative btn-warning" href="clients" data-animation="fadeInUp" data-delay="800ms" data-wow-duration="500ms"><?php echo $client; ?></a>
                    </div>
                </div>
            </div>
            <div class="single-hero-slide bg-overlay" style="background-image: url('../public/img/bg-img/hospital.jpg')">
                <div class="slide-content h-100 d-flex align-items-center text-center">
                    <div class="container">
                        <h4 class="text-white mb-1" data-animation="fadeInUp" data-delay="100ms" data-wow-duration="1000ms">Registered Hospitals</h4>
                        <a class="btn btn-creative btn-warning" href="hospitals" data-animation="fadeInUp" data-delay="800ms" data-wow-duration="500ms"><?php echo $Hospital; ?></a>
                    </div>
                </div>
            </div>
            <div class="single-hero-slide bg-overlay" style="background-image: url('../public/img/bg-img/hospital_services.webp')">
                <div class="slide-content h-100 d-flex align-items-center text-center">
                    <div class="container">
                        <h4 class="text-white mb-1" data-animation="fadeInUp" data-delay="100ms" data-wow-duration="1000ms">Hospital Services</h4>
                        <a class="btn btn-creative btn-warning" href="hospital_services" data-animation="fadeInUp" data-delay="800ms" data-wow-duration="500ms"><?php echo $Hospital_Service; ?></a>
                    </div>
                </div>
            </div>
            <div class="single-hero-slide bg-overlay" style="background-image: url('../public/img/bg-img/booking.jpg')">
                <div class="slide-content h-100 d-flex align-items-center text-center">
                    <div class="container">
                        <h4 class="text-white mb-1" data-animation="fadeInUp" data-delay="100ms" data-wow-duration="1000ms">Client Bookings</h4>
                        <a class="btn btn-creative btn-warning" href="bookings" data-animation="fadeInUp" data-delay="800ms" data-wow-duration="500ms"><?php echo $Bookings; ?></a>
                    </div>
                </div>
            </div>

        </div>
        <br>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h2>Recent Clients Bookings</h2>
                    <div class="testimonial-slide owl-carousel testimonial-style3">
                        <?php
                        $ret = "SELECT * FROM Bookings b 
                        INNER JOIN Clients c ON b.booking_client_id = c.client_id 
                        INNER JOIN Hospital_Service s ON s.hos_serv_id = b.booking_hos_serv_id 
                        INNER JOIN Services se ON se.service_id = s.hos_serv_service_id ORDER BY RAND() LIMIT 10
                        ";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->execute(); //ok
                        $res = $stmt->get_result();
                        while ($booking = $res->fetch_object()) {
                        ?>

                            <div class="single-testimonial-slide">
                                <a href="booking?view=<?php echo $booking->booking_id; ?>">
                                    <div class="text-content">
                                        <span class="d-inline-block badge bg-warning mb-2"><i class="bi bi-tag-fill"></i> Ref: <?php echo $booking->booking_ref; ?></span>
                                        <?php
                                        if ($booking->booking_status == 'New') {
                                            echo "<span class='d-inline-block badge bg-primary mb-2'><i class='bi bi-bookmark-star'></i> Booking Status: $booking->booking_status </span>";
                                        } else if ($booking->booking_status == 'Rejected') {
                                            echo "<span class='d-inline-block badge bg-danger mb-2'><i class='bi bi-bookmark-star'></i> Booking Status: $booking->booking_status </span>";
                                        } else {
                                            echo "<span class='d-inline-block badge bg-success mb-2'><i class='bi bi-bookmark-star'></i> Booking Status: $booking->booking_status </span>";
                                        }
                                        ?>
                                        </span>
                                        <span class="d-inline-block badge bg-success mb-2"><i class="bi bi-person-bounding-box"></i> Booked Hospital Service: <?php echo $booking->service_name; ?></span>
                                        <span class="d-block">Client Name : <?php echo $booking->client_full_name; ?></span>
                                        <span class="d-block">Client Phone : <?php echo $booking->client_phone_no; ?></span>
                                        <span class="d-block">Booking Date : <?php echo date('d-M-Y', strtotime($booking->booking_date)); ?></span>
                                    </div>
                                </a>
                            </div>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h2>Avaiable Hospital Services</h2>
                    <div class="testimonial-slide owl-carousel testimonial-style3">
                        <?php
                        $ret = "SELECT * FROM Hospital_Service hs
                        INNER JOIN Hospital h ON hs.hos_serv_hospital_id = h.hospital_id
                        INNER JOIN Services s ON hs.hos_serv_service_id = s.service_id ORDER BY RAND() ASC LIMIT 10   ";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->execute(); //ok
                        $res = $stmt->get_result();
                        while ($service = $res->fetch_object()) {
                        ?>
                            <a href="hospital_service?view=<?php echo $service->hos_serv_id; ?>">
                                <div class="single-testimonial-slide">
                                    <div class="text-content">
                                        <span class="d-inline-block badge bg-warning mb-2"><?php echo $service->hospital_name; ?></span>
                                        <h6 class="text-truncate mb-2"><?php echo $service->service_name; ?></h6>
                                        <h6 class="text-truncate mb-2">Hospital Email: <?php echo $service->hospital_email; ?></h6>
                                        <h6 class="text-truncate mb-2">Hospital Mobile: <?php echo $service->hospital_mobile; ?></h6>
                                        <h6 class="text-truncate mb-2">Hospital Contacts: <?php echo $service->hospital_contact; ?></h6>
                                        <h6 class="text-truncate mb-2">Service Cost: <?php echo $service->hos_serv_cost; ?></h6>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h2>Clinic Staffs</h2>
                    <div class="testimonial-slide owl-carousel testimonial-style3">
                        <!-- Single Testimonial Slide-->
                        <?php
                        $ret = "SELECT * FROM `Clinic_Staff`  ORDER BY RAND() ASC LIMIT 10   ";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->execute(); //ok
                        $res = $stmt->get_result();
                        while ($staff = $res->fetch_object()) {
                        ?>
                            <a href="staff?view=<?php echo $staff->staff_id; ?>">
                                <div class="single-testimonial-slide">
                                    <div class="text-content">
                                        <div class="col-12">
                                            <div class="card team-member-card shadow">
                                                <div class="card-body">
                                                    <!-- Member Image-->
                                                    <div class="team-member-img shadow-sm"><img src="../public/img/bg-img/profile.svg" alt=""></div>
                                                    <!-- Team Info-->
                                                    <div class="team-info">
                                                        <h6 class="mb-0"><?php echo $staff->staff_full_name; ?></h6>
                                                        <p class="mb-0">Contacts: <?php echo $staff->staff_phone_no; ?></p>
                                                        <p class="mb-0">ID No: <?php echo $staff->staff_id_no; ?></p>
                                                    </div>
                                                </div>
                                                <!-- Contact Info-->
                                                <div class="contact-info bg-info">
                                                    <p class="mb-0 text-truncate"><?php echo $staff->staff_email; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h2>Doctors</h2>
                    <div class="testimonial-slide owl-carousel testimonial-style3">
                        <!-- Single Testimonial Slide-->
                        <?php
                        $ret = "SELECT * FROM `Doctors`  ORDER BY RAND() ASC LIMIT 10   ";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->execute(); //ok
                        $res = $stmt->get_result();
                        while ($staff = $res->fetch_object()) {
                        ?>
                            <a href="doctor?view=<?php echo $staff->doctor_id; ?>">
                                <div class="single-testimonial-slide">
                                    <div class="text-content">
                                        <div class="col-12">
                                            <div class="card team-member-card shadow">
                                                <div class="card-body">
                                                    <!-- Member Image-->
                                                    <div class="team-member-img shadow-sm"><img src="../public/img/bg-img/doctor.svg" alt=""></div>
                                                    <!-- Team Info-->
                                                    <div class="team-info">
                                                        <h6 class="mb-0"><?php echo $staff->doctor_full_name; ?></h6>
                                                        <p class="mb-0">Contacts: <?php echo $staff->doctor_phone_no; ?></p>
                                                        <hr>
                                                        <small>
                                                            <?php echo $staff->doctor_specialization; ?>
                                                        </small>
                                                    </div>
                                                </div>
                                                <!-- Contact Info-->
                                                <div class="contact-info bg-info">
                                                    <p class="mb-0 text-truncate"><?php echo $staff->doctor_email; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-3"></div>
    </div>
    <!-- Footer Nav-->
    <?php require_once('../partials/footer_nav.php'); ?>
    <!-- All JavaScript Files-->
    <?php require_once('../partials/scripts.php'); ?>
</body>


</html>