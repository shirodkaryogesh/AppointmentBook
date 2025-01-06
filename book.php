<?php
    $mysqli = new mysqli('localhost','root','','Bookingappointment');
    // $mysqli = new mysqli('localhost','u748706600_bookAppointmet','Edpl@123','u748706600_bookAppointmet');
    $bookings = array();
    
    if(isset($_POST['submit'])){
        $date = $_POST['date'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $selected_timeSlot = $_POST['timeslot'];
        $stmt = $mysqli->prepare('SELECT * FROM bookings WHERE date=? AND timeslot=?');
        $stmt->bind_param('ss',$date,$selected_timeSlot);
        
        if($stmt->execute()){
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                $msg = "<div class='alert alert-danger'>Already Booked</div>";
            }else{
                $stmt = $mysqli->prepare('INSERT INTO bookings(date,name,email,contact,timeslot) VALUES (?,?,?,?,?)');
                $stmt->bind_param('sssss',$date,$name,$email,$contact,$selected_timeSlot);
                $stmt->execute();
                $msg = "<div class='alert alert-success'>Booking Successful</div>";
                $stmt->close();
                // $mysqli->close();
            }
        }
    }

    if(isset($_POST['date'])){
        $date = $_POST['date'];;
        $stmt = $mysqli->prepare('SELECT * FROM bookings WHERE date=?');
        $stmt->bind_param('s',$date);
        // $bookings = array();
        if($stmt->execute()){
            $result = $stmt->get_result();
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $bookings[] = $row['timeslot'];
                }
                $stmt->close();
            }
        }
    }else{
        $date = date('Y-m-d');
    }
     
   

    $duration = 15;
    $cleanup = 0;
    $start = "09:00";
    $end = "18:00";

    function timeSlots($duration, $cleanup, $start, $end)
    {
        $start = new DateTime($start);
        $end = new DateTime($end);
        $interval = new DateInterval("PT" . $duration . "M");
        $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
        $slots = array();
        for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
            $endPeriod = clone $intStart;
            $endPeriod->add($interval);
            if ($endPeriod > $end) {
                break;
            }
            $slots[] = $intStart->format("H:iA") . "-" . $endPeriod->format("H:iA");
        }
        return $slots;
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Book Appointment</title>
    <style>

        .heading-design{
            padding: 26px 30px 9px 30px;
        }
        .container{
            width: 674px;
            border: 2px solid black;
            padding: 17px;
            border-radius: 10px;
            margin-top: 32px;
        }
        .btn {
            margin: 5px;
        }
        .alert_design {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="alert_design">
            <?php echo isset($msg)?$msg:'';?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form action="" method="post" >
                    <div class="form-group">
                        <label class="mb-2 mt-2" for="">Date</label>
                        <input type="date" name="date" class="form-control" value="<?php echo isset($_POST['date']);?>" required>
                    </div>
                    <div class="form-group">
                        <label class="mb-2 mt-2" for="">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="mb-2 mt-2" for="">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="mb-2 mt-2" for="">Contact</label>
                        <input type="number" name="contact" class="form-control" required>
                    </div>
                    <div class="form-group mt-2">
                        <label class="mb-2 mt-2" for="timeslot">Time Slot</label>
                        <select name="timeslot" id="timeslot">
                            <?php 
                            $timeSlots = timeSlots($duration, $cleanup, $start, $end);
                            foreach ($timeSlots as $ts) {
                                if (in_array($ts, $bookings)) { 
                            ?>
                                    <option class='btn btn-danger'><?php echo $ts; ?></option>
                                <?php } else { 
                                ?>
                                    <option class='btn btn-success' value="<?php echo $ts; ?>"><?php echo $ts; ?></option>
                                <?php }
                            }
                            ?>    
                        </select>
                    </div>
                    <div class="form-group mt-2 d-flex justify-content-between">
                        <button class="btn btn-success" name="submit">Book</button>
                        <a href="index.php" class="btn btn-success">Back</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <div class="display_bookedSlot">
                <h3>Booked Slots:</h3>
                <?php 
                foreach ($bookings as $bookedSlot) {
                    echo "<p>$bookedSlot</p>";
                }    
                ?>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>

<!-- // if(isset($_GET['date'])){
    //     $date = $_GET['date'];
    //     $stmt = $mysqli->prepare('select * from bookings where date = ?');
    //     $stmt->bind_param('s',$date);
    //     $bookings = array();

    //     if($stmt->execute()){
    //         $result = $stmt->get_result();
    //         if($result->num_rows > 0){
    //             while($row = $result->fetch_assoc()){
    //                 $bookings[] = $row['timeslot'];
    //             }
    //             $stmt->close();
    //         }
    //     }
    // }else{
    //     $date = date('Y-m-d');
    // }

    // if(isset($_POST['submit'])){
    //     $name = $_POST['name'];
    //     $email = $_POST['email'];
    //     $contact = $_POST['contact'];
        
    //     $date = $_POST['date'];
    //     $selected_option = $_POST["timeslot"];
    //     $stmt = $mysqli->prepare('select * from bookings where date = ? AND timeslot= ?');
    //     $stmt->bind_param('ss',$date,$selected_option);
    //     $bookings = array();
    //     if($stmt->execute()){
    //         $result = $stmt->get_result();
    //         if($result->num_rows > 0){
                  $msg = "<div class='alert alert-danger'>Already Booked</div>"; -->
    <!-- //         }else{
    //             $stmt = $mysqli->prepare("INSERT INTO bookings (name,email,contact,date,timeslot) VALUES (?,?,?,?,?)");
    //             if (!$stmt) {
    //                 die('Error: ' . $mysqli->error);
    //             }
    //             $stmt->bind_param('sssss',$name,$email,$contact,$date,$selected_option);
    //             $stmt->execute();
    //             $bookings[] = $selected_option;
    //             $msg = "<div class='alert alert-success'>Booking Successful</div>";
    //             $stmt->close();
    //             $mysqli-> close();
    //         }
    //     }

        
    // } --> 