<?php
session_start();
include('assets/inc/config.php');
if (isset($_POST['add_pharmaceutical'])) {
    $phar_name = $_POST['phar_name'];
    $phar_desc = $_POST['phar_desc'];
    $phar_qty = $_POST['phar_qty'];
    $phar_cat = $_POST['phar_cat'];
    $phar_bcode = $_POST['phar_bcode'];
    $phar_vendor = $_POST['phar_vendor'];

    //sql to insert captured values
    $query = "INSERT INTO his_pharmaceuticals (phar_name, phar_bcode, phar_desc, phar_qty, phar_cat, phar_vendor) VALUES (?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ssssss', $phar_name, $phar_bcode, $phar_desc, $phar_qty, $phar_cat, $phar_vendor);
    $stmt->execute();
    /*
     *Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
     *echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
     */
    //declare a varible which will be passed to alert function
    if ($stmt) {
        $success = "Pharmaceutical  Added";
    } else {
        $err = "Please Try Again Or Try Later";
    }


}
?>
<!--End Server Side-->
<!--End Patient Registration-->
<!DOCTYPE html>
<html lang="en">

<!--Head-->
<?php include('assets/inc/head.php'); ?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include("assets/inc/nav.php"); ?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include("assets/inc/sidebar.php"); ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="his_doc_dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pharmaceuticals</a>
                                        </li>
                                        <li class="breadcrumb-item active">Add Pharmaceutical</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Book Appointment</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- Form row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Fill all fields</h4>
                                    <!--Add Patient Form-->
                                    <form method="post">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4" class="col-form-label">Patient Name</label>
                                                <input type="text" required="required" name="phar_name"
                                                    class="form-control" id="inputEmail4">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4" class="col-form-label">Patient
                                                    Number</label>
                                                <input required="required" type="text" name="phar_qty"
                                                    class="form-control" id="inputPassword4">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputPassword4" class="col-form-label">Patient Email</label>
                                                <input required="required" type="text" name="phar_qty"
                                                    class="form-control" id="inputPassword4">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputState" class="col-form-label">Select Doctor</label>
                                                <select id="inputState" required="required" name="phar_cat"
                                                    class="form-control">
                                                    <!--Fetch All Doctors-->
                                                    <?php
                                                    $ret = "SELECT * FROM his_docs ORDER BY RAND()";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    while ($row = $res->fetch_object()) {
                                                        ?>
                                                        <option><?php echo $row->doc_fname; ?></option>
                                                        <!-- Assuming 'doc_name' is the correct column -->
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="inputState" class="col-form-label">Select Date</label>
                                                <select id="inputState" required="required" name="phar_vendor"
                                                    class="form-control">
                                                    <?php
                                                    // Get today's date
                                                    $today = date('Y-m-d');
                                                    // Get tomorrow's date
                                                    $tomorrow = date('Y-m-d', strtotime('+1 day'));
                                                    // Get the day after tomorrow's date
                                                    $dayAfterTomorrow = date('Y-m-d', strtotime('+2 days'));
                                                    ?>
                                                    <option><?php echo $today; ?> (Today)</option>
                                                    <option><?php echo $tomorrow; ?> (Tomorrow)</option>
                                                    <option><?php echo $dayAfterTomorrow; ?> (Day After Tomorrow)
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="inputState" class="col-form-label">Select Time</label>
                                                <select id="inputState" required="required" name="phar_vendor"
                                                    class="form-control">
                                                    <?php
                                                    // Define time slots in AM and PM
                                                    $timeSlots = [
                                                        "08:00 AM",
                                                        "09:00 AM",
                                                        "10:00 AM",
                                                        "11:00 AM",
                                                        "12:00 PM",
                                                        "01:00 PM",
                                                        "02:00 PM",
                                                        "03:00 PM",
                                                        "04:00 PM",
                                                        "05:00 PM",
                                                        "06:00 PM",
                                                        "07:00 PM",
                                                    ];

                                                    // Loop through the time slots and create options
                                                    foreach ($timeSlots as $time) {
                                                        echo "<option>$time</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>


                                        </div>


                                        <div class="form-group">
                                            <label for="inputAddress" class="col-form-label">Disease Description</label>
                                            <textarea required="required" type="text" class="form-control"
                                                name="phar_desc" id="editor"></textarea>
                                        </div>

                                        <button type="submit" name="add_pharmaceutical"
                                            class="ladda-button btn btn-success" data-style="expand-right">Book AppointMent</button>

                                    </form>

                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <?php include('assets/inc/footer.php'); ?>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->
    <!--Load CK EDITOR Javascript-->
    <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('editor')
    </script>

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js-->
    <script src="assets/js/app.min.js"></script>

    <!-- Loading buttons js -->
    <script src="assets/libs/ladda/spin.js"></script>
    <script src="assets/libs/ladda/ladda.js"></script>

    <!-- Buttons init js-->
    <script src="assets/js/pages/loading-btn.init.js"></script>

</body>

</html>