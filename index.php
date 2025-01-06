<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@1,100;1,200;1,300&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Raleway:wght@100..900&display=swap" rel="stylesheet">
    
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container{
            background: #85a785;
            height: 29vh;
            width: 547px;
            padding: 35px 18px 20px 18px;
            border-radius: 14px;
        }

        .raleway-font {
            font-family: "Raleway", sans-serif;
            font-optical-sizing: auto;
            font-weight: 500;
            font-style: normal;
        }

        .btn{
            border: 2px solid black;
        }

    </style>
</head>

<body>
    <div class="container">
        <h3 class="raleway-font">Appointment Booking</h3>
        <p class="raleway-font">Please book your appointment by clicking below.Thank You.</p>
        <a href="book.php" class="btn btn-success raleway-font">Please Book Appointment</a>
    </div>
</body>
</html>