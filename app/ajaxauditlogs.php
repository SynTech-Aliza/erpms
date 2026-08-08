<?php
require_once '../config/database.php'; // your DB connection

$whereAuditLogs = "";
if(isset($_GET['auditaction'])) {
    $auditaction = $_GET['auditaction'];
    $whereAuditLogs = "WHERE `userlogs_Action` = '$auditaction'";
}
$getallauditlogs = "SELECT * FROM `rpms_userlogs` LEFT JOIN rpms_users ON rpms_users.user_ID = rpms_userlogs.user_ID $whereAuditLogs ORDER BY `userlogs_Created` DESC";
$resultallauditlogs = mysqli_query($connection, $getallauditlogs);

if(mysqli_num_rows($resultallauditlogs) > 0){
    while($row = mysqli_fetch_array($resultallauditlogs)){
        echo "<tr>";
        echo "<td>".$row['user_FirstName']." ".$row['user_MiddleName']." ".$row['user_LastName']."</td>";

        // Action Badge
        switch ($row['userlogs_Action']) {
            case 'BACKUP': echo '<td><span class="badge badge-pink">Backup</span></td>'; break;
            case 'CREATE': echo '<td><span class="badge badge-success">Create</span></td>'; break;
            case 'DELETE': echo '<td><span class="badge badge-danger">Delete</span></td>'; break;
            case 'EXPORT': echo '<td><span class="badge badge-info">Export</span></td>'; break;
            case 'LOGIN': echo '<td><span class="badge badge-primary">Login</span></td>'; break;
            case 'LOGOUT': echo '<td><span class="badge badge-warning">Logout</span></td>'; break;
            case 'PASSWORD CHANGE': echo '<td><span class="badge badge-warning">Password Change</span></td>'; break;
            case 'REQUEST': echo '<td><span class="badge badge-info">Request</span></td>'; break;
            case 'UPDATE': echo '<td><span class="badge badge-primary">Update</span></td>'; break;
            case 'UPLOAD': echo '<td><span class="badge badge-success">Upload</span></td>'; break;
            default: echo '<td><span class="badge badge-dark">'.htmlspecialchars($row['userlogs_Action']).'</span></td>'; break;
        }

        echo "<td>".date('F d, Y h:i A',strtotime($row['userlogs_Created']))."</td>";
        echo "<td>".$row['userlogs_Description']."</td>";
        echo "<td>".$row['userlogs_Agent']."</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6' class='text-center'>No records found</td></tr>";
}
?>