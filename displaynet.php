<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<title>IP MAC WEBPAGE</title>-->
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            text-align: center;
            font-size: 16px;
            background-color: #e8e6e9;
            padding: 18px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        table {
            margin: 0 auto;
            width: 70%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #425664;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #425664;
            color: #fff;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #425664;
            border: none;
        }
        .btn-primary:hover {
            background-color: #425664;
        }
        #search-container {
            margin-top: 20px;
            text-align: center;
            border: none;
        }
        #update-container, #nmap-container {
            margin-top: 30px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
        }
        form {
            margin-top: 10px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            background-color: #425664;
            border: none;
            color: #fff;
            padding: 10px 20px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #425664;
        }
        a {
            text-decoration: none;
            color: #425664;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body><!--
<div class="container">
   <h1>IP MAC WEBPAGE</h1>
</div>
-->
<!-- Navigation link to the second page -->

<div class="container">
    <h1>Network Information</h1>
<div class="container mt-4 text-center">
    <a href="index2.php" class="btn btn-primary">Server Data</a>
</div>
<!--
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Your Site Name</a>
     Add navigation links here 
    -->
<div id="search-container" class="container">
    <form method="post">
        <label for="search">Search IP Address or MAC Address or Manufacturer</label>
        <input type="text" id="search" name="search" placeholder="Enter item">
        <input type="submit" value="Search">
    </form>
    <a href="displaynet.php">Refresh</a>
<div id="update-container">
    <h2>Update Network Information</h2>
    <form action="update.php" method="post">
        <label for="ip_add">IP Address:</label>
        <input type="text" name="ip_add" id="ip_add">
        <br><div></div>
        <label for="mac_address">MAC Address:</label>
        <input type="text" name="mac_address" id="mac_address">
        <!-- Add other fields as needed for updating -->
        <input type="submit" value="Update">
    </form>
<div id="nmap-container" class="container">
    <h2>Nmap Scan</h2>
    <form action="nmap.php" method="post">
        <label for="ip_to_scan">IP Address to Scan:</label>
        <input type="text" name="ip_to_scan" id="ip_to_scan" placeholder="Enter IP Address">
        <input type="submit" value="Scan">
    </form>
</div>

<table border="1" class="container">
    <tr>
        <th>Sr.</th>
        <th>IP Address</th>
        <th>MAC Address</th>
        <th>Ethernet Interface</th>
        <th>Network Interface</th>
        <th>Manufacturer</th>
        <th>Ping</th>
        <th>Hostname</th>
        <th>Ports</th>
    </tr>
    <?php
    // Create a connection to the MySQL database
    $conn = new mysqli("localhost:3306", "root", "vedant", "test");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data from the database
    //isset for if var is null
    //post global variable used to collect form data after submitting form with post
    //_post used to pass variables
    if(isset($_POST['search'])){
        $searchTerm=$_POST['search'];
        $sql="SELECT * from network_info WHERE ip_add = '$searchTerm' OR mac_address = '$searchTerm' OR Manufacturer = '$searchTerm'";
    }else{
        $sql="SELECT * FROM network_info";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $count = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $count . "</td>";
            echo "<td>" . $row["ip_add"] . "</td>";
            echo "<td>" . $row["mac_address"] . "</td>";
            echo "<td>" . $row["ethernet_interface"] . "</td>";
            echo "<td>" . $row["network_interface"] . "</td>";
            echo "<td>" . $row["Manufacturer"] . "</td>";
            echo "<td>" . $row["ping"] . "</td>";
            echo "<td>" . $row["hostname"] . "</td>";
            echo "<td>" . $row["ports"] . "</td>";
            echo "</tr>";
            $count++;
        }
    } else {
        echo "<tr><td colspan='9'>No records found</td></tr>";
    }

    // Close the database connection
    $conn->close();
    ?>
    <br>
</table>

<!-- Add Bootstrap JS and jQuery (optional) if needed -->

</body>
</html>
