<?php
if(isset($_POST['ip_to_scan'])){
    $ip_to_scan = $_POST['ip_to_scan'];
    
    // Validate the IP address (you may want to improve this validation)
    if(filter_var($ip_to_scan, FILTER_VALIDATE_IP)){
        // Execute Nmap command
        $nmap_output = shell_exec("cd C:\Program Files (x86)\Nmap && nmap -A -T4 $ip_to_scan");
        
        // Display the Nmap output
        echo "<h2>Nmap Scan Output for IP: $ip_to_scan</h2>";
        echo "<pre>$nmap_output</pre>";
    }else{
        echo "<p>Invalid IP address.</p>";
    }
}else{
    echo "<p>IP address not specified.</p>";
}
?>
<!-- 
scan ip address
and take input in function to run in cmd
using shell_exec function to run shell commands in command prompt
display the output

-->
