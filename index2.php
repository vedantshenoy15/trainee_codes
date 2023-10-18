<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SERVER DATA</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!--<link rel="stylesheet" type="text/css" href="styles.css">-->
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">SERVER DATA</h1>
</div>

<?php
// Database connection parameters
$hostname = "localhost:3306";
$username = "root";
$password = "vedant";
$database = "test";

// Create a connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define SQL queries for each table
//$sql_static = "SELECT * FROM static";
$sql_ground = "SELECT * FROM network_info";
$sql_aaa = "SELECT * FROM aaa";
$sql_dhcp = "SELECT * FROM dhcp_leases";
$sql_static2 = "SELECT * FROM static2";

// Execute the queries
//$result_static = $conn->query($sql_static);
$result_ground = $conn->query($sql_ground);
$result_aaa = $conn->query($sql_aaa);
$result_dhcp = $conn->query($sql_dhcp);
$result_static2 = $conn->query($sql_static2);

// Arrays to store IP addresses
$staticIpAddresses = [];
$dhcpIpAddresses = [];
?>
<!-- Static Table -->
<!--
<div class="container mt-4">
    <h2>Static IP Address List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Device Name</th>
                <th>MAC Address</th>
                <th>IP Address</th>
                <th>Subnet Mask</th>
                <th>Default Gateway</th>
                <th>Location</th>
                 Add other columns if necessary
            </tr>
        </thead>
        <tbody>
            <?php
            /*
            while ($row = $result_static->fetch_assoc()) {
                $staticIpAddresses[] = $row["ip_add"];
                echo "<tr>";

                // Check if any of the required fields are empty
                $emptyFields = false;
                $requiredFields = ["device_name", "mac_add", "ip_add", "subnet_mask", "gateway_ip", "location"];
                foreach ($requiredFields as $field) {
                    if (empty($row[$field])) {
                        $emptyFields = true;
                        break;
                    }
                }

                // If any of the required fields are empty, print a message
                if (empty($row["mac_add"]) && !empty($row["ip_add"])) {
                    echo "<td>" . $row["device_name"] . "</td>";
                    echo "<td><b><p>No MAC Address <br>Possible Rogue User</p></b></td>";
                    echo "<td>" . $row["ip_add"] . "</td>";
                    echo "<td>" . $row["subnet_mask"] . "</td>";
                    echo "<td>" . $row["gateway_ip"] . "</td>";
                    echo "<td>" . $row["location"] . "</td>";
                } else {
                    echo "<td>" . $row["device_name"] . "</td>";
                    echo "<td>" . $row["mac_add"] . "</td>";
                    echo "<td>" . $row["ip_add"] . "</td>";
                    echo "<td>" . $row["subnet_mask"] . "</td>";
                    echo "<td>" . $row["gateway_ip"] . "</td>";
                    echo "<td>" . $row["location"] . "</td>";
                    // Add other columns if necessary
                }

                echo "</tr>";
            }*/
            ?>
        </tbody>
    </table>
</div>
 Ground Table 
        -->
<div class="container mt-4">
    <h2>Ground Data</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sr No.</th>
                <th>IP Address</th>
                <th>MAC Address</th>
                <th>Ethernet Interface</th>
                <th>Network Interface</th>
                <th>Manufacturer</th>
                <th>Ping</th>
                <th>Hostname</th>
                <th>Ports</th>
                <th>Remark</th>
                <!-- Add other columns if necessary -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Create an array to store IP addresses and MAC addresses from the Ground table
            $groundData = [];

            while ($row = $result_ground->fetch_assoc()) {
                // Store IP addresses and MAC addresses from the Ground table in the array
                $groundData[] = [
                    'ip_add' => $row["ip_add"],
                    'mac_address' => $row["mac_address"]
                ];

                echo "<tr>";

                $emptyFields = false;
                $requiredFields = ["id", "ip_add", "mac_address", "ethernet_interface", "network_interface", "Manufacturer", "ping", "hostname", "ports"];
                foreach ($requiredFields as $field) {
                    if (empty($row[$field])) {
                        $emptyFields = true;
                        break;
                    }
                }

                // Check if MAC address is missing in the Ground table but present in both Static and DHCP tables
                if (!empty($row["ip_add"]) && empty($row["mac_address"]) &&
                in_array($row["ip_add"], $staticIpAddresses) && in_array($row["ip_add"], $dhcpIpAddresses)) {
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["ip_add"] . "</td>";
                echo "<td>" . $row["mac_address"] . "</td>";
                echo "<td>" . $row["ethernet_interface"] . "</td>";
                echo "<td>" . $row["network_interface"] . "</td>";
                echo "<td>" . $row["Manufacturer"] . "</td>";
                echo "<td>" . $row["ping"] . "</td>";
                echo "<td>" . $row["hostname"] . "</td>";
                echo "<td>" . $row["ports"] . "</td>";
                echo "<td><b>MAC Address not found (Unauthorized User)</b></td>";
            }  
                          
                else {
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["ip_add"] . "</td>";
                    echo "<td>" . $row["mac_address"] . "</td>";
                    echo "<td>" . $row["ethernet_interface"] . "</td>";
                    echo "<td>" . $row["network_interface"] . "</td>";
                    echo "<td>" . $row["Manufacturer"] . "</td>";
                    echo "<td>" . $row["ping"] . "</td>";
                    echo "<td>" . $row["hostname"] . "</td>";
                    echo "<td>" . $row["ports"] . "</td>";
                    // Check if MAC address is missing in Ground, Static, and DHCP tables
                    $macAddressMissingInAllTables = empty($row["mac_address"]) && 
                        !in_array($row["ip_add"], $staticIpAddresses) && 
                        !in_array($row["ip_add"], $dhcpIpAddresses);
                        
                    if ($macAddressMissingInAllTables) {
                        echo "<td><b>MAC Address not found anywhere (Possible Rogue User)</b></td>";
                    } else {
                        echo "<td></td>"; // Leave the Remark column empty
                    }
                }

                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- AAA Server Table -->
<div class="container mt-4">
    <h2>AAA Server</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Username</th>
                <th>Authentication Date & Time</th>
                <th>Authentication Status</th>
                <th>Authorization Date & Time</th>
                <th>Authorization Status</th>
                <th>Access Control List</th>
                <th>Client IP Address</th>
                <th>Session ID</th>
                <!-- Add other columns if necessary -->
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result_aaa->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["username"] . "</td>";
                echo "<td>" . $row["auth_date_time"] . "</td>";
                echo "<td>" . $row["auth_status"] . "</td>";
                echo "<td>" . $row["authoriz_date_time"] . "</td>";
                echo "<td>" . $row["author_status"] . "</td>";
                echo "<td>" . $row["acl"] . "</td>";
                echo "<td>" . $row["ip_add"] . "</td>";
                echo "<td>" . $row["session_id"] . "</td>";
                // Add other columns if necessary
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div class="container mt-4">
    <h2>Static 2 Server</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>IP Address</th>
                <th>Hostname</th>
                <th>Mac Address</th>
                <th>Location</th>
                <th>Project Details</th>
                <th>User</th>
                <th>Date of Issue</th>
                <th>Date of Surrender</th>
                <th>Remarks</th>
                <!-- Add other columns if necessary -->
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result_static2->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ip_add"] . "</td>";
                echo "<td>" . $row["hostname"] . "</td>";
                echo "<td>" . $row["mac_add"] . "</td>";
                echo "<td>" . $row["location"] . "</td>";
                echo "<td>" . $row["project_details"] . "</td>";
                echo "<td>" . $row["user"] . "</td>";
                echo "<td>" . $row["date_of_issue"] . "</td>";
                echo "<td>" . $row["date_of_surrender"] . "</td>";
                echo "<td>" . $row["remarks"] . "</td>";

                // Add other columns if necessary
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- DHCP Table -->
<div class="container mt-4">
    <h2>DHCP Server</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sr No.</th>
                <th>Assigned IP Address</th>
                <th>Lease Start Time</th>
                <th>Lease End Time</th>
                <th>Time of Stop</th>
                <th>Client Last Transaction time</th>
                <th>Binding State</th>
                <th>Hardware Ethernet</th>
                <th>UID</th>
                <!-- Add other columns if necessary -->
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result_dhcp->fetch_assoc()) {
                $dhcpIpAddresses[] = $row["ip_address"];

                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["ip_address"] . "</td>";
                echo "<td>" . $row["start_time"] . "</td>";
                echo "<td>" . $row["end_time"] . "</td>";
                echo "<td>" . $row["tstp"] . "</td>";
                echo "<td>" . $row["cltt"] . "</td>";
                echo "<td>" . $row["binding_state"] . "</td>";
                echo "<td>" . $row["hardware_ethernet"] . "</td>";
                echo "<td>" . $row["uid"] . "</td>";
                
                // Add other columns if necessary
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <br>
    <br>
</div>

<?php
// Close the database connection
$conn->close();
?>

<!-- Add Bootstrap JS and jQuery (optional) if needed -->
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
-->

<!-- Semantic UI -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
</body>
</html>
