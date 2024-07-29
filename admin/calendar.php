<?php
session_start();
include_once('includes/config.php');
if (strlen($_SESSION['aid']==0)) {
  header('location:logout.php');
  } else{
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Monthly Calendar</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        .calendar-container {
            max-width: 100%;
            margin-bottom: 30px;
        }

        .calendar-header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            text-align: center;
        }

        .calendar-day-header,
        .calendar-day {
            padding: 10px;
            border-radius: 5px;
            background-color: #f8f9fc;
            border: 1px solid #e3e6f0;
            min-height: 100px; /* Increase the height for card space */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }

        .calendar-day-header {
            background-color: #4e73df;
            color: white;
            font-weight: bold;
        }

        .calendar-day.saturday,
        .calendar-day.sunday {
            background-color: #f1f3f6;
        }

        .calendar-day:hover {
            background-color: #e2e6ea;
        }

        .day-number {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .event-card {
            background-color: #ffffff;
            border: 1px solid #e3e6f0;
            border-radius: 5px;
            margin-top: 5px;
            padding: 10px;
            width: 90%;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include_once('includes/sidebar.php');?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include_once('includes/topbar.php');?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Monthly Calendar</h1>
                    </div>

                    <!-- Calendar Section -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="calendar-container">
                                        <div class="calendar-header" id="calendar-header"></div>
                                        <div id="calendar" class="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include_once('includes/footer.php');?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <?php include_once('includes/footer2.php');?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script>
        // JavaScript to generate the monthly calendar
        document.addEventListener('DOMContentLoaded', function() {
            generateCalendar();
        });

        function generateCalendar() {
            const calendar = document.getElementById('calendar');
            const calendarHeader = document.getElementById('calendar-header');
            const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            const currentDate = new Date();
            const month = currentDate.getMonth();
            const year = currentDate.getFullYear();

            // Set calendar header to current month and year
            const monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
            calendarHeader.textContent = `${monthNames[month]} ${year}`;

            // Clear existing calendar
            calendar.innerHTML = '';

            // Add headers
            daysOfWeek.forEach(day => {
                const dayHeader = document.createElement('div');
                dayHeader.classList.add('calendar-day-header');
                dayHeader.textContent = day;
                calendar.appendChild(dayHeader);
            });

            // Calculate the first day of the month
            const firstDay = new Date(year, month, 1);
            const firstDayIndex = firstDay.getDay();

            // Calculate the number of days in the month
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Fill in the calendar days
            for (let i = 0; i < firstDayIndex; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.classList.add('calendar-day');
                calendar.appendChild(emptyCell);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dayCell = document.createElement('div');
                dayCell.classList.add('calendar-day');
                
                // Add day number
                const dayNumber = document.createElement('div');
                dayNumber.classList.add('day-number');
                dayNumber.textContent = day;
                dayCell.appendChild(dayNumber);

                // Add event card
                const eventCard = document.createElement('div');
                eventCard.classList.add('event-card');
                eventCard.textContent = `Event details for day ${day}`;
                dayCell.appendChild(eventCard);

                // Add classes for weekends
                const dayOfWeek = new Date(year, month, day).getDay();
                if (dayOfWeek === 0) {
                    dayCell.classList.add('sunday');
                } else if (dayOfWeek === 6) {
                    dayCell.classList.add('saturday');
                }

                // Add event listener for clicking on a day
                dayCell.addEventListener('click', () => {
                    alert('You clicked on day ' + day);
                });

                calendar.appendChild(dayCell);
            }
        }
    </script>

</body>

</html>
<?php } ?>
