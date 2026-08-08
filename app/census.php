<?php
    date_default_timezone_set('Asia/Manila');
    // Prevent browser caching
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    // Redirect to auth/403.php if session is missing
    if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
        header("Location: 403"); // <-- correct relative path
        exit();
    }

    // Current page
    $current_page = basename($_SERVER['PHP_SELF']);
    
    $user = $_SESSION['user'];

    // Get User Information
    $stmtUser = $connection->prepare(
        "SELECT * FROM rpms_users WHERE user_ID = ?"
    );
    $stmtUser->bind_param("i", $user);
    $stmtUser->execute();
    $resultUser = $stmtUser->get_result();
    if ($userRow = $resultUser->fetch_assoc()) {
        $id = $userRow['user_ID'];
        $hashUser = hash('sha256', $userRow['user_ID'] . 'SECRET_KEY');
        $profile = $userRow['user_ProfilePicture'];
        $firstname = $userRow['user_FirstName'];
        $middlename = $userRow['user_MiddleName'];
        $lastname = $userRow['user_LastName'];
        $appointed = $userRow['user_Appointed'];
        $role = $userRow['user_Role'];
    }

    // Get System Logo
    $stmtSL = $connection->prepare("SELECT setting_Value FROM rpms_settings WHERE setting_Key = 'system_logo'");
    $stmtSL->execute();
    $resultSL = $stmtSL->get_result();
    $systemlogo = $resultSL->fetch_assoc()['setting_Value'];

    // Load PhpSpreadsheet
    require '../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Fill;
    use PhpOffice\PhpSpreadsheet\Style\Border;
    use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
    use PhpOffice\PhpSpreadsheet\RichText\RichText;

// Residential Annual // 
    // Get Year Records
    $getresidentyearannual = "SELECT `rc_Year` FROM `rpms_residentcensus` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentcensus.resident_ID WHERE `rc_Census` = 'ANNUAL' AND resident_Barangay = '$appointed' GROUP BY `rc_Year` DESC";
    $resultresidentyearannual = mysqli_query($connection, $getresidentyearannual);

    // All Records
    $annualresidentlimit = 100; // Number of records per page
    $arpage = isset($_GET['arpage']) ? (int)$_GET['arpage'] : 1;
    if ($arpage < 1) $arpage = 1;
    $annualresidentstart = ($arpage - 1) * $annualresidentlimit;

    $whereAR = "WHERE `rc_Census` = 'ANNUAL' AND resident_Barangay = '$appointed'";
    if (isset($_POST['selectannualyear'])) {
        $whereAR = ($_POST['annualyear'] === 'All')
            ? "WHERE `rc_Census` = 'ANNUAL' AND resident_Barangay = '$appointed'"
            : "WHERE `rc_Census` = 'ANNUAL' AND resident_Barangay = '$appointed' AND `rc_Year` = '{$_POST['annualyear']}'";
    }
    
    // Count Entries
    $getarentries = mysqli_query($connection, "SELECT COUNT(*) AS total FROM rpms_residentcensus INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentcensus.resident_ID $whereAR");
    $resultarentries = mysqli_fetch_assoc($getarentries);
    $totalarentries = $resultarentries['total'];
    $totalarpages = ceil($totalarentries / $annualresidentlimit);

    // Get All Entries                                    
    $getannualresidententries = "SELECT * FROM `rpms_residentcensus` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentcensus.resident_ID $whereAR ORDER BY `rc_Year` DESC LIMIT $annualresidentstart, $annualresidentlimit";
    $resultannualresidententries = mysqli_query($connection, $getannualresidententries);

    // Delete Record
    if(isset($_GET['deletearrecord'])){
        $hashFromURL = $_GET['deletearrecord'];
        $sql = "SELECT * FROM rpms_residentcensus";
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $checkHash = hash('sha256', $row['rc_ID'] . 'SECRET_KEY');
            if ($checkHash === $hashFromURL) {
                $censusrecord = $row['rc_ID'];

                // Get Record Information
                $stmtRecord = $connection->prepare(
                    "SELECT * FROM `rpms_residentcensus` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentcensus.resident_ID WHERE `rc_ID` = ?"
                );
                $stmtRecord->bind_param("i", $censusrecord);
                $stmtRecord->execute();
                $resultRecord = $stmtRecord->get_result();
                if ($recordRow = $resultRecord->fetch_assoc()) {
                    $ridnumber = $recordRow['resident_IDNumber'];
                }

                $stmtDelete = $connection->prepare(
                    "DELETE FROM `rpms_residentcensus` WHERE `rc_ID` = ?"
                );
                $stmtDelete->bind_param("i", $censusrecord);
                if ($stmtDelete->execute()) {
                    // Create User Logs
                    $userid = $id;
                    $action = "DELETE";
                    $module = "RESIDENT CENSUS ANNUAL";
                    $recordid = $uid;
                    $description = "USER DELETED A CENSUS RECORD OF RESIDENT ".$ridnumber;
                    $ip = $_SERVER['REMOTE_ADDR'];
                    if($ip == '::1'){
                        $ipaddress = "LOCALHOST";
                    }else{
                        $ipaddress = $ip;
                    }
                    $useragent = strtoupper($_SERVER['HTTP_USER_AGENT']);
                    $created = date("Y-m-d H:i:s");

                    // Auto Increment Table
                    $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_userlogs");
                    $row = $stmtCheck->fetch_assoc();
                    if ($row['checktable'] == 0) {
                        $connection->query("ALTER TABLE rpms_userlogs AUTO_INCREMENT = 1");
                    }
                    // Insert User Logs
                    $stmtInsert = $connection->prepare("
                        INSERT INTO `rpms_userlogs`(`user_ID`, `userlogs_Action`, `userlogs_Module`, `userlogs_RecordID`, `userlogs_Description`, `userlogs_IPAddress`, `userlogs_Agent`, `userlogs_Created`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $stmtInsert->bind_param(
                        "ississss", 
                        $userid, 
                        $action, 
                        $module,   
                        $recordid, 
                        $description, 
                        $ipaddress, 
                        $useragent, 
                        $created);
                    $stmtInsert->execute();
                    $stmtInsert->close();

                    header("Location: residentcensusannual?notification=recorddeleted");
                    exit();
                } else {
                    header("Location: residentcensusannual?notification=recorddeleteerror");
                    exit();
                }
                $stmtDelete->close();
            }
        }
    }

    // Export Records
    if(isset($_POST['exportannualrecord'])){
        $annualyear = $_POST['annualyear'];

        $whereARExport = ($_POST['annualyear'] === 'All')
            ? "WHERE arc.rc_Census = 'ANNUAL' AND r.resident_Barangay = '$appointed' ORDER BY r.resident_IDNumber ASC"
            : "WHERE arc.rc_Census = 'ANNUAL' AND arc.rc_Year = '{$_POST['annualyear']}' AND r.resident_Barangay = '$appointed' ORDER BY r.resident_IDNumber ASC";

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // LEFT LOGO
        $leftLogo = new Drawing();
        $leftLogo->setName('Left Logo');
        $leftLogo->setDescription('Municipal Logo');
        $leftLogo->setPath('../public/assets/images/logo/BP-Logo.png');
        $leftLogo->setHeight(100);
        $leftLogo->setCoordinates('M1');
        $leftLogo->setOffsetX(5);
        $leftLogo->setOffsetY(5);
        $leftLogo->setWorksheet($sheet);

        // RIGHT LOGO
        $rightLogo = new Drawing();
        $rightLogo->setName('Right Logo');
        $rightLogo->setDescription('Provincial Logo');
        $rightLogo->setPath("../storage/logos/$systemlogo");
        $rightLogo->setHeight(100);
        $rightLogo->setCoordinates('O1');
        $rightLogo->setOffsetX(80);
        $rightLogo->setOffsetY(5);
        $rightLogo->setWorksheet($sheet);

        $headerTexts = [
            'Republic of the Philippines',
            'Province of Antique',
            'Municipality of Libertad Antique'
        ];
        $row = 1;
        foreach ($headerTexts as $text) {
            $sheet->setCellValue("A{$row}", $text);
            $sheet->mergeCells("A{$row}:Z{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setName('Times New Roman')->setSize(12);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        $sheet->setCellValue('A7', 'ANNUAL CENSUS OF RESIDENTS');
        $sheet->mergeCells('A7:Y7');
        $sheet->getStyle('A7')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        if($annualyear === 'All'){
            $title = "AS OF " . date("F d, Y");
        }
        else {
            $title = "FROM YEAR " . $annualyear;
        }
        $sheet->setCellValue('A8', strtoupper($title));
        $sheet->mergeCells('A8:Y8');
        $sheet->getStyle('A8')->getFont()->setName('Calibri')->setSize(12)->setBold(true);
        $sheet->getStyle('A8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Info's
        $infoTexts = [
            'Province' => 'ANTIQUE',
            'Municipality' => 'LIBERTAD',
            'Barangay' => $appointed,
            'Name of BSPO' => $firstname.' '.$middlename[0].'. '.$lastname
        ];

        $row = 10;
        foreach ($infoTexts as $label => $value) {
            $richText = new RichText();
            $richText->createText($label.': '); // normal
            $textRun = $richText->createTextRun($value); // bold value
            $textRun->getFont()->setBold(true);

            $sheet->setCellValue("A{$row}", $richText);
            $sheet->mergeCells("A{$row}:L{$row}");
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $row++;
        }

        // Table Headers
        $headers = [
            'No.', 'Date Recorded', 'Resident ID Number', 'First Name', 'Middle Name', 'Last Name', 'Suffix',
            'Date of Birth', 'Age', 'Gender', 'Street/Purok', 'Barangay', 'Municipality', 'Province',
            'Civil Status', 'Religion', 'Nationality', 'Contact Number', 'Email Address', 'Educational Attainment', 'Person with Disability', '4Ps Member', 'Occupation', 'Monthly Income', 'Employment Status'
        ];
        $sheet->fromArray($headers, NULL, 'A15');

        // Header style
        $sheet->getStyle('A15:Y15')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A15:Y15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:Y15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Columns with custom widths
        $customWidths = [
            'I' => 10,
            'T' => 30,
        ];

        // Apply widths B–AK
        foreach (range('B','Y') as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Optional: Column A
        $sheet->getColumnDimension('A')->setWidth(5);

        // Resident Annual List
        $result = mysqli_query($connection, "
            SELECT arc.rc_Created, r.resident_IDNumber, r.resident_FirstName, r.resident_MiddleName, r.resident_LastName, r.resident_Suffix, r.resident_DateofBirth, r.resident_Gender, r.resident_StreetPurok, r.resident_Barangay, r.resident_Municipality, r.resident_Province, r.resident_CivilStatus, r.resident_Religion, r.resident_Nationality, r.resident_ContactNumber, r.resident_EmailAddress, arc.rc_EducationAttainment, arc.rc_PWD, arc.rc_Fourps, arc.rc_Occupation, arc.rc_MonthlyIncome, arc.rc_EmployerStatus FROM rpms_residentcensus arc INNER JOIN rpms_residents r ON r.resident_ID = arc.resident_ID $whereARExport");

        $rowNum = 16; // Start after header
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            // Compute Age from Date of Birth
            $age = '';
            if (!empty($row['resident_DateofBirth'])) {
                $dob = new DateTime($row['resident_DateofBirth']);
                $today = new DateTime();
                $age = $today->diff($dob)->y;
            }
            $sheet->setCellValue('A'.$rowNum, $counter);
            $sheet->setCellValue('B'.$rowNum,date('F j, Y h:i A', strtotime($row['rc_Created'])));
            $sheet->setCellValue('C'.$rowNum, $row['resident_IDNumber']);
            $sheet->setCellValue('D'.$rowNum, $row['resident_FirstName']);
            $sheet->setCellValue('E'.$rowNum, $row['resident_MiddleName']);
            $sheet->setCellValue('F'.$rowNum, $row['resident_LastName']);
            $sheet->setCellValue('G'.$rowNum, $row['resident_Suffix']);
            $sheet->setCellValue('H'.$rowNum,date('F j, Y', strtotime($row['resident_DateofBirth'])));
            $sheet->setCellValue('I'.$rowNum, $age);
            $sheet->setCellValue('J'.$rowNum, $row['resident_Gender']);
            $sheet->setCellValue('K'.$rowNum, $row['resident_StreetPurok']);
            $sheet->setCellValue('L'.$rowNum, $row['resident_Barangay']);
            $sheet->setCellValue('M'.$rowNum, $row['resident_Municipality']);
            $sheet->setCellValue('N'.$rowNum, $row['resident_Province']);
            $sheet->setCellValue('O'.$rowNum, $row['resident_CivilStatus']);
            $sheet->setCellValue('P'.$rowNum, $row['resident_Religion']);
            $sheet->setCellValue('Q'.$rowNum, $row['resident_Nationality']);
            $sheet->setCellValue('R'.$rowNum, $row['resident_ContactNumber']);
            $sheet->setCellValue('S'.$rowNum, $row['resident_EmailAddress']);
            $sheet->setCellValue('T'.$rowNum, $row['rc_EducationAttainment']);
            $sheet->setCellValue('U'.$rowNum, $row['rc_PWD'] ? 'YES' : 'NO');
            $sheet->setCellValue('V'.$rowNum, $row['rc_Fourps'] ? 'YES' : 'NO');
            $sheet->setCellValue('W'.$rowNum, $row['rc_Occupation']);
            $sheet->setCellValue('X'.$rowNum, $row['rc_MonthlyIncome']);
            $sheet->getStyle('X'.$rowNum)->getNumberFormat()->setFormatCode('"₱"#,##0');
            $sheet->setCellValue('Y'.$rowNum, $row['rc_EmployerStatus']);
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // // Alignments
        $sheet->getStyle('A16:Y'.$lastRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Center numeric columns (example: No., Household Size, Total Residents)
        // Adjust these as needed
        $sheet->getStyle('A16:A'.$lastRow)->getAlignment()->setHorizontal('center');

        // Borders
        $sheet->getStyle('A15:Y'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A16');

        // Export
        $filename = "Annual_Resident_Census_".ucfirst(strtolower($appointed)).".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

// Residential MidYear //
    // Get Year Records
    $getresidentyearmidyear = "SELECT `rc_Year` FROM `rpms_residentcensus` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentcensus.resident_ID WHERE `rc_Census` = 'MID-YEAR' AND resident_Barangay = '$appointed' GROUP BY `rc_Year` DESC";
    $resultresidentyearmidyear = mysqli_query($connection, $getresidentyearmidyear);

    // All Records
    $midyearresidentlimit = 100; // Number of records per page
    $myrpage = isset($_GET['myrpage']) ? (int)$_GET['myrpage'] : 1;
    if ($myrpage < 1) $myrpage = 1;
    $midyearresidentstart = ($myrpage - 1) * $midyearresidentlimit;

    $whereMYR = "WHERE `rc_Census` = 'MID-YEAR' AND resident_Barangay = '$appointed'";
    if (isset($_POST['selectmidyear'])) {
        $whereMYR = ($_POST['midyear'] === 'All')
            ? "WHERE `rc_Census` = 'MID-YEAR' AND resident_Barangay = '$appointed'"
            : "WHERE `rc_Census` = 'MID-YEAR' AND resident_Barangay = '$appointed' AND `rc_Year` = '{$_POST['midyear']}'";
    }
    
    // Count Entries
    $getmyrentries = mysqli_query($connection, "SELECT COUNT(*) AS total FROM rpms_residentcensus INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentcensus.resident_ID $whereMYR");
    $resultmyrentries = mysqli_fetch_assoc($getmyrentries);
    $totalmyrentries = $resultmyrentries['total'];
    $totalmyrpages = ceil($totalmyrentries / $midyearresidentlimit);

    // Get All Entries                                       
    $getmidyearresidententries = "SELECT * FROM `rpms_residentcensus` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentcensus.resident_ID $whereMYR ORDER BY `rc_Year` DESC LIMIT $midyearresidentstart, $midyearresidentlimit";
    $resultmidyearresidententries = mysqli_query($connection, $getmidyearresidententries);

    // Delete Record
    if(isset($_GET['deletemyrrecord'])){
        $hashFromURL = $_GET['deletemyrrecord'];
        $sql = "SELECT * FROM rpms_residentcensus";
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $checkHash = hash('sha256', $row['rc_ID'] . 'SECRET_KEY');
            if ($checkHash === $hashFromURL) {
                $censusrecord = $row['rc_ID'];

                // Get Record Information
                $stmtRecord = $connection->prepare(
                    "SELECT * FROM `rpms_residentcensus` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentcensus.resident_ID WHERE `rc_ID` = ?"
                );
                $stmtRecord->bind_param("i", $censusrecord);
                $stmtRecord->execute();
                $resultRecord = $stmtRecord->get_result();
                if ($recordRow = $resultRecord->fetch_assoc()) {
                    $ridnumber = $recordRow['resident_IDNumber'];
                }

                $stmtDelete = $connection->prepare(
                    "DELETE FROM `rpms_residentcensus` WHERE `rc_ID` = ?"
                );
                $stmtDelete->bind_param("i", $censusrecord);
                if ($stmtDelete->execute()) {
                    // Create User Logs
                    $userid = $id;
                    $action = "DELETE";
                    $module = "RESIDENT CENSUS MIDYEAR";
                    $recordid = $uid;
                    $description = "USER DELETED A CENSUS RECORD OF RESIDENT ".$ridnumber;
                    $ip = $_SERVER['REMOTE_ADDR'];
                    if($ip == '::1'){
                        $ipaddress = "LOCALHOST";
                    }else{
                        $ipaddress = $ip;
                    }
                    $useragent = strtoupper($_SERVER['HTTP_USER_AGENT']);
                    $created = date("Y-m-d H:i:s");

                    // Auto Increment Table
                    $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_userlogs");
                    $row = $stmtCheck->fetch_assoc();
                    if ($row['checktable'] == 0) {
                        $connection->query("ALTER TABLE rpms_userlogs AUTO_INCREMENT = 1");
                    }
                    // Insert User Logs
                    $stmtInsert = $connection->prepare("
                        INSERT INTO `rpms_userlogs`(`user_ID`, `userlogs_Action`, `userlogs_Module`, `userlogs_RecordID`, `userlogs_Description`, `userlogs_IPAddress`, `userlogs_Agent`, `userlogs_Created`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $stmtInsert->bind_param(
                        "ississss", 
                        $userid, 
                        $action, 
                        $module,   
                        $recordid, 
                        $description, 
                        $ipaddress, 
                        $useragent, 
                        $created);
                    $stmtInsert->execute();
                    $stmtInsert->close();

                    header("Location: residentcensusmidyear?notification=recorddeleted");
                    exit();
                } else {
                    header("Location: residentcensusmidyear?notification=recorddeleteerror");
                    exit();
                }
                $stmtDelete->close();
            }
        }
    }

    // Export Records
    if(isset($_POST['exportmidyearrecord'])){
        $midyear = $_POST['midyear'];

        $whereMYRExport = ($_POST['midyear'] === 'All')
            ? "WHERE myrc.rc_Census = 'MID-YEAR' AND r.resident_Barangay = '$appointed' ORDER BY r.resident_IDNumber ASC"
            : "WHERE myrc.rc_Census = 'MID-YEAR' AND myrc.rc_Year = '{$_POST['midyear']}' AND r.resident_Barangay = '$appointed' ORDER BY r.resident_IDNumber ASC";

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // LEFT LOGO
        $leftLogo = new Drawing();
        $leftLogo->setName('Left Logo');
        $leftLogo->setDescription('Municipal Logo');
        $leftLogo->setPath('../public/assets/images/logo/BP-Logo.png');
        $leftLogo->setHeight(100);
        $leftLogo->setCoordinates('M1');
        $leftLogo->setOffsetX(5);
        $leftLogo->setOffsetY(5);
        $leftLogo->setWorksheet($sheet);

        // RIGHT LOGO
        $rightLogo = new Drawing();
        $rightLogo->setName('Right Logo');
        $rightLogo->setDescription('Provincial Logo');
        $rightLogo->setPath("../storage/logos/$systemlogo");
        $rightLogo->setHeight(100);
        $rightLogo->setCoordinates('O1');
        $rightLogo->setOffsetX(80);
        $rightLogo->setOffsetY(5);
        $rightLogo->setWorksheet($sheet);

        $headerTexts = [
            'Republic of the Philippines',
            'Province of Antique',
            'Municipality of Libertad Antique'
        ];
        $row = 1;
        foreach ($headerTexts as $text) {
            $sheet->setCellValue("A{$row}", $text);
            $sheet->mergeCells("A{$row}:Z{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setName('Times New Roman')->setSize(12);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        $sheet->setCellValue('A7', 'MIDYEAR CENSUS OF RESIDENTS');
        $sheet->mergeCells('A7:Y7');
        $sheet->getStyle('A7')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        if($midyear === 'All'){
            $title = "AS OF " . date("F d, Y");
        }
        else {
            $title = "FROM YEAR " . $midyear;
        }
        $sheet->setCellValue('A8', strtoupper($title));
        $sheet->mergeCells('A8:Y8');
        $sheet->getStyle('A8')->getFont()->setName('Calibri')->setSize(12)->setBold(true);
        $sheet->getStyle('A8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Info's
        $infoTexts = [
            'Province' => 'ANTIQUE',
            'Municipality' => 'LIBERTAD',
            'Barangay' => $appointed,
            'Name of BSPO' => $firstname.' '.$middlename[0].'. '.$lastname
        ];

        $row = 10;
        foreach ($infoTexts as $label => $value) {
            $richText = new RichText();
            $richText->createText($label.': '); // normal
            $textRun = $richText->createTextRun($value); // bold value
            $textRun->getFont()->setBold(true);

            $sheet->setCellValue("A{$row}", $richText);
            $sheet->mergeCells("A{$row}:L{$row}");
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $row++;
        }

        // Table Headers
        $headers = [
            'No.', 'Date Recorded', 'Resident ID Number', 'First Name', 'Middle Name', 'Last Name', 'Suffix',
            'Date of Birth', 'Age', 'Gender', 'Street/Purok', 'Barangay', 'Municipality', 'Province',
            'Civil Status', 'Religion', 'Nationality', 'Contact Number', 'Email Address', 'Educational Attainment', 'Person with Disability', '4Ps Member', 'Occupation', 'Monthly Income', 'Employment Status'
        ];
        $sheet->fromArray($headers, NULL, 'A15');

        // Header style
        $sheet->getStyle('A15:Y15')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A15:Y15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:Y15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Columns with custom widths
        $customWidths = [
            'I' => 10,
            'T' => 30,
        ];

        // Apply widths B–AK
        foreach (range('B','Y') as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Optional: Column A
        $sheet->getColumnDimension('A')->setWidth(5);

        // Resident Annual List
        $result = mysqli_query($connection, "
            SELECT myrc.rc_Created, r.resident_IDNumber, r.resident_FirstName, r.resident_MiddleName, r.resident_LastName, r.resident_Suffix, r.resident_DateofBirth, r.resident_Gender, r.resident_StreetPurok, r.resident_Barangay, r.resident_Municipality, r.resident_Province, r.resident_CivilStatus, r.resident_Religion, r.resident_Nationality, r.resident_ContactNumber, r.resident_EmailAddress, myrc.rc_EducationAttainment, myrc.rc_PWD, myrc.rc_Fourps, myrc.rc_Occupation, myrc.rc_MonthlyIncome, myrc.rc_EmployerStatus FROM rpms_residentcensus myrc INNER JOIN rpms_residents r ON r.resident_ID = myrc.resident_ID $whereMYRExport");

        $rowNum = 16; // Start after header
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            // Compute Age from Date of Birth
            $age = '';
            if (!empty($row['resident_DateofBirth'])) {
                $dob = new DateTime($row['resident_DateofBirth']);
                $today = new DateTime();
                $age = $today->diff($dob)->y;
            }
            $sheet->setCellValue('A'.$rowNum, $counter);
            $sheet->setCellValue('B'.$rowNum,date('F j, Y h:i A', strtotime($row['rc_Created'])));
            $sheet->setCellValue('C'.$rowNum, $row['resident_IDNumber']);
            $sheet->setCellValue('D'.$rowNum, $row['resident_FirstName']);
            $sheet->setCellValue('E'.$rowNum, $row['resident_MiddleName']);
            $sheet->setCellValue('F'.$rowNum, $row['resident_LastName']);
            $sheet->setCellValue('G'.$rowNum, $row['resident_Suffix']);
            $sheet->setCellValue('H'.$rowNum,date('F j, Y', strtotime($row['resident_DateofBirth'])));
            $sheet->setCellValue('I'.$rowNum, $age);
            $sheet->setCellValue('J'.$rowNum, $row['resident_Gender']);
            $sheet->setCellValue('K'.$rowNum, $row['resident_StreetPurok']);
            $sheet->setCellValue('L'.$rowNum, $row['resident_Barangay']);
            $sheet->setCellValue('M'.$rowNum, $row['resident_Municipality']);
            $sheet->setCellValue('N'.$rowNum, $row['resident_Province']);
            $sheet->setCellValue('O'.$rowNum, $row['resident_CivilStatus']);
            $sheet->setCellValue('P'.$rowNum, $row['resident_Religion']);
            $sheet->setCellValue('Q'.$rowNum, $row['resident_Nationality']);
            $sheet->setCellValue('R'.$rowNum, $row['resident_ContactNumber']);
            $sheet->setCellValue('S'.$rowNum, $row['resident_EmailAddress']);
            $sheet->setCellValue('T'.$rowNum, $row['rc_EducationAttainment']);
            $sheet->setCellValue('U'.$rowNum, $row['rc_PWD'] ? 'YES' : 'NO');
            $sheet->setCellValue('V'.$rowNum, $row['rc_Fourps'] ? 'YES' : 'NO');
            $sheet->setCellValue('W'.$rowNum, $row['rc_Occupation']);
            $sheet->setCellValue('X'.$rowNum, $row['rc_MonthlyIncome']);
            $sheet->getStyle('X'.$rowNum)->getNumberFormat()->setFormatCode('"₱"#,##0');
            $sheet->setCellValue('Y'.$rowNum, $row['rc_EmployerStatus']);
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // // Alignments
        $sheet->getStyle('A16:Y'.$lastRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Center numeric columns (example: No., Household Size, Total Residents)
        // Adjust these as needed
        $sheet->getStyle('A16:A'.$lastRow)->getAlignment()->setHorizontal('center');

        // Borders
        $sheet->getStyle('A15:Y'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A16');

        // Export
        $filename = "Midyear_Resident_Census_".ucfirst(strtolower($appointed)).".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

// Residential Disaster Related //
    // Get Year Records
    $getresidentyeardr = "SELECT `rdr_Year` FROM `rpms_residentdisasterrelated` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentdisasterrelated.resident_ID WHERE resident_Barangay = '$appointed' GROUP BY `rdr_Year` DESC";
    $resultresidentyeardr = mysqli_query($connection, $getresidentyeardr);

    // Get Disaster Records
    $getresidentdistaster = "SELECT `rdr_Name` FROM `rpms_residentdisasterrelated` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentdisasterrelated.resident_ID WHERE resident_Barangay = '$appointed' GROUP BY `rdr_Name` DESC";
    $resultresidentdistaster = mysqli_query($connection, $getresidentdistaster);

    // All Records
    $drresidentlimit = 100; // Number of records per page
    $drrpage = isset($_GET['drrpage']) ? (int)$_GET['drrpage'] : 1;
    if ($drrpage < 1) $drrpage = 1;
    $drresidentstart = ($drrpage - 1) * $drresidentlimit;

    $whereDRR = "WHERE resident_Barangay = '$appointed'";
    if (isset($_POST['selectdrrecords'])) {
        $disasteryear = $_POST['disasteryear'];
        $disastername = $_POST['disastername'];
        
        if ($disasteryear !== 'All') {
            $whereDRR .= " AND rdr_Year = '$disasteryear'";
        }

        if ($disastername !== 'All') {
            $whereDRR .= " AND rdr_Name = '$disastername'";
        }
    }

    // Count Entries
    $getdrrentries = mysqli_query($connection, "SELECT COUNT(*) AS total FROM `rpms_residentdisasterrelated` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentdisasterrelated.resident_ID $whereDRR");
    $resultdrrentries = mysqli_fetch_assoc($getdrrentries);
    $totaldrrentries = $resultdrrentries['total'];
    $totaldrrpages = ceil($totaldrrentries / $drresidentlimit);

    // Get All Entries                                       
    $getdrresidententries = "SELECT * FROM `rpms_residentdisasterrelated` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentdisasterrelated.resident_ID $whereDRR ORDER BY `rdr_Year` DESC LIMIT $drresidentstart, $drresidentlimit";
    $resultdrresidententries = mysqli_query($connection, $getdrresidententries);

    // Delete Record
    if(isset($_GET['deletedrrecord'])){
        $hashFromURL = $_GET['deletedrrecord'];
        $sql = "SELECT * FROM rpms_residentdisasterrelated";
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $checkHash = hash('sha256', $row['rdr_ID'] . 'SECRET_KEY');
            if ($checkHash === $hashFromURL) {
                $censusrecord = $row['rdr_ID'];

                // Get Record Information
                $stmtRecord = $connection->prepare(
                    "SELECT * FROM `rpms_residentdisasterrelated` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentdisasterrelated.resident_ID WHERE `rdr_ID` = ?"
                );
                $stmtRecord->bind_param("i", $censusrecord);
                $stmtRecord->execute();
                $resultRecord = $stmtRecord->get_result();
                if ($recordRow = $resultRecord->fetch_assoc()) {
                    $ridnumber = $recordRow['resident_IDNumber'];
                }

                $stmtDelete = $connection->prepare(
                    "DELETE FROM `rpms_residentdisasterrelated` WHERE `rdr_ID` = ?"
                );
                $stmtDelete->bind_param("i", $censusrecord);
                if ($stmtDelete->execute()) {
                    // Create User Logs
                    $userid = $id;
                    $action = "DELETE";
                    $module = "RESIDENT CENSUS DISASTER RELATED";
                    $recordid = $uid;
                    $description = "USER DELETED A CENSUS RECORD OF RESIDENT ".$ridnumber;
                    $ip = $_SERVER['REMOTE_ADDR'];
                    if($ip == '::1'){
                        $ipaddress = "LOCALHOST";
                    }else{
                        $ipaddress = $ip;
                    }
                    $useragent = strtoupper($_SERVER['HTTP_USER_AGENT']);
                    $created = date("Y-m-d H:i:s");

                    // Auto Increment Table
                    $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_userlogs");
                    $row = $stmtCheck->fetch_assoc();
                    if ($row['checktable'] == 0) {
                        $connection->query("ALTER TABLE rpms_userlogs AUTO_INCREMENT = 1");
                    }
                    // Insert User Logs
                    $stmtInsert = $connection->prepare("
                        INSERT INTO `rpms_userlogs`(`user_ID`, `userlogs_Action`, `userlogs_Module`, `userlogs_RecordID`, `userlogs_Description`, `userlogs_IPAddress`, `userlogs_Agent`, `userlogs_Created`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $stmtInsert->bind_param(
                        "ississss", 
                        $userid, 
                        $action, 
                        $module,   
                        $recordid, 
                        $description, 
                        $ipaddress, 
                        $useragent, 
                        $created);
                    $stmtInsert->execute();
                    $stmtInsert->close();

                    header("Location: residentcensusdisasterrelated?notification=recorddeleted");
                    exit();
                } else {
                    header("Location: residentcensusdisasterrelated?notification=recorddeleteerror");
                    exit();
                }
                $stmtDelete->close();
            }
        }
    }

    // Export Records
    if(isset($_POST['exportdrrecord'])){
        $disasteryear = $_POST['disasteryear'];
        $disastername = $_POST['disastername'];
        $whereDRRExport = "WHERE resident_Barangay = '$appointed'";

        if ($disasteryear !== 'All') {
            $whereDRRExport .= " AND rdr_Year = '$disasteryear'";
        }

        if ($disastername !== 'All') {
            $whereDRRExport .= " AND rdr_Name = '$disastername'";
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // LEFT LOGO
        $leftLogo = new Drawing();
        $leftLogo->setName('Left Logo');
        $leftLogo->setDescription('Municipal Logo');
        $leftLogo->setPath('../public/assets/images/logo/BP-Logo.png');
        $leftLogo->setHeight(100);
        $leftLogo->setCoordinates('M1');
        $leftLogo->setOffsetX(5);
        $leftLogo->setOffsetY(5);
        $leftLogo->setWorksheet($sheet);

        // RIGHT LOGO
        $rightLogo = new Drawing();
        $rightLogo->setName('Right Logo');
        $rightLogo->setDescription('Provincial Logo');
        $rightLogo->setPath("../storage/logos/$systemlogo");
        $rightLogo->setHeight(100);
        $rightLogo->setCoordinates('O1');
        $rightLogo->setOffsetX(80);
        $rightLogo->setOffsetY(5);
        $rightLogo->setWorksheet($sheet);

        $headerTexts = [
            'Republic of the Philippines',
            'Province of Antique',
            'Municipality of Libertad Antique'
        ];
        $row = 1;
        foreach ($headerTexts as $text) {
            $sheet->setCellValue("A{$row}", $text);
            $sheet->mergeCells("A{$row}:AC{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setName('Times New Roman')->setSize(12);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        $sheet->setCellValue('A7', 'DISASTER RELATED CENSUS OF RESIDENTS');
        $sheet->mergeCells('A7:AC7');
        $sheet->getStyle('A7')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        if ($disasteryear === 'All' || $disastername === 'All') {
            $title = "AS OF " . date("F d, Y");
        } else {
            $title = "FROM YEAR " . $disasteryear;
        }
        $sheet->setCellValue('A8', strtoupper($title));
        $sheet->mergeCells('A8:AC8');
        $sheet->getStyle('A8')->getFont()->setName('Calibri')->setSize(12)->setBold(true);
        $sheet->getStyle('A8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Info's
        $infoTexts = [
            'Province' => 'ANTIQUE',
            'Municipality' => 'LIBERTAD',
            'Barangay' => $appointed,
            'Name of BSPO' => $firstname.' '.$middlename[0].'. '.$lastname
        ];

        $row = 10;
        foreach ($infoTexts as $label => $value) {
            $richText = new RichText();
            $richText->createText($label.': '); // normal
            $textRun = $richText->createTextRun($value); // bold value
            $textRun->getFont()->setBold(true);

            $sheet->setCellValue("A{$row}", $richText);
            $sheet->mergeCells("A{$row}:L{$row}");
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $row++;
        }

        // Table Headers
        $headers = [
            'No.', 'Date Recorded', 'Resident ID Number', 'First Name', 'Middle Name', 'Last Name', 'Suffix',
            'Date of Birth', 'Age', 'Gender', 'Street/Purok', 'Barangay', 'Municipality', 'Province',
            'Civil Status', 'Religion', 'Nationality', 'Contact Number', 'Email Address', 'Disaster Name', 'Affected', 'Missing', 'Deceased', 'Displaced', 'Needs Medical Attention', 'Needs Food Assistance', 'Needs Shelter', 'Injury Status', 'Current Location'
        ];
        $sheet->fromArray($headers, NULL, 'A15');

        // Header style
        $sheet->getStyle('A15:AC15')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A15:AC15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:AC15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Columns with custom widths
        $customWidths = [
            'I'  => 10,
            'T'  => 30,
            'Y'  => 30,
            'Z'  => 30,
            'AC' => 30
        ];

        // Apply widths B–Z
        foreach (range('B','Z') as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Apply widths AA–AC
        foreach (['AA', 'AB', 'AC'] as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Optional: Column A
        $sheet->getColumnDimension('A')->setWidth(5);

        // Resident Disaster Related List
        $result = mysqli_query($connection, "
            SELECT drr.rdr_Created, r.resident_IDNumber, r.resident_FirstName, r.resident_MiddleName, r.resident_LastName, r.resident_Suffix, r.resident_DateofBirth, r.resident_Gender, r.resident_StreetPurok, r.resident_Barangay, r.resident_Municipality, r.resident_Province, r.resident_CivilStatus, r.resident_Religion, r.resident_Nationality, r.resident_ContactNumber, r.resident_EmailAddress, drr.rdr_Name, drr.rdr_Affected, drr.rdr_Missing, drr.rdr_Deceased, drr.rdr_Displaced, drr.rdr_NeedsMedicalAttention, drr.rdr_NeedsFoodAssistance, drr.rdr_NeedsShelter, drr.rdr_InjuryStatus, drr.rdr_CurrentLocation FROM `rpms_residentdisasterrelated` drr INNER JOIN rpms_residents r ON r.resident_ID = drr.resident_ID $whereDRRExport");

        $rowNum = 16; // Start after header
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            // Compute Age from Date of Birth
            $age = '';
            if (!empty($row['resident_DateofBirth'])) {
                $dob = new DateTime($row['resident_DateofBirth']);
                $today = new DateTime();
                $age = $today->diff($dob)->y;
            }
            $sheet->setCellValue('A'.$rowNum, $counter);
            $sheet->setCellValue('B'.$rowNum,date('F j, Y h:i A', strtotime($row['rdr_Created'])));
            $sheet->setCellValue('C'.$rowNum, $row['resident_IDNumber']);
            $sheet->setCellValue('D'.$rowNum, $row['resident_FirstName']);
            $sheet->setCellValue('E'.$rowNum, $row['resident_MiddleName']);
            $sheet->setCellValue('F'.$rowNum, $row['resident_LastName']);
            $sheet->setCellValue('G'.$rowNum, $row['resident_Suffix']);
            $sheet->setCellValue('H'.$rowNum,date('F j, Y', strtotime($row['resident_DateofBirth'])));
            $sheet->setCellValue('I'.$rowNum, $age);
            $sheet->setCellValue('J'.$rowNum, $row['resident_Gender']);
            $sheet->setCellValue('K'.$rowNum, $row['resident_StreetPurok']);
            $sheet->setCellValue('L'.$rowNum, $row['resident_Barangay']);
            $sheet->setCellValue('M'.$rowNum, $row['resident_Municipality']);
            $sheet->setCellValue('N'.$rowNum, $row['resident_Province']);
            $sheet->setCellValue('O'.$rowNum, $row['resident_CivilStatus']);
            $sheet->setCellValue('P'.$rowNum, $row['resident_Religion']);
            $sheet->setCellValue('Q'.$rowNum, $row['resident_Nationality']);
            $sheet->setCellValue('R'.$rowNum, $row['resident_ContactNumber']);
            $sheet->setCellValue('S'.$rowNum, $row['resident_EmailAddress']);
            $sheet->setCellValue('T'.$rowNum, $row['rdr_Name']);
            $sheet->setCellValue('U'.$rowNum, $row['rdr_Affected'] ? 'YES' : 'NO');
            $sheet->setCellValue('V'.$rowNum, $row['rdr_Missing'] ? 'YES' : 'NO');
            $sheet->setCellValue('W'.$rowNum, $row['rdr_Deceased'] ? 'YES' : 'NO');
            $sheet->setCellValue('X'.$rowNum, $row['rdr_Displaced'] ? 'YES' : 'NO');
            $sheet->setCellValue('Y'.$rowNum, $row['rdr_NeedsMedicalAttention'] ? 'YES' : 'NO');
            $sheet->setCellValue('Z'.$rowNum, $row['rdr_NeedsFoodAssistance'] ? 'YES' : 'NO');
            $sheet->setCellValue('AA'.$rowNum, $row['rdr_NeedsShelter'] ? 'YES' : 'NO');
            $sheet->setCellValue('AB'.$rowNum, $row['rdr_InjuryStatus']);
            $sheet->setCellValue('AC'.$rowNum, $row['rdr_CurrentLocation']);
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // Alignments
        $sheet->getStyle('A16:AC'.$lastRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Center numeric columns (example: No., Household Size, Total Residents)
        // Adjust these as needed
        $sheet->getStyle('A16:A'.$lastRow)->getAlignment()->setHorizontal('center');

        // Borders
        $sheet->getStyle('A15:AC'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A16');

        // Export
        $filename = "Disaster_Related_Resident_Census_".ucfirst(strtolower($appointed)).".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

// Residential Health Emergency //
    // Get Year Records
    $getresidentyearhe = "SELECT `rhe_Year` FROM `rpms_residenthealthemergency` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residenthealthemergency.resident_ID WHERE resident_Barangay = '$appointed' GROUP BY `rhe_Year` DESC";
    $resultresidentyearhe = mysqli_query($connection, $getresidentyearhe);

    // Get Health Emergency Records
    $getresidenthealthemergency = "SELECT `rhe_Name` FROM `rpms_residenthealthemergency` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residenthealthemergency.resident_ID WHERE resident_Barangay = '$appointed' GROUP BY `rhe_Name` DESC";
    $resultresidenthealthemergency = mysqli_query($connection, $getresidenthealthemergency);

    // All Records
    $heresidentlimit = 100; // Number of records per page
    $herpage = isset($_GET['herpage']) ? (int)$_GET['herpage'] : 1;
    if ($herpage < 1) $herpage = 1;
    $heresidentstart = ($herpage - 1) * $heresidentlimit;

    $whereHER = "WHERE resident_Barangay = '$appointed'";
    if (isset($_POST['selectherecords'])) {
        $heyear = $_POST['heyear'];
        $hename = $_POST['hename'];
        
        if ($heyear !== 'All') {
            $whereHER .= " AND rhe_Year = '$heyear'";
        }

        if ($hename !== 'All') {
            $whereHER .= " AND rhe_Name = '$hename'";
        }
    }

    // Count Entries
    $getherentries = mysqli_query($connection, "SELECT COUNT(*) AS total FROM `rpms_residenthealthemergency` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residenthealthemergency.resident_ID $whereHER");
    $resultherentries = mysqli_fetch_assoc($getherentries);
    $totalherentries = $resultherentries['total'];
    $totalherpages = ceil($totalherentries / $heresidentlimit);

    // Get All Entries                                       
    $getheresidententries = "SELECT * FROM `rpms_residenthealthemergency` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residenthealthemergency.resident_ID $whereHER ORDER BY `rhe_Year` DESC LIMIT $heresidentstart, $heresidentlimit";
    $resultheresidententries = mysqli_query($connection, $getheresidententries);

    // Delete Record
    if(isset($_GET['deleteherecord'])){
        $hashFromURL = $_GET['deleteherecord'];
        $sql = "SELECT * FROM rpms_residenthealthemergency";
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $checkHash = hash('sha256', $row['rhe_ID'] . 'SECRET_KEY');
            if ($checkHash === $hashFromURL) {
                $censusrecord = $row['rhe_ID'];

                // Get Record Information
                $stmtRecord = $connection->prepare(
                    "SELECT * FROM `rpms_residenthealthemergency` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residenthealthemergency.resident_ID WHERE `rhe_ID` = ?"
                );
                $stmtRecord->bind_param("i", $censusrecord);
                $stmtRecord->execute();
                $resultRecord = $stmtRecord->get_result();
                if ($recordRow = $resultRecord->fetch_assoc()) {
                    $ridnumber = $recordRow['resident_IDNumber'];
                }

                $stmtDelete = $connection->prepare(
                    "DELETE FROM `rpms_residenthealthemergency` WHERE `rhe_ID` = ?"
                );
                $stmtDelete->bind_param("i", $censusrecord);
                if ($stmtDelete->execute()) {
                    // Create User Logs
                    $userid = $id;
                    $action = "DELETE";
                    $module = "RESIDENT CENSUS HEALTH EMERGENCY";
                    $recordid = $uid;
                    $description = "USER DELETED A CENSUS RECORD OF RESIDENT ".$ridnumber;
                    $ip = $_SERVER['REMOTE_ADDR'];
                    if($ip == '::1'){
                        $ipaddress = "LOCALHOST";
                    }else{
                        $ipaddress = $ip;
                    }
                    $useragent = strtoupper($_SERVER['HTTP_USER_AGENT']);
                    $created = date("Y-m-d H:i:s");

                    // Auto Increment Table
                    $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_userlogs");
                    $row = $stmtCheck->fetch_assoc();
                    if ($row['checktable'] == 0) {
                        $connection->query("ALTER TABLE rpms_userlogs AUTO_INCREMENT = 1");
                    }
                    // Insert User Logs
                    $stmtInsert = $connection->prepare("
                        INSERT INTO `rpms_userlogs`(`user_ID`, `userlogs_Action`, `userlogs_Module`, `userlogs_RecordID`, `userlogs_Description`, `userlogs_IPAddress`, `userlogs_Agent`, `userlogs_Created`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $stmtInsert->bind_param(
                        "ississss", 
                        $userid, 
                        $action, 
                        $module,   
                        $recordid, 
                        $description, 
                        $ipaddress, 
                        $useragent, 
                        $created);
                    $stmtInsert->execute();
                    $stmtInsert->close();

                    header("Location: residentcensushealthemergency?notification=recorddeleted");
                    exit();
                } else {
                    header("Location: residentcensushealthemergency?notification=recorddeleteerror");
                    exit();
                }
                $stmtDelete->close();
            }
        }
    }

    // Export Records
    if(isset($_POST['exportherecord'])){
        $heyear = $_POST['heyear'];
        $hename = $_POST['hename'];
        $whereHER = "WHERE resident_Barangay = '$appointed'";

        if ($heyear !== 'All') {
            $whereHER .= " AND rhe_Year = '$heyear'";
        }

        if ($hename !== 'All') {
            $whereHER .= " AND rhe_Name = '$hename'";
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // LEFT LOGO
        $leftLogo = new Drawing();
        $leftLogo->setName('Left Logo');
        $leftLogo->setDescription('Municipal Logo');
        $leftLogo->setPath('../public/assets/images/logo/BP-Logo.png');
        $leftLogo->setHeight(100);
        $leftLogo->setCoordinates('M1');
        $leftLogo->setOffsetX(5);
        $leftLogo->setOffsetY(5);
        $leftLogo->setWorksheet($sheet);

        // RIGHT LOGO
        $rightLogo = new Drawing();
        $rightLogo->setName('Right Logo');
        $rightLogo->setDescription('Provincial Logo');
        $rightLogo->setPath("../storage/logos/$systemlogo");
        $rightLogo->setHeight(100);
        $rightLogo->setCoordinates('O1');
        $rightLogo->setOffsetX(80);
        $rightLogo->setOffsetY(5);
        $rightLogo->setWorksheet($sheet);

        $headerTexts = [
            'Republic of the Philippines',
            'Province of Antique',
            'Municipality of Libertad Antique'
        ];
        $row = 1;
        foreach ($headerTexts as $text) {
            $sheet->setCellValue("A{$row}", $text);
            $sheet->mergeCells("A{$row}:AB{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setName('Times New Roman')->setSize(12);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        $sheet->setCellValue('A7', 'HEALT EMERGENCY CENSUS OF RESIDENTS');
        $sheet->mergeCells('A7:AB7');
        $sheet->getStyle('A7')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        if ($heyear === 'All' || $hename === 'All') {
            $title = "AS OF " . date("F d, Y");
        } else {
            $title = "FROM YEAR " . $heyear;
        }
        $sheet->setCellValue('A8', strtoupper($title));
        $sheet->mergeCells('A8:AB8');
        $sheet->getStyle('A8')->getFont()->setName('Calibri')->setSize(12)->setBold(true);
        $sheet->getStyle('A8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Info's
        $infoTexts = [
            'Province' => 'ANTIQUE',
            'Municipality' => 'LIBERTAD',
            'Barangay' => $appointed,
            'Name of BSPO' => $firstname.' '.$middlename[0].'. '.$lastname
        ];

        $row = 10;
        foreach ($infoTexts as $label => $value) {
            $richText = new RichText();
            $richText->createText($label.': '); // normal
            $textRun = $richText->createTextRun($value); // bold value
            $textRun->getFont()->setBold(true);

            $sheet->setCellValue("A{$row}", $richText);
            $sheet->mergeCells("A{$row}:L{$row}");
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $row++;
        }

        // Table Headers
        $headers = [
            'No.', 'Date Recorded', 'Resident ID Number', 'First Name', 'Middle Name', 'Last Name', 'Suffix',
            'Date of Birth', 'Age', 'Gender', 'Street/Purok', 'Barangay', 'Municipality', 'Province',
            'Civil Status', 'Religion', 'Nationality', 'Contact Number', 'Email Address', 'Health Emergency', 'Symptoms', 'Under Monitoring', 'Symptom Details', 'Diagnosed Disease', 'Quarantine Status', 'Vaccination Status', 'Date Diagnosed', 'Recovery Status'
        ];
        $sheet->fromArray($headers, NULL, 'A15');

        // Header style
        $sheet->getStyle('A15:AB15')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A15:AB15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:AB15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Columns with custom widths
        $customWidths = [
            'I'  => 10,
            'T'  => 30,
            'Y'  => 30,
            'Z'  => 30,
        ];

        // Apply widths B–Z
        foreach (range('B','Z') as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Apply widths AA–AC
        foreach (['AA', 'AB'] as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Optional: Column A
        $sheet->getColumnDimension('A')->setWidth(5);

        // Resident Health Emergency List
        $result = mysqli_query($connection, "
            SELECT her.rhe_Created, r.resident_IDNumber, r.resident_FirstName, r.resident_MiddleName, r.resident_LastName, r.resident_Suffix, r.resident_DateofBirth, r.resident_Gender, r.resident_StreetPurok, r.resident_Barangay, r.resident_Municipality, r.resident_Province, r.resident_CivilStatus, r.resident_Religion, r.resident_Nationality, r.resident_ContactNumber, r.resident_EmailAddress, her.rhe_Name, her.rhe_Symptoms, her.rhe_UnderMonitoring, her.rhe_SymptomDetails, her.rhe_DiagnosedDisease, her.rhe_QuarantineStatus, her.rhe_VaccinationStatus, her.rhe_DateDiagnosed, her.rhe_RecoveryStatus FROM `rpms_residenthealthemergency` her INNER JOIN rpms_residents r ON r.resident_ID = her.resident_ID $whereHER");

        $rowNum = 16; // Start after header
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            // Compute Age from Date of Birth
            $age = '';
            if (!empty($row['resident_DateofBirth'])) {
                $dob = new DateTime($row['resident_DateofBirth']);
                $today = new DateTime();
                $age = $today->diff($dob)->y;
            }
            $sheet->setCellValue('A'.$rowNum, $counter);
            $sheet->setCellValue('B'.$rowNum,date('F j, Y h:i A', strtotime($row['rhe_Created'])));
            $sheet->setCellValue('C'.$rowNum, $row['resident_IDNumber']);
            $sheet->setCellValue('D'.$rowNum, $row['resident_FirstName']);
            $sheet->setCellValue('E'.$rowNum, $row['resident_MiddleName']);
            $sheet->setCellValue('F'.$rowNum, $row['resident_LastName']);
            $sheet->setCellValue('G'.$rowNum, $row['resident_Suffix']);
            $sheet->setCellValue('H'.$rowNum,date('F j, Y', strtotime($row['resident_DateofBirth'])));
            $sheet->setCellValue('I'.$rowNum, $age);
            $sheet->setCellValue('J'.$rowNum, $row['resident_Gender']);
            $sheet->setCellValue('K'.$rowNum, $row['resident_StreetPurok']);
            $sheet->setCellValue('L'.$rowNum, $row['resident_Barangay']);
            $sheet->setCellValue('M'.$rowNum, $row['resident_Municipality']);
            $sheet->setCellValue('N'.$rowNum, $row['resident_Province']);
            $sheet->setCellValue('O'.$rowNum, $row['resident_CivilStatus']);
            $sheet->setCellValue('P'.$rowNum, $row['resident_Religion']);
            $sheet->setCellValue('Q'.$rowNum, $row['resident_Nationality']);
            $sheet->setCellValue('R'.$rowNum, $row['resident_ContactNumber']);
            $sheet->setCellValue('S'.$rowNum, $row['resident_EmailAddress']);
            $sheet->setCellValue('T'.$rowNum, $row['rhe_Name']);
            $sheet->setCellValue('U'.$rowNum, $row['rhe_Symptoms'] ? 'YES' : 'NO');
            $sheet->setCellValue('V'.$rowNum, $row['rhe_UnderMonitoring'] ? 'YES' : 'NO');
            $sheet->setCellValue('W'.$rowNum, $row['rhe_SymptomDetails']);
            $sheet->setCellValue('X'.$rowNum, $row['rhe_DiagnosedDisease']);
            $sheet->setCellValue('Y'.$rowNum, $row['rhe_QuarantineStatus']);
            $sheet->setCellValue('Z'.$rowNum, date('F j, Y', strtotime($row['rhe_VaccinationStatus'])));
            $sheet->setCellValue('AA'.$rowNum, $row['rhe_DateDiagnosed']);
            $sheet->setCellValue('AB'.$rowNum, $row['rhe_RecoveryStatus']);
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // Alignments
        $sheet->getStyle('A16:AB'.$lastRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Center numeric columns (example: No., Household Size, Total Residents)
        // Adjust these as needed
        $sheet->getStyle('A16:A'.$lastRow)->getAlignment()->setHorizontal('center');

        // Borders
        $sheet->getStyle('A15:AB'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A16');

        // Export
        $filename = "Health_Emergency_Resident_Census_".ucfirst(strtolower($appointed)).".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

// Residential Livelihood/ Economic Impact //
    // Get Year Records
    $getresidentyearlei = "SELECT `rlhei_Year` FROM `rpms_residentlivelihoodeconomicimpact` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentlivelihoodeconomicimpact.resident_ID WHERE resident_Barangay = '$appointed' GROUP BY `rlhei_Year` DESC";
    $resultresidentyearlei = mysqli_query($connection, $getresidentyearlei);

    // Get Program Records
    $getresidentlieprogram = "SELECT `rlhei_Name` FROM `rpms_residentlivelihoodeconomicimpact` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentlivelihoodeconomicimpact.resident_ID WHERE resident_Barangay = '$appointed' GROUP BY `rlhei_Name` DESC";
    $resultresidentlieprogram = mysqli_query($connection, $getresidentlieprogram);

    // All Records
    $leiresidentlimit = 100; // Number of records per page
    $lierpage = isset($_GET['lierpage']) ? (int)$_GET['lierpage'] : 1;
    if ($lierpage < 1) $lierpage = 1;
    $lieresidentstart = ($lierpage - 1) * $leiresidentlimit;

    $whereLIER = "WHERE resident_Barangay = '$appointed'";
    if (isset($_POST['selectleirecords'])) {
        $leiyear = $_POST['leiyear'];
        $leiname = $_POST['leiname'];
        
        if ($leiyear !== 'All') {
            $whereLIER .= " AND rlhei_Year = '$leiyear'";
        }

        if ($leiname !== 'All') {
            $whereLIER .= " AND rlhei_Name = '$leiname'";
        }
    }

    // Count Entries
    $getlieentries = mysqli_query($connection, "SELECT COUNT(*) AS total FROM `rpms_residentlivelihoodeconomicimpact` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentlivelihoodeconomicimpact.resident_ID $whereLIER");
    $resultlieentries = mysqli_fetch_assoc($getlieentries);
    $totallieentries = $resultlieentries['total'];
    $totalliepages = ceil($totallieentries / $leiresidentlimit);

    // Get All Entries                                       
    $getlieresidententries = "SELECT * FROM `rpms_residentlivelihoodeconomicimpact` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentlivelihoodeconomicimpact.resident_ID $whereLIER ORDER BY `rlhei_Year` DESC LIMIT $lieresidentstart, $leiresidentlimit";
    $resultlieresidententries = mysqli_query($connection, $getlieresidententries);

    // Delete Record
    if(isset($_GET['deletelierecord'])){
        $hashFromURL = $_GET['deletelierecord'];
        $sql = "SELECT * FROM rpms_residentlivelihoodeconomicimpact";
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $checkHash = hash('sha256', $row['rlhei_ID'] . 'SECRET_KEY');
            if ($checkHash === $hashFromURL) {
                $censusrecord = $row['rlhei_ID'];

                // Get Record Information
                $stmtRecord = $connection->prepare(
                    "SELECT * FROM `rpms_residentlivelihoodeconomicimpact` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentlivelihoodeconomicimpact.resident_ID WHERE `rlhei_ID` = ?"
                );
                $stmtRecord->bind_param("i", $censusrecord);
                $stmtRecord->execute();
                $resultRecord = $stmtRecord->get_result();
                if ($recordRow = $resultRecord->fetch_assoc()) {
                    $ridnumber = $recordRow['resident_IDNumber'];
                }

                $stmtDelete = $connection->prepare(
                    "DELETE FROM `rpms_residentlivelihoodeconomicimpact` WHERE `rlhei_ID` = ?"
                );
                $stmtDelete->bind_param("i", $censusrecord);
                if ($stmtDelete->execute()) {
                    // Create User Logs
                    $userid = $id;
                    $action = "DELETE";
                    $module = "RESIDENT CENSUS LIVELIHOOD/ ECONOMIC IMPACT";
                    $recordid = $uid;
                    $description = "USER DELETED A CENSUS RECORD OF RESIDENT ".$ridnumber;
                    $ip = $_SERVER['REMOTE_ADDR'];
                    if($ip == '::1'){
                        $ipaddress = "LOCALHOST";
                    }else{
                        $ipaddress = $ip;
                    }
                    $useragent = strtoupper($_SERVER['HTTP_USER_AGENT']);
                    $created = date("Y-m-d H:i:s");

                    // Auto Increment Table
                    $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_userlogs");
                    $row = $stmtCheck->fetch_assoc();
                    if ($row['checktable'] == 0) {
                        $connection->query("ALTER TABLE rpms_userlogs AUTO_INCREMENT = 1");
                    }
                    // Insert User Logs
                    $stmtInsert = $connection->prepare("
                        INSERT INTO `rpms_userlogs`(`user_ID`, `userlogs_Action`, `userlogs_Module`, `userlogs_RecordID`, `userlogs_Description`, `userlogs_IPAddress`, `userlogs_Agent`, `userlogs_Created`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $stmtInsert->bind_param(
                        "ississss", 
                        $userid, 
                        $action, 
                        $module,   
                        $recordid, 
                        $description, 
                        $ipaddress, 
                        $useragent, 
                        $created);
                    $stmtInsert->execute();
                    $stmtInsert->close();

                    header("Location: residentcensuslivelihoodeconomicimpact?notification=recorddeleted");
                    exit();
                } else {
                    header("Location: residentcensuslivelihoodeconomicimpact?notification=recorddeleteerror");
                    exit();
                }
                $stmtDelete->close();
            }
        }
    }

    // Export Records
    if(isset($_POST['exportleirecord'])){
        $leiyear = $_POST['leiyear'];
        $leiname = $_POST['leiname'];
        $whereLIER = "WHERE resident_Barangay = '$appointed'";

        if ($leiyear !== 'All') {
            $whereLIER .= " AND rlhei_Year = '$leiyear'";
        }

        if ($leiname !== 'All') {
            $whereLIER .= " AND rlhei_Name = '$leiname'";
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // LEFT LOGO
        $leftLogo = new Drawing();
        $leftLogo->setName('Left Logo');
        $leftLogo->setDescription('Municipal Logo');
        $leftLogo->setPath('../public/assets/images/logo/BP-Logo.png');
        $leftLogo->setHeight(100);
        $leftLogo->setCoordinates('M1');
        $leftLogo->setOffsetX(5);
        $leftLogo->setOffsetY(5);
        $leftLogo->setWorksheet($sheet);

        // RIGHT LOGO
        $rightLogo = new Drawing();
        $rightLogo->setName('Right Logo');
        $rightLogo->setDescription('Provincial Logo');
        $rightLogo->setPath("../storage/logos/$systemlogo");
        $rightLogo->setHeight(100);
        $rightLogo->setCoordinates('O1');
        $rightLogo->setOffsetX(80);
        $rightLogo->setOffsetY(5);
        $rightLogo->setWorksheet($sheet);

        $headerTexts = [
            'Republic of the Philippines',
            'Province of Antique',
            'Municipality of Libertad Antique'
        ];
        $row = 1;
        foreach ($headerTexts as $text) {
            $sheet->setCellValue("A{$row}", $text);
            $sheet->mergeCells("A{$row}:AB{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setName('Times New Roman')->setSize(12);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        $sheet->setCellValue('A7', 'LIVELIHOOD/ ECONOMIC IMPACT CENSUS OF RESIDENTS');
        $sheet->mergeCells('A7:AB7');
        $sheet->getStyle('A7')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        if ($leiyear === 'All' || $leiname === 'All') {
            $title = "AS OF " . date("F d, Y");
        } else {
            $title = "FROM YEAR " . $leiyear;
        }
        $sheet->setCellValue('A8', strtoupper($title));
        $sheet->mergeCells('A8:AB8');
        $sheet->getStyle('A8')->getFont()->setName('Calibri')->setSize(12)->setBold(true);
        $sheet->getStyle('A8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Info's
        $infoTexts = [
            'Province' => 'ANTIQUE',
            'Municipality' => 'LIBERTAD',
            'Barangay' => $appointed,
            'Name of BSPO' => $firstname.' '.$middlename[0].'. '.$lastname
        ];

        $row = 10;
        foreach ($infoTexts as $label => $value) {
            $richText = new RichText();
            $richText->createText($label.': '); // normal
            $textRun = $richText->createTextRun($value); // bold value
            $textRun->getFont()->setBold(true);

            $sheet->setCellValue("A{$row}", $richText);
            $sheet->mergeCells("A{$row}:L{$row}");
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $row++;
        }

        // Table Headers
        $headers = [
            'No.', 'Date Recorded', 'Resident ID Number', 'First Name', 'Middle Name', 'Last Name', 'Suffix',
            'Date of Birth', 'Age', 'Gender', 'Street/Purok', 'Barangay', 'Municipality', 'Province',
            'Civil Status', 'Religion', 'Nationality', 'Contact Number', 'Email Address', 'Program', 'Employment Status', 'Job Lost', 'Type of Work', 'Occupation', 'Monthly Income Before', 'Monthly Income After', 'Business Affected', 'Needs Livelihood Assistance'
        ];
        $sheet->fromArray($headers, NULL, 'A15');

        // Header style
        $sheet->getStyle('A15:AB15')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A15:AB15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:AB15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Columns with custom widths
        $customWidths = [
            'I'  => 10,
            'T'  => 30,
            'Y'  => 30,
            'Z'  => 30,
            'AB'  => 30,
        ];

        // Apply widths B–Z
        foreach (range('B','Z') as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Apply widths AA–AC
        foreach (['AA', 'AB'] as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Optional: Column A
        $sheet->getColumnDimension('A')->setWidth(5);

        // Resident Health Emergency List
        $result = mysqli_query($connection, "
            SELECT lei.rlhei_Created, r.resident_IDNumber, r.resident_FirstName, r.resident_MiddleName, r.resident_LastName, r.resident_Suffix, r.resident_DateofBirth, r.resident_Gender, r.resident_StreetPurok, r.resident_Barangay, r.resident_Municipality, r.resident_Province, r.resident_CivilStatus, r.resident_Religion, r.resident_Nationality, r.resident_ContactNumber, r.resident_EmailAddress, lei.rlhei_Name, lei.rlhei_EmploymentStatus, lei.rlhei_JobLost, lei.rlhei_TypeofWork, lei.rlhei_Occupation, lei.rlhei_MonthlyIncomeBefore, lei.rlhei_MonthlyIncomeAfter, lei.rlhei_BusinessAffected, lei.rlhei_NeedsLivelihoodAssistance FROM `rpms_residentlivelihoodeconomicimpact` lei INNER JOIN rpms_residents r ON r.resident_ID = lei.resident_ID $whereLIER");

        $rowNum = 16; // Start after header
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            // Compute Age from Date of Birth
            $age = '';
            if (!empty($row['resident_DateofBirth'])) {
                $dob = new DateTime($row['resident_DateofBirth']);
                $today = new DateTime();
                $age = $today->diff($dob)->y;
            }
            $sheet->setCellValue('A'.$rowNum, $counter);
            $sheet->setCellValue('B'.$rowNum,date('F j, Y h:i A', strtotime($row['rlhei_Created'])));
            $sheet->setCellValue('C'.$rowNum, $row['resident_IDNumber']);
            $sheet->setCellValue('D'.$rowNum, $row['resident_FirstName']);
            $sheet->setCellValue('E'.$rowNum, $row['resident_MiddleName']);
            $sheet->setCellValue('F'.$rowNum, $row['resident_LastName']);
            $sheet->setCellValue('G'.$rowNum, $row['resident_Suffix']);
            $sheet->setCellValue('H'.$rowNum,date('F j, Y', strtotime($row['resident_DateofBirth'])));
            $sheet->setCellValue('I'.$rowNum, $age);
            $sheet->setCellValue('J'.$rowNum, $row['resident_Gender']);
            $sheet->setCellValue('K'.$rowNum, $row['resident_StreetPurok']);
            $sheet->setCellValue('L'.$rowNum, $row['resident_Barangay']);
            $sheet->setCellValue('M'.$rowNum, $row['resident_Municipality']);
            $sheet->setCellValue('N'.$rowNum, $row['resident_Province']);
            $sheet->setCellValue('O'.$rowNum, $row['resident_CivilStatus']);
            $sheet->setCellValue('P'.$rowNum, $row['resident_Religion']);
            $sheet->setCellValue('Q'.$rowNum, $row['resident_Nationality']);
            $sheet->setCellValue('R'.$rowNum, $row['resident_ContactNumber']);
            $sheet->setCellValue('S'.$rowNum, $row['resident_EmailAddress']);
            $sheet->setCellValue('T'.$rowNum, $row['rlhei_Name']);
            $sheet->setCellValue('U'.$rowNum, $row['rlhei_EmploymentStatus']);
            $sheet->setCellValue('V'.$rowNum, $row['rlhei_JobLost'] ? 'YES' : 'NO');
            $sheet->setCellValue('W'.$rowNum, $row['rlhei_TypeofWork']);
            $sheet->setCellValue('X'.$rowNum, $row['rlhei_Occupation']);
            $sheet->setCellValue('Y'.$rowNum, $row['rlhei_MonthlyIncomeBefore']);
            $sheet->getStyle('Y'.$rowNum)->getNumberFormat()->setFormatCode('"₱"#,##0');
            $sheet->setCellValue('Z'.$rowNum, $row['rlhei_MonthlyIncomeAfter']);
            $sheet->getStyle('Z'.$rowNum)->getNumberFormat()->setFormatCode('"₱"#,##0');
            $sheet->setCellValue('AA'.$rowNum, $row['rlhei_BusinessAffected'] ? 'YES' : 'NO');
            $sheet->setCellValue('AB'.$rowNum, $row['rlhei_NeedsLivelihoodAssistance'] ? 'YES' : 'NO');
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // Alignments
        $sheet->getStyle('A16:AB'.$lastRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Center numeric columns (example: No., Household Size, Total Residents)
        // Adjust these as needed
        $sheet->getStyle('A16:A'.$lastRow)->getAlignment()->setHorizontal('center');

        // Borders
        $sheet->getStyle('A15:AB'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A16');

        // Export
        $filename = "Livelihood_Economic_Impact_Resident_Census_".ucfirst(strtolower($appointed)).".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

// Residential Social Assistance/ Beneficiary //
    // Get Year Records
    $getresidentyearsab = "SELECT `rsab_Year` FROM `rpms_residentsocialassistancebeneficiary` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentsocialassistancebeneficiary.resident_ID WHERE resident_Barangay = '$appointed' GROUP BY `rsab_Year` DESC";
    $resulttresidentyearsab = mysqli_query($connection, $getresidentyearsab);

    // Get Program Records
    $getresidentsabprogram = "SELECT `rsab_Name` FROM `rpms_residentsocialassistancebeneficiary` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentsocialassistancebeneficiary.resident_ID WHERE resident_Barangay = '$appointed' GROUP BY `rsab_Name` DESC";
    $resultresidentsabprogram = mysqli_query($connection, $getresidentsabprogram);

    // All Records
    $sabresidentlimit = 100; // Number of records per page
    $sabrpage = isset($_GET['sabrpage']) ? (int)$_GET['sabrpage'] : 1;
    if ($sabrpage < 1) $sabrpage = 1;
    $sabresidentstart = ($sabrpage - 1) * $sabresidentlimit;

    $whereSABR = "WHERE resident_Barangay = '$appointed'";
    if (isset($_POST['selectsabrecords'])) {
        $sabyear = $_POST['sabyear'];
        $sabname = $_POST['sabname'];
        
        if ($sabyear !== 'All') {
            $whereSABR .= " AND rsab_Year = '$sabyear'";
        }

        if ($sabname !== 'All') {
            $whereSABR .= " AND rsab_Name = '$sabname'";
        }
    }

    // Count Entries
    $getsabentries = mysqli_query($connection, "SELECT COUNT(*) AS total FROM `rpms_residentsocialassistancebeneficiary` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentsocialassistancebeneficiary.resident_ID $whereSABR");
    $resultsabentries = mysqli_fetch_assoc($getsabentries);
    $totalsabentries = $resultsabentries['total'];
    $totalsabpages = ceil($totalsabentries / $sabresidentlimit);

    // Get All Entries                                       
    $getsabresidententries = "SELECT * FROM `rpms_residentsocialassistancebeneficiary` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentsocialassistancebeneficiary.resident_ID $whereSABR ORDER BY `rsab_Year` DESC LIMIT $sabresidentstart, $sabresidentlimit";
    $resultsabresidententries = mysqli_query($connection, $getsabresidententries);

    // Delete Record
    if(isset($_GET['deletesabrecord'])){
        $hashFromURL = $_GET['deletesabrecord'];
        $sql = "SELECT * FROM rpms_residentsocialassistancebeneficiary";
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $checkHash = hash('sha256', $row['rsab_ID'] . 'SECRET_KEY');
            if ($checkHash === $hashFromURL) {
                $censusrecord = $row['rsab_ID'];

                // Get Record Information
                $stmtRecord = $connection->prepare(
                    "SELECT * FROM `rpms_residentsocialassistancebeneficiary` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residentsocialassistancebeneficiary.resident_ID WHERE `rsab_ID` = ?"
                );
                $stmtRecord->bind_param("i", $censusrecord);
                $stmtRecord->execute();
                $resultRecord = $stmtRecord->get_result();
                if ($recordRow = $resultRecord->fetch_assoc()) {
                    $ridnumber = $recordRow['resident_IDNumber'];
                }

                $stmtDelete = $connection->prepare(
                    "DELETE FROM `rpms_residentsocialassistancebeneficiary` WHERE `rsab_ID` = ?"
                );
                $stmtDelete->bind_param("i", $censusrecord);
                if ($stmtDelete->execute()) {
                    // Create User Logs
                    $userid = $id;
                    $action = "DELETE";
                    $module = "RESIDENT CENSUS SOCIAL ASSISTANCE/ BENEFICIARY";
                    $recordid = $uid;
                    $description = "USER DELETED A CENSUS RECORD OF RESIDENT ".$ridnumber;
                    $ip = $_SERVER['REMOTE_ADDR'];
                    if($ip == '::1'){
                        $ipaddress = "LOCALHOST";
                    }else{
                        $ipaddress = $ip;
                    }
                    $useragent = strtoupper($_SERVER['HTTP_USER_AGENT']);
                    $created = date("Y-m-d H:i:s");

                    // Auto Increment Table
                    $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_userlogs");
                    $row = $stmtCheck->fetch_assoc();
                    if ($row['checktable'] == 0) {
                        $connection->query("ALTER TABLE rpms_userlogs AUTO_INCREMENT = 1");
                    }
                    // Insert User Logs
                    $stmtInsert = $connection->prepare("
                        INSERT INTO `rpms_userlogs`(`user_ID`, `userlogs_Action`, `userlogs_Module`, `userlogs_RecordID`, `userlogs_Description`, `userlogs_IPAddress`, `userlogs_Agent`, `userlogs_Created`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $stmtInsert->bind_param(
                        "ississss", 
                        $userid, 
                        $action, 
                        $module,   
                        $recordid, 
                        $description, 
                        $ipaddress, 
                        $useragent, 
                        $created);
                    $stmtInsert->execute();
                    $stmtInsert->close();

                    header("Location: residentcensussocialassistancebeneficiary?notification=recorddeleted");
                    exit();
                } else {
                    header("Location: residentcensussocialassistancebeneficiary?notification=recorddeleteerror");
                    exit();
                }
                $stmtDelete->close();
            }
        }
    }

    // Export Records
    if(isset($_POST['exportsabrecord'])){
        $sabyear = $_POST['sabyear'];
        $sabname = $_POST['sabname'];
        $whereSABR = "WHERE resident_Barangay = '$appointed'";

        if ($sabyear !== 'All') {
            $whereSABR .= " AND rsab_Year = '$sabyear'";
        }

        if ($sabname !== 'All') {
            $whereSABR .= " AND rsab_Name = '$sabname'";
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // LEFT LOGO
        $leftLogo = new Drawing();
        $leftLogo->setName('Left Logo');
        $leftLogo->setDescription('Municipal Logo');
        $leftLogo->setPath('../public/assets/images/logo/BP-Logo.png');
        $leftLogo->setHeight(100);
        $leftLogo->setCoordinates('M1');
        $leftLogo->setOffsetX(5);
        $leftLogo->setOffsetY(5);
        $leftLogo->setWorksheet($sheet);

        // RIGHT LOGO
        $rightLogo = new Drawing();
        $rightLogo->setName('Right Logo');
        $rightLogo->setDescription('Provincial Logo');
        $rightLogo->setPath("../storage/logos/$systemlogo");
        $rightLogo->setHeight(100);
        $rightLogo->setCoordinates('O1');
        $rightLogo->setOffsetX(80);
        $rightLogo->setOffsetY(5);
        $rightLogo->setWorksheet($sheet);

        $headerTexts = [
            'Republic of the Philippines',
            'Province of Antique',
            'Municipality of Libertad Antique'
        ];
        $row = 1;
        foreach ($headerTexts as $text) {
            $sheet->setCellValue("A{$row}", $text);
            $sheet->mergeCells("A{$row}:AA{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setName('Times New Roman')->setSize(12);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        $sheet->setCellValue('A7', 'LIVELIHOOD/ ECONOMIC IMPACT CENSUS OF RESIDENTS');
        $sheet->mergeCells('A7:AA7');
        $sheet->getStyle('A7')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        if ($sabyear === 'All' || $sabname === 'All') {
            $title = "AS OF " . date("F d, Y");
        } else {
            $title = "FROM YEAR " . $sabyear;
        }
        $sheet->setCellValue('A8', strtoupper($title));
        $sheet->mergeCells('A8:AA8');
        $sheet->getStyle('A8')->getFont()->setName('Calibri')->setSize(12)->setBold(true);
        $sheet->getStyle('A8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Info's
        $infoTexts = [
            'Province' => 'ANTIQUE',
            'Municipality' => 'LIBERTAD',
            'Barangay' => $appointed,
            'Name of BSPO' => $firstname.' '.$middlename[0].'. '.$lastname
        ];

        $row = 10;
        foreach ($infoTexts as $label => $value) {
            $richText = new RichText();
            $richText->createText($label.': '); // normal
            $textRun = $richText->createTextRun($value); // bold value
            $textRun->getFont()->setBold(true);

            $sheet->setCellValue("A{$row}", $richText);
            $sheet->mergeCells("A{$row}:L{$row}");
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $row++;
        }

        // Table Headers
        $headers = [
            'No.', 'Date Recorded', 'Resident ID Number', 'First Name', 'Middle Name', 'Last Name', 'Suffix',
            'Date of Birth', 'Age', 'Gender', 'Street/Purok', 'Barangay', 'Municipality', 'Province',
            'Civil Status', 'Religion', 'Nationality', 'Contact Number', 'Email Address', 'Program', '4Ps Beneficiary', 'Senior Citizen', 'Person with Disability', 'Solo Parent', 'Assistance Type', 'Amount Received', 'Date Received'
        ];
        $sheet->fromArray($headers, NULL, 'A15');

        // Header style
        $sheet->getStyle('A15:AA15')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A15:AA15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:AA15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Columns with custom widths
        $customWidths = [
            'I'  => 10,
            'T'  => 30,
            'Y'  => 30,
            'Z'  => 30,
        ];

        // Apply widths B–Z
        foreach (range('B','Z') as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Apply widths AA–AC
        foreach (['AA'] as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Optional: Column A
        $sheet->getColumnDimension('A')->setWidth(5);

        // Resident Health Emergency List
        $result = mysqli_query($connection, "
            SELECT sab.rsab_Created, r.resident_IDNumber, r.resident_FirstName, r.resident_MiddleName, r.resident_LastName, r.resident_Suffix, r.resident_DateofBirth, r.resident_Gender, r.resident_StreetPurok, r.resident_Barangay, r.resident_Municipality, r.resident_Province, r.resident_CivilStatus, r.resident_Religion, r.resident_Nationality, r.resident_ContactNumber, r.resident_EmailAddress, sab.rsab_Name, sab.rsab_4PsBeneficiary, sab.rsab_SeniorCitizen, sab.rsab_PersonwithDisability, sab.rsab_SoloParent, sab.rsab_AssistanceType, sab.rsab_AmountReceived, sab.rsab_DateReceived FROM `rpms_residentsocialassistancebeneficiary` sab INNER JOIN rpms_residents r ON r.resident_ID = sab.resident_ID $whereSABR");

        $rowNum = 16; // Start after header
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            // Compute Age from Date of Birth
            $age = '';
            if (!empty($row['resident_DateofBirth'])) {
                $dob = new DateTime($row['resident_DateofBirth']);
                $today = new DateTime();
                $age = $today->diff($dob)->y;
            }
            $sheet->setCellValue('A'.$rowNum, $counter);
            $sheet->setCellValue('B'.$rowNum,date('F j, Y h:i A', strtotime($row['rsab_Created'])));
            $sheet->setCellValue('C'.$rowNum, $row['resident_IDNumber']);
            $sheet->setCellValue('D'.$rowNum, $row['resident_FirstName']);
            $sheet->setCellValue('E'.$rowNum, $row['resident_MiddleName']);
            $sheet->setCellValue('F'.$rowNum, $row['resident_LastName']);
            $sheet->setCellValue('G'.$rowNum, $row['resident_Suffix']);
            $sheet->setCellValue('H'.$rowNum,date('F j, Y', strtotime($row['resident_DateofBirth'])));
            $sheet->setCellValue('I'.$rowNum, $age);
            $sheet->setCellValue('J'.$rowNum, $row['resident_Gender']);
            $sheet->setCellValue('K'.$rowNum, $row['resident_StreetPurok']);
            $sheet->setCellValue('L'.$rowNum, $row['resident_Barangay']);
            $sheet->setCellValue('M'.$rowNum, $row['resident_Municipality']);
            $sheet->setCellValue('N'.$rowNum, $row['resident_Province']);
            $sheet->setCellValue('O'.$rowNum, $row['resident_CivilStatus']);
            $sheet->setCellValue('P'.$rowNum, $row['resident_Religion']);
            $sheet->setCellValue('Q'.$rowNum, $row['resident_Nationality']);
            $sheet->setCellValue('R'.$rowNum, $row['resident_ContactNumber']);
            $sheet->setCellValue('S'.$rowNum, $row['resident_EmailAddress']);
            $sheet->setCellValue('T'.$rowNum, $row['rsab_Name']);
            $sheet->setCellValue('U'.$rowNum, $row['rsab_4PsBeneficiary'] ? 'YES' : 'NO');
            $sheet->setCellValue('V'.$rowNum, $row['rsab_SeniorCitizen'] ? 'YES' : 'NO');
            $sheet->setCellValue('W'.$rowNum, $row['rsab_PersonwithDisability'] ? 'YES' : 'NO');
            $sheet->setCellValue('X'.$rowNum, $row['rsab_SoloParent'] ? 'YES' : 'NO');
            $sheet->setCellValue('Y'.$rowNum, $row['rsab_AssistanceType']);
            $sheet->setCellValue('Z'.$rowNum, $row['rsab_AmountReceived']);
            $sheet->getStyle('Z'.$rowNum)->getNumberFormat()->setFormatCode('"₱"#,##0');
            $sheet->setCellValue('AA'.$rowNum, date('F j, Y', strtotime($row['rsab_DateReceived'])));
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // Alignments
        $sheet->getStyle('A16:AA'.$lastRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Center numeric columns (example: No., Household Size, Total Residents)
        // Adjust these as needed
        $sheet->getStyle('A16:A'.$lastRow)->getAlignment()->setHorizontal('center');

        // Borders
        $sheet->getStyle('A15:AA'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A16');

        // Export
        $filename = "Social_Assistance_BeneficiarY_Resident_Census_".ucfirst(strtolower($appointed)).".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

// Residential Education/ School Status //
    // Get Year Records
    $getresidentyearess = "SELECT `ress_Year` FROM `rpms_residenteducationschoolstatus` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residenteducationschoolstatus.resident_ID WHERE resident_Barangay = '$appointed' GROUP BY `ress_Year` DESC";
    $resultresidentyearess = mysqli_query($connection, $getresidentyearess);

    // Get Program Records
    $getresidentessprogram = "SELECT `ress_Name` FROM `rpms_residenteducationschoolstatus` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residenteducationschoolstatus.resident_ID WHERE resident_Barangay = '$appointed' GROUP BY `ress_Name` DESC";
    $resultresidentessprogram = mysqli_query($connection, $getresidentessprogram);

    // All Records
    $essresidentlimit = 1; // Number of records per page
    $essrpage = isset($_GET['essrpage']) ? (int)$_GET['essrpage'] : 1;
    if ($essrpage < 1) $essrpage = 1;
    $essresidentstart = ($essrpage - 1) * $essresidentlimit;

    $whereESSR = "WHERE resident_Barangay = '$appointed'";
    if (isset($_POST['selectessrecords'])) {
        $essyear = $_POST['essyear'];
        $essname = $_POST['essname'];
        
        if ($essyear !== 'All') {
            $whereESSR .= " AND ress_Year = '$essyear'";
        }

        if ($essname !== 'All') {
            $whereESSR .= " AND ress_Name = '$essname'";
        }
    }

    // Count Entries
    $getessentries = mysqli_query($connection, "SELECT COUNT(*) AS total FROM `rpms_residenteducationschoolstatus` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residenteducationschoolstatus.resident_ID $whereESSR");
    $resultessentries = mysqli_fetch_assoc($getessentries);
    $totalessentries = $resultessentries['total'];
    $totalesspages = ceil($totalessentries / $essresidentlimit);

    // Get All Entries                                       
    $getessresidententries = "SELECT * FROM `rpms_residenteducationschoolstatus` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residenteducationschoolstatus.resident_ID $whereESSR ORDER BY `ress_Year` DESC LIMIT $essresidentstart, $essresidentlimit";
    $resulttessresidententries = mysqli_query($connection, $getessresidententries);


    // Delete Record
    if(isset($_GET['deleteessrecord'])){
        $hashFromURL = $_GET['deleteessrecord'];
        $sql = "SELECT * FROM rpms_residenteducationschoolstatus";
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $checkHash = hash('sha256', $row['ress_ID'] . 'SECRET_KEY');
            if ($checkHash === $hashFromURL) {
                $censusrecord = $row['ress_ID'];

                // Get Record Information
                $stmtRecord = $connection->prepare(
                    "SELECT * FROM `rpms_residenteducationschoolstatus` INNER JOIN rpms_residents ON rpms_residents.resident_ID = rpms_residenteducationschoolstatus.resident_ID WHERE `ress_ID` = ?"
                );
                $stmtRecord->bind_param("i", $censusrecord);
                $stmtRecord->execute();
                $resultRecord = $stmtRecord->get_result();
                if ($recordRow = $resultRecord->fetch_assoc()) {
                    $ridnumber = $recordRow['resident_IDNumber'];
                }

                $stmtDelete = $connection->prepare(
                    "DELETE FROM `rpms_residenteducationschoolstatus` WHERE `ress_ID` = ?"
                );
                $stmtDelete->bind_param("i", $censusrecord);
                if ($stmtDelete->execute()) {
                    // Create User Logs
                    $userid = $id;
                    $action = "DELETE";
                    $module = "RESIDENT CENSUS EDUCATION/ SCHOOL STATUS ";
                    $recordid = $uid;
                    $description = "USER DELETED A CENSUS RECORD OF RESIDENT ".$ridnumber;
                    $ip = $_SERVER['REMOTE_ADDR'];
                    if($ip == '::1'){
                        $ipaddress = "LOCALHOST";
                    }else{
                        $ipaddress = $ip;
                    }
                    $useragent = strtoupper($_SERVER['HTTP_USER_AGENT']);
                    $created = date("Y-m-d H:i:s");

                    // Auto Increment Table
                    $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM rpms_userlogs");
                    $row = $stmtCheck->fetch_assoc();
                    if ($row['checktable'] == 0) {
                        $connection->query("ALTER TABLE rpms_userlogs AUTO_INCREMENT = 1");
                    }
                    // Insert User Logs
                    $stmtInsert = $connection->prepare("
                        INSERT INTO `rpms_userlogs`(`user_ID`, `userlogs_Action`, `userlogs_Module`, `userlogs_RecordID`, `userlogs_Description`, `userlogs_IPAddress`, `userlogs_Agent`, `userlogs_Created`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $stmtInsert->bind_param(
                        "ississss", 
                        $userid, 
                        $action, 
                        $module,   
                        $recordid, 
                        $description, 
                        $ipaddress, 
                        $useragent, 
                        $created);
                    $stmtInsert->execute();
                    $stmtInsert->close();

                    header("Location: residentcensuseducationalschoolstatus?notification=recorddeleted");
                    exit();
                } else {
                    header("Location: residentcensuseducationalschoolstatus?notification=recorddeleteerror");
                    exit();
                }
                $stmtDelete->close();
            }
        }
    }

    // Export Records
    if(isset($_POST['exportessrecord'])){
        $essyear = $_POST['essyear'];
        $essname = $_POST['essname'];
        $whereESSR = "WHERE resident_Barangay = '$appointed'";

        if ($essyear !== 'All') {
            $whereESSR .= " AND ress_Year = '$essyear'";
        }

        if ($essname !== 'All') {
            $whereESSR .= " AND ress_Name = '$essname'";
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // LEFT LOGO
        $leftLogo = new Drawing();
        $leftLogo->setName('Left Logo');
        $leftLogo->setDescription('Municipal Logo');
        $leftLogo->setPath('../public/assets/images/logo/BP-Logo.png');
        $leftLogo->setHeight(100);
        $leftLogo->setCoordinates('M1');
        $leftLogo->setOffsetX(5);
        $leftLogo->setOffsetY(5);
        $leftLogo->setWorksheet($sheet);

        // RIGHT LOGO
        $rightLogo = new Drawing();
        $rightLogo->setName('Right Logo');
        $rightLogo->setDescription('Provincial Logo');
        $rightLogo->setPath("../storage/logos/$systemlogo");
        $rightLogo->setHeight(100);
        $rightLogo->setCoordinates('O1');
        $rightLogo->setOffsetX(80);
        $rightLogo->setOffsetY(5);
        $rightLogo->setWorksheet($sheet);

        $headerTexts = [
            'Republic of the Philippines',
            'Province of Antique',
            'Municipality of Libertad Antique'
        ];
        $row = 1;
        foreach ($headerTexts as $text) {
            $sheet->setCellValue("A{$row}", $text);
            $sheet->mergeCells("A{$row}:Z{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setName('Times New Roman')->setSize(12);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        $sheet->setCellValue('A7', 'EDUCATION/ SCHOOL STATUS CENSUS OF RESIDENTS');
        $sheet->mergeCells('A7:Z7');
        $sheet->getStyle('A7')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        if ($essyear === 'All' || $essname === 'All') {
            $title = "AS OF " . date("F d, Y");
        } else {
            $title = "FROM YEAR " . $essyear;
        }
        $sheet->setCellValue('A8', strtoupper($title));
        $sheet->mergeCells('A8:Z8');
        $sheet->getStyle('A8')->getFont()->setName('Calibri')->setSize(12)->setBold(true);
        $sheet->getStyle('A8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Info's
        $infoTexts = [
            'Province' => 'ANTIQUE',
            'Municipality' => 'LIBERTAD',
            'Barangay' => $appointed,
            'Name of BSPO' => $firstname.' '.$middlename[0].'. '.$lastname
        ];

        $row = 10;
        foreach ($infoTexts as $label => $value) {
            $richText = new RichText();
            $richText->createText($label.': '); // normal
            $textRun = $richText->createTextRun($value); // bold value
            $textRun->getFont()->setBold(true);

            $sheet->setCellValue("A{$row}", $richText);
            $sheet->mergeCells("A{$row}:L{$row}");
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $row++;
        }

        // Table Headers
        $headers = [
            'No.', 'Date Recorded', 'Resident ID Number', 'First Name', 'Middle Name', 'Last Name', 'Suffix',
            'Date of Birth', 'Age', 'Gender', 'Street/Purok', 'Barangay', 'Municipality', 'Province',
            'Civil Status', 'Religion', 'Nationality', 'Contact Number', 'Email Address', 'Program', 'Currently Enrolled', 'School Name', 'Grade Level', 'Mode of Learning', 'Dropped Out', 'Needs Educational Support'
        ];
        $sheet->fromArray($headers, NULL, 'A15');

        // Header style
        $sheet->getStyle('A15:Z15')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A15:Z15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:Z15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Columns with custom widths
        $customWidths = [
            'I'  => 10,
            'T'  => 30,
            'Y'  => 30,
            'Z'  => 30,
        ];

        // Apply widths B–Z
        foreach (range('B','Z') as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Optional: Column A
        $sheet->getColumnDimension('A')->setWidth(5);

        // Resident Health Emergency List
        $result = mysqli_query($connection, "
            SELECT ess.ress_Created, r.resident_IDNumber, r.resident_FirstName, r.resident_MiddleName, r.resident_LastName, r.resident_Suffix, r.resident_DateofBirth, r.resident_Gender, r.resident_StreetPurok, r.resident_Barangay, r.resident_Municipality, r.resident_Province, r.resident_CivilStatus, r.resident_Religion, r.resident_Nationality, r.resident_ContactNumber, r.resident_EmailAddress,ess.ress_Name, ess.ress_CurrentlyEnrolled, ess.ress_SchoolName, ess.ress_GradeLevel, ess.ress_ModeofLearning, ess.ress_DroppedOut, ess.ress_NeedsEducationalSupport FROM `rpms_residenteducationschoolstatus` ess INNER JOIN rpms_residents r ON r.resident_ID = ess.resident_ID $whereESSR");

        $rowNum = 16; // Start after header
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            // Compute Age from Date of Birth
            $age = '';
            if (!empty($row['resident_DateofBirth'])) {
                $dob = new DateTime($row['resident_DateofBirth']);
                $today = new DateTime();
                $age = $today->diff($dob)->y;
            }
            $sheet->setCellValue('A'.$rowNum, $counter);
            $sheet->setCellValue('B'.$rowNum,date('F j, Y h:i A', strtotime($row['ress_Created'])));
            $sheet->setCellValue('C'.$rowNum, $row['resident_IDNumber']);
            $sheet->setCellValue('D'.$rowNum, $row['resident_FirstName']);
            $sheet->setCellValue('E'.$rowNum, $row['resident_MiddleName']);
            $sheet->setCellValue('F'.$rowNum, $row['resident_LastName']);
            $sheet->setCellValue('G'.$rowNum, $row['resident_Suffix']);
            $sheet->setCellValue('H'.$rowNum,date('F j, Y', strtotime($row['resident_DateofBirth'])));
            $sheet->setCellValue('I'.$rowNum, $age);
            $sheet->setCellValue('J'.$rowNum, $row['resident_Gender']);
            $sheet->setCellValue('K'.$rowNum, $row['resident_StreetPurok']);
            $sheet->setCellValue('L'.$rowNum, $row['resident_Barangay']);
            $sheet->setCellValue('M'.$rowNum, $row['resident_Municipality']);
            $sheet->setCellValue('N'.$rowNum, $row['resident_Province']);
            $sheet->setCellValue('O'.$rowNum, $row['resident_CivilStatus']);
            $sheet->setCellValue('P'.$rowNum, $row['resident_Religion']);
            $sheet->setCellValue('Q'.$rowNum, $row['resident_Nationality']);
            $sheet->setCellValue('R'.$rowNum, $row['resident_ContactNumber']);
            $sheet->setCellValue('S'.$rowNum, $row['resident_EmailAddress']);
            $sheet->setCellValue('T'.$rowNum, $row['ress_Name']);
            $sheet->setCellValue('U'.$rowNum, $row['ress_CurrentlyEnrolled'] ? 'YES' : 'NO');
            $sheet->setCellValue('V'.$rowNum, $row['ress_SchoolName']);
            $sheet->setCellValue('W'.$rowNum, $row['ress_GradeLevel']);
            $sheet->setCellValue('X'.$rowNum, $row['ress_ModeofLearning']);
            $sheet->setCellValue('Y'.$rowNum, $row['ress_DroppedOut'] ? 'YES' : 'NO');
            $sheet->setCellValue('Z'.$rowNum, $row['ress_NeedsEducationalSupport'] ? 'YES' : 'NO');
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // Alignments
        $sheet->getStyle('A16:Z'.$lastRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Center numeric columns (example: No., Household Size, Total Residents)
        // Adjust these as needed
        $sheet->getStyle('A16:A'.$lastRow)->getAlignment()->setHorizontal('center');

        // Borders
        $sheet->getStyle('A15:Z'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A16');

        // Export
        $filename = "Education_School_Status_Resident_Census_".ucfirst(strtolower($appointed)).".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
?>