<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require('/home2/marcosri/connect.php');

//Start a session
session_start();
//If user is not logged in, reroute them to the login page
if (!isset($_SESSION['username'])) {
    header('location: login.php');
}
?>

<!doctype html>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">

<!--Title card for tab-->
<title>Admin Page</title>
</head>

<body>
<div class="container">
    <h1>Guestbook Summary Data</h1>
    <?php
        include 'nav.php';
    ?>
    <!-- Construct table to display a summary of dreamers that have submitted to the database, via the volunteer page-->
    <table id="myTable" class="display table table-striped ">
        <thead class="thead-dark">
        <?php
        //Create Query that selects the column names
        $columnSQL = "SELECT * FROM guestbook LIMIT 1";
        //Retrieve column names from database
        $columnResult = mysqli_query($cnxn, $columnSQL);
        //Iterate so long as we have data to pull
        while ($row = mysqli_fetch_assoc($columnResult)){
            //Construct the columns with the names
            echo "<tr>";
            //Iterate through the array and display each column name in a table head
            foreach ($row as $k => $v){
                echo "<th>$k</th>";
            }
            echo "</tr>";
        }
        ?>
        </thead>
        <tbody>
        <?php
        //Create query that selects data stored in each field and display the value each ethnicity rather than the key value
        $dataSQL = "SELECT * FROM guestbook";
        //Retrieve the data from the database
        $dataResult = mysqli_query($cnxn, $dataSQL);
        //Iterate so long as we have data to pull
        while ($row2 = mysqli_fetch_assoc($dataResult)){
            //Construct rows to insert retrieved data
            echo "<tr>";
            //Iterate through the array to display each data set related to each column
            foreach ($row2 as $k => $v){
                echo "<td>$v</td>";
            }
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<script src="//code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $('#myTable').DataTable( {
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Details for '+data[0]+' '+data[1];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        }
    } );
</script>

<p><a href="guestbook.html">Go back to Guestbook Form</a></p>
</body>
</html>