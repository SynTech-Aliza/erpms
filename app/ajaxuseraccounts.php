<?php
require_once '../config/database.php'; // your DB connection

header('Content-Type: application/json'); // JSON response for AJAX

// User Accounts
$userlimit = 10;
$userpage = isset($_GET['userpage']) ? (int)$_GET['userpage'] : 1;
if ($userpage < 1) $userpage = 1;
$userstart = ($userpage - 1) * $userlimit;

$whereUser = "";
if (isset($_POST['username']) && !empty($_POST['username'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $whereUser = "WHERE `user_FirstName` = '$username'";
} elseif (isset($_GET['userrole'])) {
    $userrole = $_GET['userrole'];
    $whereUser = ($userrole === 'Administrator') ? "WHERE `user_Role` = 1" : "WHERE `user_Role` = 2";
} elseif (isset($_GET['userstatus'])) {
    $userstatus = $_GET['userstatus'];
    $whereUser = ($userstatus === 'Active') ? "WHERE `user_Status` = 1" : "WHERE `user_Status` = 0";
}

// Count total entries
$getcountuser = mysqli_query($connection, "SELECT COUNT(*) AS total FROM rpms_users $whereUser");
$resultcountuser = mysqli_fetch_assoc($getcountuser);
$totaluserentries = $resultcountuser['total'];
$totaluserpages = ceil($totaluserentries / $userlimit);

// Get all users for current page
$getallusers = "SELECT * FROM rpms_users $whereUser ORDER BY `user_Registered` ASC LIMIT $userstart, $userlimit";
$resultallusers = mysqli_query($connection, $getallusers);

// Build table rows
$tableRows = '';
if (mysqli_num_rows($resultallusers) > 0) {
    $counter = $userstart + 1;
    while ($row = mysqli_fetch_assoc($resultallusers)) {
        $hashID = hash('sha256', $row['user_ID'] . 'SECRET_KEY');
        $profile = ($row['user_ProfilePicture'] == 'Default.png') 
                    ? '../public/assets/images/Default.png' 
                    : '../storage/profiles/' . $row['user_ProfilePicture'];
        $role = ($row['user_Role'] == 1) ? 'ADMINISTRATOR' : 'BSPO';
        $status = ($row['user_Status'] == 1) 
                    ? '<span class="badge badge-success">Active</span>' 
                    : '<span class="badge badge-danger">Inactive</span>';
        $fullname = $row['user_FirstName'] . ' ' . $row['user_MiddleName'] . ' ' . $row['user_LastName'];
        $registered = date('F d, Y h:i A', strtotime($row['user_Registered']));
        $tableRows .= "<tr onclick=\"window.location.href='viewuseraccount?u={$hashID}'\" style='cursor: pointer'>
            <td scope='row'>{$counter}</td>
            <td><img src='{$profile}' class='profile-header' alt='Profile Picture' /></td>
            <td>{$row['user_Username']}</td>
            <td>{$fullname}</td>
            <td>{$role}</td>
            <td>{$row['user_Appointed']}</td>
            <td>{$registered}</td>
            <td>{$status}</td>
        </tr>";
        $counter++;
    }
} else {
    $tableRows = '<tr><td colspan="8" class="text-center">No records found</td></tr>';
}

// Build pagination
$pagination = '<ul class="pagination">';

// Previous button
if ($userpage > 1) {
    $prev = $userpage - 1;
    $pagination .= "<li class='page-item'>
        <a class='page-link' href='?userpage={$prev}' data-page='{$prev}'>Previous</a>
    </li>";
}

// Page numbers
for ($i = 1; $i <= $totaluserpages; $i++) {
    $active = ($i == $userpage) ? 'active' : '';
    $pagination .= "<li class='page-item {$active}'>
        <a class='page-link' href='?userpage={$i}' data-page='{$i}'>{$i}</a>
    </li>";
}

// Next button
if ($userpage < $totaluserpages) {
    $next = $userpage + 1;
    $pagination .= "<li class='page-item'>
        <a class='page-link' href='?userpage={$next}' data-page='{$next}'>Next</a>
    </li>";
}

$pagination .= '</ul>';

// Return JSON for AJAX
echo json_encode([
    'table' => $tableRows,
    'pagination' => $pagination
]);
?>