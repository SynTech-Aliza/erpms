<?php
    session_start();
    require_once '../config/database.php'; // your DB connection
    date_default_timezone_set('Asia/Manila');
    
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

    // Household
    if (isset($_GET['bhousehold_excl'])) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // LEFT LOGO
        $leftLogo = new Drawing();
        $leftLogo->setName('Left Logo');
        $leftLogo->setDescription('Municipal Logo');
        $leftLogo->setPath('../public/assets/images/logo/BP-Logo.png');
        $leftLogo->setHeight(100);
        $leftLogo->setCoordinates('F1');
        $leftLogo->setOffsetX(5);
        $leftLogo->setOffsetY(5);
        $leftLogo->setWorksheet($sheet);

        // RIGHT LOGO
        $rightLogo = new Drawing();
        $rightLogo->setName('Right Logo');
        $rightLogo->setDescription('Provincial Logo');
        $rightLogo->setPath("../storage/logos/$systemlogo");
        $rightLogo->setHeight(100);
        $rightLogo->setCoordinates('H1');
        $rightLogo->setOffsetX(90);
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
            $sheet->mergeCells("A{$row}:L{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setName('Times New Roman')->setSize(12);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        $sheet->setCellValue('A7', 'HOUSEHOLD DIRECTORY');
        $sheet->mergeCells('A7:L7');
        $sheet->getStyle('A7')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A8',strtoupper('AS OF '.date("F d, Y")));;
        $sheet->mergeCells('A8:L8');
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
            'No.', 'Date Registered', 'Household ID Number', 'Street/Purok', 'Barangay', 
            'Municipality', 'Province', 'Household Type', 'Household Size', 
            'Household Condition', 'Head of Household', 'Total Residents'
        ];
        $sheet->fromArray($headers, NULL, 'A15');

        // Header style
        $sheet->getStyle('A15:L15')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A15:L15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:L15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        foreach (range('B','J') as $col) {
            $sheet->getColumnDimension($col)->setWidth(20);
        }
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->getColumnDimension('L')->setWidth(20);

        // Household List
        $result = mysqli_query($connection, "SELECT 
            h.household_Registered,
            h.household_IDNumber,
            h.household_StreetPurok,
            h.household_Barangay,
            h.household_Municipality,
            h.household_Province,
            h.household_Type,
            h.household_Size,
            h.household_Condition,
            CONCAT_WS(' ', r.resident_FirstName, r.resident_MiddleName, r.resident_LastName, NULLIF(r.resident_Suffix, 'N/A')) AS headofhousehold,
            (SELECT COUNT(*) FROM rpms_residents rr WHERE rr.household_ID = h.household_ID) AS totalresidents
            FROM rpms_households h
            LEFT JOIN rpms_residents r 
                ON h.household_ID = r.household_ID
                AND r.resident_HouseRole = 'HEAD OF HOUSEHOLD'
            WHERE h.household_Barangay = '$appointed'
            ORDER BY h.household_Registered ASC
        ");

        $rowNum = 16; // Start after header
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $sheet->setCellValue('A'.$rowNum, $counter);
            $sheet->setCellValue('B'.$rowNum, $row['household_Registered']);
            $sheet->setCellValue('C'.$rowNum, $row['household_IDNumber']);
            $sheet->setCellValue('D'.$rowNum, $row['household_StreetPurok']);
            $sheet->setCellValue('E'.$rowNum, $row['household_Barangay']);
            $sheet->setCellValue('F'.$rowNum, $row['household_Municipality']);
            $sheet->setCellValue('G'.$rowNum, $row['household_Province']);
            $sheet->setCellValue('H'.$rowNum, $row['household_Type']);
            $sheet->setCellValue('I'.$rowNum, $row['household_Size']);
            $sheet->setCellValue('J'.$rowNum, $row['household_Condition']);
            $sheet->setCellValue('K'.$rowNum, $row['headofhousehold']);
            $sheet->setCellValue('L'.$rowNum, $row['totalresidents']);
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // Alignments
        $sheet->getStyle('A16:L'.$lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        // Center numeric columns
        $sheet->getStyle('A16:A'.$lastRow)->getAlignment()->setHorizontal('center');

        // Borders
        $sheet->getStyle('A15:L'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A16');

        // Create User Logs
        $userid = $id;
        $action = "EXPORT";
        $module = "HOUSEHOLD MANAGEMENT";
        $recordid = "";
        $description = "USER EXPORTED HOUSEHOLD MASTER LIST";
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

        // Export
        $filename = "Household_Directory_".ucfirst(strtolower($appointed))."_" . date("YmdHis") . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }
  
    // Residence
    elseif (isset($_GET['bresidents_excl'])) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // LEFT LOGO
        $leftLogo = new Drawing();
        $leftLogo->setName('Left Logo');
        $leftLogo->setDescription('Municipal Logo');
        $leftLogo->setPath('../public/assets/images/logo/BP-Logo.png');
        $leftLogo->setHeight(100);
        $leftLogo->setCoordinates('R1');
        $leftLogo->setOffsetX(5);
        $leftLogo->setOffsetY(5);
        $leftLogo->setWorksheet($sheet);

        // RIGHT LOGO
        $rightLogo = new Drawing();
        $rightLogo->setName('Right Logo');
        $rightLogo->setDescription('Provincial Logo');
        $rightLogo->setPath("../storage/logos/$systemlogo");
        $rightLogo->setHeight(100);
        $rightLogo->setCoordinates('T1');
        $rightLogo->setOffsetX(100);
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
            $sheet->mergeCells("A{$row}:AK{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setName('Times New Roman')->setSize(12);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        $sheet->setCellValue('A7', 'RESIDENTS DIRECTORY');
        $sheet->mergeCells('A7:AK7');
        $sheet->getStyle('A7')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A8',strtoupper('AS OF '.date("F d, Y")));;
        $sheet->mergeCells('A8:AK8');
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
            'No.', 'Date Registered', 'Household ID Number', 'Resident ID Number', 'House Role', 
            'Resident Status', 'First Name', 'Middle Name', 'Last Name', 'Suffix',
            'Date of Birth', 'Age', 'Gender', 'Street/Purok', 'Barangay', 'Municipality', 'Province',
            'Civil Status', 'Religion', 'Nationality', 'Contact Number', 'Email Address', 'Education Attainment',
            'Height', 'Weight', 'Blood Type', 'Parent Status', 'PWD', 'FourPs', 'Indigenous',
            'Voter Status', 'ID Type', 'ID Type Number', 'Occupation', 'Employer/Business Name',
            'Monthly Income', 'Employer Status'
        ];
        $sheet->fromArray($headers, NULL, 'A15');

        // Header style
        $sheet->getStyle('A15:AK15')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A15:AK15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:AK15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Columns with custom widths
        $customWidths = [
            'L' => 10,
            'M' => 15,
            'V' => 20,
            'W' => 30,
            'X' => 10,
            'Y' => 10,
            'Z' => 10,
            'AB' => 10,
            'AC' => 10,
            'AD' => 10,
            'AI' => 30,
            'AK' => 30
        ];

        // Apply widths B–AK
        foreach (range('B','Z') as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Columns after Z: AA–AK
        foreach (range('A','K') as $col) {
            $column = 'A'.$col; // AA, AB, ..., AK
            $sheet->getColumnDimension($column)->setWidth($customWidths[$column] ?? 20);
        }

        // Optional: Column A
        $sheet->getColumnDimension('A')->setWidth(5);

        // Residents List
        $result = mysqli_query($connection, "
            SELECT 
                r.resident_Registered,
                h.household_IDNumber,
                r.resident_IDNumber,
                r.resident_HouseRole,
                r.resident_ResidentStatus,
                r.resident_FirstName,
                r.resident_MiddleName,
                r.resident_LastName,
                r.resident_Suffix,
                r.resident_DateofBirth,
                r.resident_Age,
                r.resident_Gender,
                r.resident_StreetPurok,
                r.resident_Barangay,
                r.resident_Municipality,
                r.resident_Province,
                r.resident_CivilStatus,
                r.resident_Religion,
                r.resident_Nationality,
                r.resident_ContactNumber,
                r.resident_EmailAddress,
                r.resident_EducationAttainment,
                r.resident_Height,
                r.resident_Weight,
                r.resident_BloodType,
                r.resident_ParentStatus,
                r.resident_PWD,
                r.resident_Fourps,
                r.resident_Indigenous,
                r.resident_VoterStatus,
                r.resident_IDType,
                r.resident_IDTypeNumber,
                r.resident_Occupation,
                r.resident_EmployerBusinessName,
                r.resident_MonthlyIncome,
                r.resident_EmployerStatus
            FROM rpms_residents r
            INNER JOIN rpms_households h ON h.household_ID = r.household_ID
            WHERE r.resident_Barangay = '$appointed'
            ORDER BY r.resident_Registered DESC
        ");

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
            $sheet->setCellValue('B'.$rowNum, $row['resident_Registered']);
            $sheet->setCellValue('C'.$rowNum, $row['household_IDNumber']);
            $sheet->setCellValue('D'.$rowNum, $row['resident_IDNumber']);
            $sheet->setCellValue('E'.$rowNum, $row['resident_HouseRole']);
            $sheet->setCellValue('F'.$rowNum, $row['resident_ResidentStatus']);
            $sheet->setCellValue('G'.$rowNum, $row['resident_FirstName']);
            $sheet->setCellValue('H'.$rowNum, $row['resident_MiddleName']);
            $sheet->setCellValue('I'.$rowNum, $row['resident_LastName']);
            $sheet->setCellValue('J'.$rowNum, $row['resident_Suffix']);
            $sheet->setCellValue('K'.$rowNum, $row['resident_DateofBirth']);
            $sheet->setCellValue('L'.$rowNum, $age);
            $sheet->setCellValue('M'.$rowNum, $row['resident_Gender']);
            $sheet->setCellValue('N'.$rowNum, $row['resident_StreetPurok']);
            $sheet->setCellValue('O'.$rowNum, $row['resident_Barangay']);
            $sheet->setCellValue('P'.$rowNum, $row['resident_Municipality']);
            $sheet->setCellValue('Q'.$rowNum, $row['resident_Province']);
            $sheet->setCellValue('R'.$rowNum, $row['resident_CivilStatus']);
            $sheet->setCellValue('S'.$rowNum, $row['resident_Religion']);
            $sheet->setCellValue('T'.$rowNum, $row['resident_Nationality']);
            $sheet->setCellValue('U'.$rowNum, $row['resident_ContactNumber']);
            $sheet->setCellValue('V'.$rowNum, $row['resident_EmailAddress']);
            $sheet->setCellValue('W'.$rowNum, $row['resident_EducationAttainment']);
            $sheet->setCellValue('X'.$rowNum, $row['resident_Height']);
            $sheet->setCellValue('Y'.$rowNum, $row['resident_Weight']);
            $sheet->setCellValue('Z'.$rowNum, $row['resident_BloodType']);
            $sheet->setCellValue('AA'.$rowNum, $row['resident_ParentStatus']);
            $sheet->setCellValue('AB'.$rowNum, $row['resident_PWD'] ? 'YES' : 'NO');
            $sheet->setCellValue('AC'.$rowNum, $row['resident_Fourps'] ? 'YES' : 'NO');
            $sheet->setCellValue('AD'.$rowNum, $row['resident_Indigenous'] ? 'YES' : 'NO');
            $sheet->setCellValue('AE'.$rowNum, $row['resident_VoterStatus']);
            $sheet->setCellValue('AF'.$rowNum, $row['resident_IDType']);
            $sheet->setCellValue('AG'.$rowNum, $row['resident_IDTypeNumber']);
            $sheet->setCellValue('AH'.$rowNum, $row['resident_Occupation']);
            $sheet->setCellValue('AI'.$rowNum, $row['resident_EmployerBusinessName']);
            $sheet->setCellValue('AJ'.$rowNum, $row['resident_MonthlyIncome']);
            $sheet->setCellValue('AK'.$rowNum, $row['resident_EmployerStatus']);
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // // Alignments
        $sheet->getStyle('A16:AK'.$lastRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Center numeric columns (example: No., Household Size, Total Residents)
        // Adjust these as needed
        $sheet->getStyle('A16:A'.$lastRow)->getAlignment()->setHorizontal('center');

        // Borders
        $sheet->getStyle('A15:AK'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A16');

        // Create User Logs
        $userid = $id;
        $action = "EXPORT";
        $module = "HOUSEHOLD MANAGEMENT";
        $recordid = "";
        $description = "USER EXPORTED HOUSEHOLD MASTER LIST";
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

        // Export
        $filename = "Residents_Directory_".ucfirst(strtolower($appointed))."_" . date("YmdHis") . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    // Senior Citizens
    elseif (isset($_GET['bseniors_excl'])){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // LEFT LOGO
        $leftLogo = new Drawing();
        $leftLogo->setName('Left Logo');
        $leftLogo->setDescription('Municipal Logo');
        $leftLogo->setPath('../public/assets/images/logo/BP-Logo.png');
        $leftLogo->setHeight(100);
        $leftLogo->setCoordinates('R1');
        $leftLogo->setOffsetX(5);
        $leftLogo->setOffsetY(5);
        $leftLogo->setWorksheet($sheet);

        // RIGHT LOGO
        $rightLogo = new Drawing();
        $rightLogo->setName('Right Logo');
        $rightLogo->setDescription('Provincial Logo');
        $rightLogo->setPath("../storage/logos/$systemlogo");
        $rightLogo->setHeight(100);
        $rightLogo->setCoordinates('T1');
        $rightLogo->setOffsetX(100);
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
            $sheet->mergeCells("A{$row}:AK{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setName('Times New Roman')->setSize(12);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        $sheet->setCellValue('A7', 'SENIOR CITIZENS');
        $sheet->mergeCells('A7:AK7');
        $sheet->getStyle('A7')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A8',strtoupper('AS OF '.date("F d, Y")));;
        $sheet->mergeCells('A8:AK8');
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
            'No.', 'Date Registered', 'Household ID Number', 'Resident ID Number', 'House Role', 
            'Resident Status', 'First Name', 'Middle Name', 'Last Name', 'Suffix',
            'Date of Birth', 'Age', 'Gender', 'Street/Purok', 'Barangay', 'Municipality', 'Province',
            'Civil Status', 'Religion', 'Nationality', 'Contact Number', 'Email Address', 'Education Attainment',
            'Height', 'Weight', 'Blood Type', 'Parent Status', 'PWD', 'FourPs', 'Indigenous',
            'Voter Status', 'ID Type', 'ID Type Number', 'Occupation', 'Employer/Business Name',
            'Monthly Income', 'Employer Status'
        ];
        $sheet->fromArray($headers, NULL, 'A15');

        // Header style
        $sheet->getStyle('A15:AK15')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A15:AK15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:AK15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Columns with custom widths
        $customWidths = [
            'L' => 10,
            'M' => 15,
            'V' => 20,
            'W' => 30,
            'X' => 10,
            'Y' => 10,
            'Z' => 10,
            'AB' => 10,
            'AC' => 10,
            'AD' => 10,
            'AI' => 30,
            'AK' => 30
        ];

        // Apply widths B–AK
        foreach (range('B','Z') as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Columns after Z: AA–AK
        foreach (range('A','K') as $col) {
            $column = 'A'.$col; // AA, AB, ..., AK
            $sheet->getColumnDimension($column)->setWidth($customWidths[$column] ?? 20);
        }

        // Optional: Column A
        $sheet->getColumnDimension('A')->setWidth(5);

        // Residents List
        $result = mysqli_query($connection, "
            SELECT 
                r.resident_Registered,
                h.household_IDNumber,
                r.resident_IDNumber,
                r.resident_HouseRole,
                r.resident_ResidentStatus,
                r.resident_FirstName,
                r.resident_MiddleName,
                r.resident_LastName,
                r.resident_Suffix,
                r.resident_DateofBirth,
                r.resident_Age,
                r.resident_Gender,
                r.resident_StreetPurok,
                r.resident_Barangay,
                r.resident_Municipality,
                r.resident_Province,
                r.resident_CivilStatus,
                r.resident_Religion,
                r.resident_Nationality,
                r.resident_ContactNumber,
                r.resident_EmailAddress,
                r.resident_EducationAttainment,
                r.resident_Height,
                r.resident_Weight,
                r.resident_BloodType,
                r.resident_ParentStatus,
                r.resident_PWD,
                r.resident_Fourps,
                r.resident_Indigenous,
                r.resident_VoterStatus,
                r.resident_IDType,
                r.resident_IDTypeNumber,
                r.resident_Occupation,
                r.resident_EmployerBusinessName,
                r.resident_MonthlyIncome,
                r.resident_EmployerStatus
            FROM rpms_residents r
            INNER JOIN rpms_households h ON h.household_ID = r.household_ID
            WHERE r.resident_Barangay = '$appointed' AND TIMESTAMPDIFF(YEAR, R.resident_DateofBirth, CURDATE()) >= 60 ORDER BY r.resident_Registered DESC
        ");

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
            $sheet->setCellValue('B'.$rowNum, $row['resident_Registered']);
            $sheet->setCellValue('C'.$rowNum, $row['household_IDNumber']);
            $sheet->setCellValue('D'.$rowNum, $row['resident_IDNumber']);
            $sheet->setCellValue('E'.$rowNum, $row['resident_HouseRole']);
            $sheet->setCellValue('F'.$rowNum, $row['resident_ResidentStatus']);
            $sheet->setCellValue('G'.$rowNum, $row['resident_FirstName']);
            $sheet->setCellValue('H'.$rowNum, $row['resident_MiddleName']);
            $sheet->setCellValue('I'.$rowNum, $row['resident_LastName']);
            $sheet->setCellValue('J'.$rowNum, $row['resident_Suffix']);
            $sheet->setCellValue('K'.$rowNum, $row['resident_DateofBirth']);
            $sheet->setCellValue('L'.$rowNum, $age);
            $sheet->setCellValue('M'.$rowNum, $row['resident_Gender']);
            $sheet->setCellValue('N'.$rowNum, $row['resident_StreetPurok']);
            $sheet->setCellValue('O'.$rowNum, $row['resident_Barangay']);
            $sheet->setCellValue('P'.$rowNum, $row['resident_Municipality']);
            $sheet->setCellValue('Q'.$rowNum, $row['resident_Province']);
            $sheet->setCellValue('R'.$rowNum, $row['resident_CivilStatus']);
            $sheet->setCellValue('S'.$rowNum, $row['resident_Religion']);
            $sheet->setCellValue('T'.$rowNum, $row['resident_Nationality']);
            $sheet->setCellValue('U'.$rowNum, $row['resident_ContactNumber']);
            $sheet->setCellValue('V'.$rowNum, $row['resident_EmailAddress']);
            $sheet->setCellValue('W'.$rowNum, $row['resident_EducationAttainment']);
            $sheet->setCellValue('X'.$rowNum, $row['resident_Height']);
            $sheet->setCellValue('Y'.$rowNum, $row['resident_Weight']);
            $sheet->setCellValue('Z'.$rowNum, $row['resident_BloodType']);
            $sheet->setCellValue('AA'.$rowNum, $row['resident_ParentStatus']);
            $sheet->setCellValue('AB'.$rowNum, $row['resident_PWD'] ? 'YES' : 'NO');
            $sheet->setCellValue('AC'.$rowNum, $row['resident_Fourps'] ? 'YES' : 'NO');
            $sheet->setCellValue('AD'.$rowNum, $row['resident_Indigenous'] ? 'YES' : 'NO');
            $sheet->setCellValue('AE'.$rowNum, $row['resident_VoterStatus']);
            $sheet->setCellValue('AF'.$rowNum, $row['resident_IDType']);
            $sheet->setCellValue('AG'.$rowNum, $row['resident_IDTypeNumber']);
            $sheet->setCellValue('AH'.$rowNum, $row['resident_Occupation']);
            $sheet->setCellValue('AI'.$rowNum, $row['resident_EmployerBusinessName']);
            $sheet->setCellValue('AJ'.$rowNum, $row['resident_MonthlyIncome']);
            $sheet->setCellValue('AK'.$rowNum, $row['resident_EmployerStatus']);
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // // Alignments
        $sheet->getStyle('A16:AK'.$lastRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Center numeric columns (example: No., Household Size, Total Residents)
        // Adjust these as needed
        $sheet->getStyle('A16:A'.$lastRow)->getAlignment()->setHorizontal('center');

        // Borders
        $sheet->getStyle('A15:AK'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A16');

        // Create User Logs
        $userid = $id;
        $action = "EXPORT";
        $module = "SENIOR CITIZENS";
        $recordid = "";
        $description = "USER EXPORTED SENIOR CITIZENS LIST";
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

        // Export
        $filename = "Senior_Citizens_".ucfirst(strtolower($appointed))."_" . date("YmdHis") . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    // PWD
    elseif (isset($_GET['bpwd_excl'])){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // LEFT LOGO
        $leftLogo = new Drawing();
        $leftLogo->setName('Left Logo');
        $leftLogo->setDescription('Municipal Logo');
        $leftLogo->setPath('../public/assets/images/logo/BP-Logo.png');
        $leftLogo->setHeight(100);
        $leftLogo->setCoordinates('R1');
        $leftLogo->setOffsetX(5);
        $leftLogo->setOffsetY(5);
        $leftLogo->setWorksheet($sheet);

        // RIGHT LOGO
        $rightLogo = new Drawing();
        $rightLogo->setName('Right Logo');
        $rightLogo->setDescription('Provincial Logo');
        $rightLogo->setPath("../storage/logos/$systemlogo");
        $rightLogo->setHeight(100);
        $rightLogo->setCoordinates('T1');
        $rightLogo->setOffsetX(100);
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
            $sheet->mergeCells("A{$row}:AK{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setName('Times New Roman')->setSize(12);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        $sheet->setCellValue('A7', 'PERSON WITH DISABILITIES');
        $sheet->mergeCells('A7:AK7');
        $sheet->getStyle('A7')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A8',strtoupper('AS OF '.date("F d, Y")));;
        $sheet->mergeCells('A8:AK8');
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
            'No.', 'Date Registered', 'Household ID Number', 'Resident ID Number', 'House Role', 
            'Resident Status', 'First Name', 'Middle Name', 'Last Name', 'Suffix',
            'Date of Birth', 'Age', 'Gender', 'Street/Purok', 'Barangay', 'Municipality', 'Province',
            'Civil Status', 'Religion', 'Nationality', 'Contact Number', 'Email Address', 'Education Attainment',
            'Height', 'Weight', 'Blood Type', 'Parent Status', 'PWD', 'FourPs', 'Indigenous',
            'Voter Status', 'ID Type', 'ID Type Number', 'Occupation', 'Employer/Business Name',
            'Monthly Income', 'Employer Status'
        ];
        $sheet->fromArray($headers, NULL, 'A15');

        // Header style
        $sheet->getStyle('A15:AK15')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A15:AK15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:AK15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Columns with custom widths
        $customWidths = [
            'L' => 10,
            'M' => 15,
            'V' => 20,
            'W' => 30,
            'X' => 10,
            'Y' => 10,
            'Z' => 10,
            'AB' => 10,
            'AC' => 10,
            'AD' => 10,
            'AI' => 30,
            'AK' => 30
        ];

        // Apply widths B–AK
        foreach (range('B','Z') as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Columns after Z: AA–AK
        foreach (range('A','K') as $col) {
            $column = 'A'.$col; // AA, AB, ..., AK
            $sheet->getColumnDimension($column)->setWidth($customWidths[$column] ?? 20);
        }

        // Optional: Column A
        $sheet->getColumnDimension('A')->setWidth(5);

        // Residents List
        $result = mysqli_query($connection, "
            SELECT 
                r.resident_Registered,
                h.household_IDNumber,
                r.resident_IDNumber,
                r.resident_HouseRole,
                r.resident_ResidentStatus,
                r.resident_FirstName,
                r.resident_MiddleName,
                r.resident_LastName,
                r.resident_Suffix,
                r.resident_DateofBirth,
                r.resident_Age,
                r.resident_Gender,
                r.resident_StreetPurok,
                r.resident_Barangay,
                r.resident_Municipality,
                r.resident_Province,
                r.resident_CivilStatus,
                r.resident_Religion,
                r.resident_Nationality,
                r.resident_ContactNumber,
                r.resident_EmailAddress,
                r.resident_EducationAttainment,
                r.resident_Height,
                r.resident_Weight,
                r.resident_BloodType,
                r.resident_ParentStatus,
                r.resident_PWD,
                r.resident_Fourps,
                r.resident_Indigenous,
                r.resident_VoterStatus,
                r.resident_IDType,
                r.resident_IDTypeNumber,
                r.resident_Occupation,
                r.resident_EmployerBusinessName,
                r.resident_MonthlyIncome,
                r.resident_EmployerStatus
            FROM rpms_residents r
            INNER JOIN rpms_households h ON h.household_ID = r.household_ID
            WHERE r.resident_Barangay = '$appointed' AND r.resident_PWD = 1 ORDER BY r.resident_Registered DESC
        ");

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
            $sheet->setCellValue('B'.$rowNum, $row['resident_Registered']);
            $sheet->setCellValue('C'.$rowNum, $row['household_IDNumber']);
            $sheet->setCellValue('D'.$rowNum, $row['resident_IDNumber']);
            $sheet->setCellValue('E'.$rowNum, $row['resident_HouseRole']);
            $sheet->setCellValue('F'.$rowNum, $row['resident_ResidentStatus']);
            $sheet->setCellValue('G'.$rowNum, $row['resident_FirstName']);
            $sheet->setCellValue('H'.$rowNum, $row['resident_MiddleName']);
            $sheet->setCellValue('I'.$rowNum, $row['resident_LastName']);
            $sheet->setCellValue('J'.$rowNum, $row['resident_Suffix']);
            $sheet->setCellValue('K'.$rowNum, $row['resident_DateofBirth']);
            $sheet->setCellValue('L'.$rowNum, $age);
            $sheet->setCellValue('M'.$rowNum, $row['resident_Gender']);
            $sheet->setCellValue('N'.$rowNum, $row['resident_StreetPurok']);
            $sheet->setCellValue('O'.$rowNum, $row['resident_Barangay']);
            $sheet->setCellValue('P'.$rowNum, $row['resident_Municipality']);
            $sheet->setCellValue('Q'.$rowNum, $row['resident_Province']);
            $sheet->setCellValue('R'.$rowNum, $row['resident_CivilStatus']);
            $sheet->setCellValue('S'.$rowNum, $row['resident_Religion']);
            $sheet->setCellValue('T'.$rowNum, $row['resident_Nationality']);
            $sheet->setCellValue('U'.$rowNum, $row['resident_ContactNumber']);
            $sheet->setCellValue('V'.$rowNum, $row['resident_EmailAddress']);
            $sheet->setCellValue('W'.$rowNum, $row['resident_EducationAttainment']);
            $sheet->setCellValue('X'.$rowNum, $row['resident_Height']);
            $sheet->setCellValue('Y'.$rowNum, $row['resident_Weight']);
            $sheet->setCellValue('Z'.$rowNum, $row['resident_BloodType']);
            $sheet->setCellValue('AA'.$rowNum, $row['resident_ParentStatus']);
            $sheet->setCellValue('AB'.$rowNum, $row['resident_PWD'] ? 'YES' : 'NO');
            $sheet->setCellValue('AC'.$rowNum, $row['resident_Fourps'] ? 'YES' : 'NO');
            $sheet->setCellValue('AD'.$rowNum, $row['resident_Indigenous'] ? 'YES' : 'NO');
            $sheet->setCellValue('AE'.$rowNum, $row['resident_VoterStatus']);
            $sheet->setCellValue('AF'.$rowNum, $row['resident_IDType']);
            $sheet->setCellValue('AG'.$rowNum, $row['resident_IDTypeNumber']);
            $sheet->setCellValue('AH'.$rowNum, $row['resident_Occupation']);
            $sheet->setCellValue('AI'.$rowNum, $row['resident_EmployerBusinessName']);
            $sheet->setCellValue('AJ'.$rowNum, $row['resident_MonthlyIncome']);
            $sheet->setCellValue('AK'.$rowNum, $row['resident_EmployerStatus']);
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // // Alignments
        $sheet->getStyle('A16:AK'.$lastRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Center numeric columns (example: No., Household Size, Total Residents)
        // Adjust these as needed
        $sheet->getStyle('A16:A'.$lastRow)->getAlignment()->setHorizontal('center');

        // Borders
        $sheet->getStyle('A15:AK'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A16');

        // Create User Logs
        $userid = $id;
        $action = "EXPORT";
        $module = "PERSON WITH DISABILITIES";
        $recordid = "";
        $description = "USER EXPORTED PERSON WITH DISABILITIES LIST";
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

        // Export
        $filename = "PWDs_".ucfirst(strtolower($appointed))."_" . date("YmdHis") . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    // Solo Parents
    elseif (isset($_GET['bsp_excl'])){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // LEFT LOGO
        $leftLogo = new Drawing();
        $leftLogo->setName('Left Logo');
        $leftLogo->setDescription('Municipal Logo');
        $leftLogo->setPath('../public/assets/images/logo/BP-Logo.png');
        $leftLogo->setHeight(100);
        $leftLogo->setCoordinates('R1');
        $leftLogo->setOffsetX(5);
        $leftLogo->setOffsetY(5);
        $leftLogo->setWorksheet($sheet);

        // RIGHT LOGO
        $rightLogo = new Drawing();
        $rightLogo->setName('Right Logo');
        $rightLogo->setDescription('Provincial Logo');
        $rightLogo->setPath("../storage/logos/$systemlogo");
        $rightLogo->setHeight(100);
        $rightLogo->setCoordinates('T1');
        $rightLogo->setOffsetX(100);
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
            $sheet->mergeCells("A{$row}:AK{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setName('Times New Roman')->setSize(12);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        $sheet->setCellValue('A7', 'SOLO PARENTS');
        $sheet->mergeCells('A7:AK7');
        $sheet->getStyle('A7')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A8',strtoupper('AS OF '.date("F d, Y")));;
        $sheet->mergeCells('A8:AK8');
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
            'No.', 'Date Registered', 'Household ID Number', 'Resident ID Number', 'House Role', 
            'Resident Status', 'First Name', 'Middle Name', 'Last Name', 'Suffix',
            'Date of Birth', 'Age', 'Gender', 'Street/Purok', 'Barangay', 'Municipality', 'Province',
            'Civil Status', 'Religion', 'Nationality', 'Contact Number', 'Email Address', 'Education Attainment',
            'Height', 'Weight', 'Blood Type', 'Parent Status', 'PWD', 'FourPs', 'Indigenous',
            'Voter Status', 'ID Type', 'ID Type Number', 'Occupation', 'Employer/Business Name',
            'Monthly Income', 'Employer Status'
        ];
        $sheet->fromArray($headers, NULL, 'A15');

        // Header style
        $sheet->getStyle('A15:AK15')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A15:AK15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:AK15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Columns with custom widths
        $customWidths = [
            'L' => 10,
            'M' => 15,
            'V' => 20,
            'W' => 30,
            'X' => 10,
            'Y' => 10,
            'Z' => 10,
            'AB' => 10,
            'AC' => 10,
            'AD' => 10,
            'AI' => 30,
            'AK' => 30
        ];

        // Apply widths B–AK
        foreach (range('B','Z') as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Columns after Z: AA–AK
        foreach (range('A','K') as $col) {
            $column = 'A'.$col; // AA, AB, ..., AK
            $sheet->getColumnDimension($column)->setWidth($customWidths[$column] ?? 20);
        }

        // Optional: Column A
        $sheet->getColumnDimension('A')->setWidth(5);

        // Residents List
        $result = mysqli_query($connection, "
            SELECT 
                r.resident_Registered,
                h.household_IDNumber,
                r.resident_IDNumber,
                r.resident_HouseRole,
                r.resident_ResidentStatus,
                r.resident_FirstName,
                r.resident_MiddleName,
                r.resident_LastName,
                r.resident_Suffix,
                r.resident_DateofBirth,
                r.resident_Age,
                r.resident_Gender,
                r.resident_StreetPurok,
                r.resident_Barangay,
                r.resident_Municipality,
                r.resident_Province,
                r.resident_CivilStatus,
                r.resident_Religion,
                r.resident_Nationality,
                r.resident_ContactNumber,
                r.resident_EmailAddress,
                r.resident_EducationAttainment,
                r.resident_Height,
                r.resident_Weight,
                r.resident_BloodType,
                r.resident_ParentStatus,
                r.resident_PWD,
                r.resident_Fourps,
                r.resident_Indigenous,
                r.resident_VoterStatus,
                r.resident_IDType,
                r.resident_IDTypeNumber,
                r.resident_Occupation,
                r.resident_EmployerBusinessName,
                r.resident_MonthlyIncome,
                r.resident_EmployerStatus
            FROM rpms_residents r
            INNER JOIN rpms_households h ON h.household_ID = r.household_ID
            WHERE r.resident_Barangay = '$appointed' AND r.resident_ParentStatus = 'YES' ORDER BY r.resident_Registered DESC
        ");

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
            $sheet->setCellValue('B'.$rowNum, $row['resident_Registered']);
            $sheet->setCellValue('C'.$rowNum, $row['household_IDNumber']);
            $sheet->setCellValue('D'.$rowNum, $row['resident_IDNumber']);
            $sheet->setCellValue('E'.$rowNum, $row['resident_HouseRole']);
            $sheet->setCellValue('F'.$rowNum, $row['resident_ResidentStatus']);
            $sheet->setCellValue('G'.$rowNum, $row['resident_FirstName']);
            $sheet->setCellValue('H'.$rowNum, $row['resident_MiddleName']);
            $sheet->setCellValue('I'.$rowNum, $row['resident_LastName']);
            $sheet->setCellValue('J'.$rowNum, $row['resident_Suffix']);
            $sheet->setCellValue('K'.$rowNum, $row['resident_DateofBirth']);
            $sheet->setCellValue('L'.$rowNum, $age);
            $sheet->setCellValue('M'.$rowNum, $row['resident_Gender']);
            $sheet->setCellValue('N'.$rowNum, $row['resident_StreetPurok']);
            $sheet->setCellValue('O'.$rowNum, $row['resident_Barangay']);
            $sheet->setCellValue('P'.$rowNum, $row['resident_Municipality']);
            $sheet->setCellValue('Q'.$rowNum, $row['resident_Province']);
            $sheet->setCellValue('R'.$rowNum, $row['resident_CivilStatus']);
            $sheet->setCellValue('S'.$rowNum, $row['resident_Religion']);
            $sheet->setCellValue('T'.$rowNum, $row['resident_Nationality']);
            $sheet->setCellValue('U'.$rowNum, $row['resident_ContactNumber']);
            $sheet->setCellValue('V'.$rowNum, $row['resident_EmailAddress']);
            $sheet->setCellValue('W'.$rowNum, $row['resident_EducationAttainment']);
            $sheet->setCellValue('X'.$rowNum, $row['resident_Height']);
            $sheet->setCellValue('Y'.$rowNum, $row['resident_Weight']);
            $sheet->setCellValue('Z'.$rowNum, $row['resident_BloodType']);
            $sheet->setCellValue('AA'.$rowNum, $row['resident_ParentStatus']);
            $sheet->setCellValue('AB'.$rowNum, $row['resident_PWD'] ? 'YES' : 'NO');
            $sheet->setCellValue('AC'.$rowNum, $row['resident_Fourps'] ? 'YES' : 'NO');
            $sheet->setCellValue('AD'.$rowNum, $row['resident_Indigenous'] ? 'YES' : 'NO');
            $sheet->setCellValue('AE'.$rowNum, $row['resident_VoterStatus']);
            $sheet->setCellValue('AF'.$rowNum, $row['resident_IDType']);
            $sheet->setCellValue('AG'.$rowNum, $row['resident_IDTypeNumber']);
            $sheet->setCellValue('AH'.$rowNum, $row['resident_Occupation']);
            $sheet->setCellValue('AI'.$rowNum, $row['resident_EmployerBusinessName']);
            $sheet->setCellValue('AJ'.$rowNum, $row['resident_MonthlyIncome']);
            $sheet->setCellValue('AK'.$rowNum, $row['resident_EmployerStatus']);
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // // Alignments
        $sheet->getStyle('A16:AK'.$lastRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Center numeric columns (example: No., Household Size, Total Residents)
        // Adjust these as needed
        $sheet->getStyle('A16:A'.$lastRow)->getAlignment()->setHorizontal('center');

        // Borders
        $sheet->getStyle('A15:AK'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A16');

        // Create User Logs
        $userid = $id;
        $action = "EXPORT";
        $module = "SOLO PARENTS";
        $recordid = "";
        $description = "USER EXPORTED SOLO PARENTS LIST";
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

        // Export
        $filename = "Solo_Parents_".ucfirst(strtolower($appointed))."_" . date("YmdHis") . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    // Voters
    elseif (isset($_GET['bvoters_excl'])){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // LEFT LOGO
        $leftLogo = new Drawing();
        $leftLogo->setName('Left Logo');
        $leftLogo->setDescription('Municipal Logo');
        $leftLogo->setPath('../public/assets/images/logo/BP-Logo.png');
        $leftLogo->setHeight(100);
        $leftLogo->setCoordinates('R1');
        $leftLogo->setOffsetX(5);
        $leftLogo->setOffsetY(5);
        $leftLogo->setWorksheet($sheet);

        // RIGHT LOGO
        $rightLogo = new Drawing();
        $rightLogo->setName('Right Logo');
        $rightLogo->setDescription('Provincial Logo');
        $rightLogo->setPath("../storage/logos/$systemlogo");
        $rightLogo->setHeight(100);
        $rightLogo->setCoordinates('T1');
        $rightLogo->setOffsetX(100);
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
            $sheet->mergeCells("A{$row}:AK{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setName('Times New Roman')->setSize(12);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        $sheet->setCellValue('A7', 'REGISTERED VOTERS');
        $sheet->mergeCells('A7:AK7');
        $sheet->getStyle('A7')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A8',strtoupper('AS OF '.date("F d, Y")));;
        $sheet->mergeCells('A8:AK8');
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
            'No.', 'Date Registered', 'Household ID Number', 'Resident ID Number', 'House Role', 
            'Resident Status', 'First Name', 'Middle Name', 'Last Name', 'Suffix',
            'Date of Birth', 'Age', 'Gender', 'Street/Purok', 'Barangay', 'Municipality', 'Province',
            'Civil Status', 'Religion', 'Nationality', 'Contact Number', 'Email Address', 'Education Attainment',
            'Height', 'Weight', 'Blood Type', 'Parent Status', 'PWD', 'FourPs', 'Indigenous',
            'Voter Status', 'ID Type', 'ID Type Number', 'Occupation', 'Employer/Business Name',
            'Monthly Income', 'Employer Status'
        ];
        $sheet->fromArray($headers, NULL, 'A15');

        // Header style
        $sheet->getStyle('A15:AK15')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A15:AK15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:AK15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Columns with custom widths
        $customWidths = [
            'L' => 10,
            'M' => 15,
            'V' => 20,
            'W' => 30,
            'X' => 10,
            'Y' => 10,
            'Z' => 10,
            'AB' => 10,
            'AC' => 10,
            'AD' => 10,
            'AI' => 30,
            'AK' => 30
        ];

        // Apply widths B–AK
        foreach (range('B','Z') as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Columns after Z: AA–AK
        foreach (range('A','K') as $col) {
            $column = 'A'.$col; // AA, AB, ..., AK
            $sheet->getColumnDimension($column)->setWidth($customWidths[$column] ?? 20);
        }

        // Optional: Column A
        $sheet->getColumnDimension('A')->setWidth(5);

        // Residents List
        $result = mysqli_query($connection, "
            SELECT 
                r.resident_Registered,
                h.household_IDNumber,
                r.resident_IDNumber,
                r.resident_HouseRole,
                r.resident_ResidentStatus,
                r.resident_FirstName,
                r.resident_MiddleName,
                r.resident_LastName,
                r.resident_Suffix,
                r.resident_DateofBirth,
                r.resident_Age,
                r.resident_Gender,
                r.resident_StreetPurok,
                r.resident_Barangay,
                r.resident_Municipality,
                r.resident_Province,
                r.resident_CivilStatus,
                r.resident_Religion,
                r.resident_Nationality,
                r.resident_ContactNumber,
                r.resident_EmailAddress,
                r.resident_EducationAttainment,
                r.resident_Height,
                r.resident_Weight,
                r.resident_BloodType,
                r.resident_ParentStatus,
                r.resident_PWD,
                r.resident_Fourps,
                r.resident_Indigenous,
                r.resident_VoterStatus,
                r.resident_IDType,
                r.resident_IDTypeNumber,
                r.resident_Occupation,
                r.resident_EmployerBusinessName,
                r.resident_MonthlyIncome,
                r.resident_EmployerStatus
            FROM rpms_residents r
            INNER JOIN rpms_households h ON h.household_ID = r.household_ID
            WHERE r.resident_Barangay = '$appointed' AND r.resident_VoterStatus = 'REGISTERED' ORDER BY r.resident_Registered DESC
        ");

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
            $sheet->setCellValue('B'.$rowNum, $row['resident_Registered']);
            $sheet->setCellValue('C'.$rowNum, $row['household_IDNumber']);
            $sheet->setCellValue('D'.$rowNum, $row['resident_IDNumber']);
            $sheet->setCellValue('E'.$rowNum, $row['resident_HouseRole']);
            $sheet->setCellValue('F'.$rowNum, $row['resident_ResidentStatus']);
            $sheet->setCellValue('G'.$rowNum, $row['resident_FirstName']);
            $sheet->setCellValue('H'.$rowNum, $row['resident_MiddleName']);
            $sheet->setCellValue('I'.$rowNum, $row['resident_LastName']);
            $sheet->setCellValue('J'.$rowNum, $row['resident_Suffix']);
            $sheet->setCellValue('K'.$rowNum, $row['resident_DateofBirth']);
            $sheet->setCellValue('L'.$rowNum, $age);
            $sheet->setCellValue('M'.$rowNum, $row['resident_Gender']);
            $sheet->setCellValue('N'.$rowNum, $row['resident_StreetPurok']);
            $sheet->setCellValue('O'.$rowNum, $row['resident_Barangay']);
            $sheet->setCellValue('P'.$rowNum, $row['resident_Municipality']);
            $sheet->setCellValue('Q'.$rowNum, $row['resident_Province']);
            $sheet->setCellValue('R'.$rowNum, $row['resident_CivilStatus']);
            $sheet->setCellValue('S'.$rowNum, $row['resident_Religion']);
            $sheet->setCellValue('T'.$rowNum, $row['resident_Nationality']);
            $sheet->setCellValue('U'.$rowNum, $row['resident_ContactNumber']);
            $sheet->setCellValue('V'.$rowNum, $row['resident_EmailAddress']);
            $sheet->setCellValue('W'.$rowNum, $row['resident_EducationAttainment']);
            $sheet->setCellValue('X'.$rowNum, $row['resident_Height']);
            $sheet->setCellValue('Y'.$rowNum, $row['resident_Weight']);
            $sheet->setCellValue('Z'.$rowNum, $row['resident_BloodType']);
            $sheet->setCellValue('AA'.$rowNum, $row['resident_ParentStatus']);
            $sheet->setCellValue('AB'.$rowNum, $row['resident_PWD'] ? 'YES' : 'NO');
            $sheet->setCellValue('AC'.$rowNum, $row['resident_Fourps'] ? 'YES' : 'NO');
            $sheet->setCellValue('AD'.$rowNum, $row['resident_Indigenous'] ? 'YES' : 'NO');
            $sheet->setCellValue('AE'.$rowNum, $row['resident_VoterStatus']);
            $sheet->setCellValue('AF'.$rowNum, $row['resident_IDType']);
            $sheet->setCellValue('AG'.$rowNum, $row['resident_IDTypeNumber']);
            $sheet->setCellValue('AH'.$rowNum, $row['resident_Occupation']);
            $sheet->setCellValue('AI'.$rowNum, $row['resident_EmployerBusinessName']);
            $sheet->setCellValue('AJ'.$rowNum, $row['resident_MonthlyIncome']);
            $sheet->setCellValue('AK'.$rowNum, $row['resident_EmployerStatus']);
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // // Alignments
        $sheet->getStyle('A16:AK'.$lastRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Center numeric columns (example: No., Household Size, Total Residents)
        // Adjust these as needed
        $sheet->getStyle('A16:A'.$lastRow)->getAlignment()->setHorizontal('center');

        // Borders
        $sheet->getStyle('A15:AK'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A16');

        // Create User Logs
        $userid = $id;
        $action = "EXPORT";
        $module = "VOTERS";
        $recordid = "";
        $description = "USER EXPORTED REGISTERED VOTERS LIST";
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

        // Export
        $filename = "Registered_Voters_".ucfirst(strtolower($appointed))."_" . date("YmdHis") . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    // 4Ps
    elseif (isset($_GET['b4ps_excl'])){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // LEFT LOGO
        $leftLogo = new Drawing();
        $leftLogo->setName('Left Logo');
        $leftLogo->setDescription('Municipal Logo');
        $leftLogo->setPath('../public/assets/images/logo/BP-Logo.png');
        $leftLogo->setHeight(100);
        $leftLogo->setCoordinates('R1');
        $leftLogo->setOffsetX(5);
        $leftLogo->setOffsetY(5);
        $leftLogo->setWorksheet($sheet);

        // RIGHT LOGO
        $rightLogo = new Drawing();
        $rightLogo->setName('Right Logo');
        $rightLogo->setDescription('Provincial Logo');
        $rightLogo->setPath("../storage/logos/$systemlogo");
        $rightLogo->setHeight(100);
        $rightLogo->setCoordinates('T1');
        $rightLogo->setOffsetX(100);
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
            $sheet->mergeCells("A{$row}:AK{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setName('Times New Roman')->setSize(12);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        $sheet->setCellValue('A7', '4PS MEMBERS');
        $sheet->mergeCells('A7:AK7');
        $sheet->getStyle('A7')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A8',strtoupper('AS OF '.date("F d, Y")));;
        $sheet->mergeCells('A8:AK8');
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
            'No.', 'Date Registered', 'Household ID Number', 'Resident ID Number', 'House Role', 
            'Resident Status', 'First Name', 'Middle Name', 'Last Name', 'Suffix',
            'Date of Birth', 'Age', 'Gender', 'Street/Purok', 'Barangay', 'Municipality', 'Province',
            'Civil Status', 'Religion', 'Nationality', 'Contact Number', 'Email Address', 'Education Attainment',
            'Height', 'Weight', 'Blood Type', 'Parent Status', 'PWD', 'FourPs', 'Indigenous',
            'Voter Status', 'ID Type', 'ID Type Number', 'Occupation', 'Employer/Business Name',
            'Monthly Income', 'Employer Status'
        ];
        $sheet->fromArray($headers, NULL, 'A15');

        // Header style
        $sheet->getStyle('A15:AK15')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A15:AK15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:AK15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Columns with custom widths
        $customWidths = [
            'L' => 10,
            'M' => 15,
            'V' => 20,
            'W' => 30,
            'X' => 10,
            'Y' => 10,
            'Z' => 10,
            'AB' => 10,
            'AC' => 10,
            'AD' => 10,
            'AI' => 30,
            'AK' => 30
        ];

        // Apply widths B–AK
        foreach (range('B','Z') as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Columns after Z: AA–AK
        foreach (range('A','K') as $col) {
            $column = 'A'.$col; // AA, AB, ..., AK
            $sheet->getColumnDimension($column)->setWidth($customWidths[$column] ?? 20);
        }

        // Optional: Column A
        $sheet->getColumnDimension('A')->setWidth(5);

        // Residents List
        $result = mysqli_query($connection, "
            SELECT 
                r.resident_Registered,
                h.household_IDNumber,
                r.resident_IDNumber,
                r.resident_HouseRole,
                r.resident_ResidentStatus,
                r.resident_FirstName,
                r.resident_MiddleName,
                r.resident_LastName,
                r.resident_Suffix,
                r.resident_DateofBirth,
                r.resident_Age,
                r.resident_Gender,
                r.resident_StreetPurok,
                r.resident_Barangay,
                r.resident_Municipality,
                r.resident_Province,
                r.resident_CivilStatus,
                r.resident_Religion,
                r.resident_Nationality,
                r.resident_ContactNumber,
                r.resident_EmailAddress,
                r.resident_EducationAttainment,
                r.resident_Height,
                r.resident_Weight,
                r.resident_BloodType,
                r.resident_ParentStatus,
                r.resident_PWD,
                r.resident_Fourps,
                r.resident_Indigenous,
                r.resident_VoterStatus,
                r.resident_IDType,
                r.resident_IDTypeNumber,
                r.resident_Occupation,
                r.resident_EmployerBusinessName,
                r.resident_MonthlyIncome,
                r.resident_EmployerStatus
            FROM rpms_residents r
            INNER JOIN rpms_households h ON h.household_ID = r.household_ID
            WHERE r.resident_Barangay = '$appointed' AND r.resident_Fourps = '1' ORDER BY r.resident_Registered DESC
        ");

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
            $sheet->setCellValue('B'.$rowNum, $row['resident_Registered']);
            $sheet->setCellValue('C'.$rowNum, $row['household_IDNumber']);
            $sheet->setCellValue('D'.$rowNum, $row['resident_IDNumber']);
            $sheet->setCellValue('E'.$rowNum, $row['resident_HouseRole']);
            $sheet->setCellValue('F'.$rowNum, $row['resident_ResidentStatus']);
            $sheet->setCellValue('G'.$rowNum, $row['resident_FirstName']);
            $sheet->setCellValue('H'.$rowNum, $row['resident_MiddleName']);
            $sheet->setCellValue('I'.$rowNum, $row['resident_LastName']);
            $sheet->setCellValue('J'.$rowNum, $row['resident_Suffix']);
            $sheet->setCellValue('K'.$rowNum, $row['resident_DateofBirth']);
            $sheet->setCellValue('L'.$rowNum, $age);
            $sheet->setCellValue('M'.$rowNum, $row['resident_Gender']);
            $sheet->setCellValue('N'.$rowNum, $row['resident_StreetPurok']);
            $sheet->setCellValue('O'.$rowNum, $row['resident_Barangay']);
            $sheet->setCellValue('P'.$rowNum, $row['resident_Municipality']);
            $sheet->setCellValue('Q'.$rowNum, $row['resident_Province']);
            $sheet->setCellValue('R'.$rowNum, $row['resident_CivilStatus']);
            $sheet->setCellValue('S'.$rowNum, $row['resident_Religion']);
            $sheet->setCellValue('T'.$rowNum, $row['resident_Nationality']);
            $sheet->setCellValue('U'.$rowNum, $row['resident_ContactNumber']);
            $sheet->setCellValue('V'.$rowNum, $row['resident_EmailAddress']);
            $sheet->setCellValue('W'.$rowNum, $row['resident_EducationAttainment']);
            $sheet->setCellValue('X'.$rowNum, $row['resident_Height']);
            $sheet->setCellValue('Y'.$rowNum, $row['resident_Weight']);
            $sheet->setCellValue('Z'.$rowNum, $row['resident_BloodType']);
            $sheet->setCellValue('AA'.$rowNum, $row['resident_ParentStatus']);
            $sheet->setCellValue('AB'.$rowNum, $row['resident_PWD'] ? 'YES' : 'NO');
            $sheet->setCellValue('AC'.$rowNum, $row['resident_Fourps'] ? 'YES' : 'NO');
            $sheet->setCellValue('AD'.$rowNum, $row['resident_Indigenous'] ? 'YES' : 'NO');
            $sheet->setCellValue('AE'.$rowNum, $row['resident_VoterStatus']);
            $sheet->setCellValue('AF'.$rowNum, $row['resident_IDType']);
            $sheet->setCellValue('AG'.$rowNum, $row['resident_IDTypeNumber']);
            $sheet->setCellValue('AH'.$rowNum, $row['resident_Occupation']);
            $sheet->setCellValue('AI'.$rowNum, $row['resident_EmployerBusinessName']);
            $sheet->setCellValue('AJ'.$rowNum, $row['resident_MonthlyIncome']);
            $sheet->setCellValue('AK'.$rowNum, $row['resident_EmployerStatus']);
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // // Alignments
        $sheet->getStyle('A16:AK'.$lastRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Center numeric columns (example: No., Household Size, Total Residents)
        // Adjust these as needed
        $sheet->getStyle('A16:A'.$lastRow)->getAlignment()->setHorizontal('center');

        // Borders
        $sheet->getStyle('A15:AK'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A16');

        // Create User Logs
        $userid = $id;
        $action = "EXPORT";
        $module = "VOTERS";
        $recordid = "";
        $description = "USER EXPORTED 4PS LIST";
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

        // Export
        $filename = "4Ps_Members_".ucfirst(strtolower($appointed))."_" . date("YmdHis") . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    // Indigenous People
    elseif (isset($_GET['bindigenouspeople_excl'])){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // LEFT LOGO
        $leftLogo = new Drawing();
        $leftLogo->setName('Left Logo');
        $leftLogo->setDescription('Municipal Logo');
        $leftLogo->setPath('../public/assets/images/logo/BP-Logo.png');
        $leftLogo->setHeight(100);
        $leftLogo->setCoordinates('R1');
        $leftLogo->setOffsetX(5);
        $leftLogo->setOffsetY(5);
        $leftLogo->setWorksheet($sheet);

        // RIGHT LOGO
        $rightLogo = new Drawing();
        $rightLogo->setName('Right Logo');
        $rightLogo->setDescription('Provincial Logo');
        $rightLogo->setPath("../storage/logos/$systemlogo");
        $rightLogo->setHeight(100);
        $rightLogo->setCoordinates('T1');
        $rightLogo->setOffsetX(100);
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
            $sheet->mergeCells("A{$row}:AK{$row}");
            $sheet->getStyle("A{$row}")->getFont()->setName('Times New Roman')->setSize(12);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $row++;
        }
        $sheet->setCellValue('A7', 'INDIGENOUS PEOPLE');
        $sheet->mergeCells('A7:AK7');
        $sheet->getStyle('A7')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A8',strtoupper('AS OF '.date("F d, Y")));;
        $sheet->mergeCells('A8:AK8');
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
            'No.', 'Date Registered', 'Household ID Number', 'Resident ID Number', 'House Role', 
            'Resident Status', 'First Name', 'Middle Name', 'Last Name', 'Suffix',
            'Date of Birth', 'Age', 'Gender', 'Street/Purok', 'Barangay', 'Municipality', 'Province',
            'Civil Status', 'Religion', 'Nationality', 'Contact Number', 'Email Address', 'Education Attainment',
            'Height', 'Weight', 'Blood Type', 'Parent Status', 'PWD', 'FourPs', 'Indigenous',
            'Voter Status', 'ID Type', 'ID Type Number', 'Occupation', 'Employer/Business Name',
            'Monthly Income', 'Employer Status'
        ];
        $sheet->fromArray($headers, NULL, 'A15');

        // Header style
        $sheet->getStyle('A15:AK15')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A15:AK15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:AK15')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Columns with custom widths
        $customWidths = [
            'L' => 10,
            'M' => 15,
            'V' => 20,
            'W' => 30,
            'X' => 10,
            'Y' => 10,
            'Z' => 10,
            'AB' => 10,
            'AC' => 10,
            'AD' => 10,
            'AI' => 30,
            'AK' => 30
        ];

        // Apply widths B–AK
        foreach (range('B','Z') as $col) {
            $sheet->getColumnDimension($col)->setWidth($customWidths[$col] ?? 20);
        }

        // Columns after Z: AA–AK
        foreach (range('A','K') as $col) {
            $column = 'A'.$col; // AA, AB, ..., AK
            $sheet->getColumnDimension($column)->setWidth($customWidths[$column] ?? 20);
        }

        // Optional: Column A
        $sheet->getColumnDimension('A')->setWidth(5);

        // Residents List
        $result = mysqli_query($connection, "
            SELECT 
                r.resident_Registered,
                h.household_IDNumber,
                r.resident_IDNumber,
                r.resident_HouseRole,
                r.resident_ResidentStatus,
                r.resident_FirstName,
                r.resident_MiddleName,
                r.resident_LastName,
                r.resident_Suffix,
                r.resident_DateofBirth,
                r.resident_Age,
                r.resident_Gender,
                r.resident_StreetPurok,
                r.resident_Barangay,
                r.resident_Municipality,
                r.resident_Province,
                r.resident_CivilStatus,
                r.resident_Religion,
                r.resident_Nationality,
                r.resident_ContactNumber,
                r.resident_EmailAddress,
                r.resident_EducationAttainment,
                r.resident_Height,
                r.resident_Weight,
                r.resident_BloodType,
                r.resident_ParentStatus,
                r.resident_PWD,
                r.resident_Fourps,
                r.resident_Indigenous,
                r.resident_VoterStatus,
                r.resident_IDType,
                r.resident_IDTypeNumber,
                r.resident_Occupation,
                r.resident_EmployerBusinessName,
                r.resident_MonthlyIncome,
                r.resident_EmployerStatus
            FROM rpms_residents r
            INNER JOIN rpms_households h ON h.household_ID = r.household_ID
            WHERE r.resident_Barangay = '$appointed' AND r.resident_Indigenous = '1' ORDER BY r.resident_Registered DESC
        ");

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
            $sheet->setCellValue('B'.$rowNum, $row['resident_Registered']);
            $sheet->setCellValue('C'.$rowNum, $row['household_IDNumber']);
            $sheet->setCellValue('D'.$rowNum, $row['resident_IDNumber']);
            $sheet->setCellValue('E'.$rowNum, $row['resident_HouseRole']);
            $sheet->setCellValue('F'.$rowNum, $row['resident_ResidentStatus']);
            $sheet->setCellValue('G'.$rowNum, $row['resident_FirstName']);
            $sheet->setCellValue('H'.$rowNum, $row['resident_MiddleName']);
            $sheet->setCellValue('I'.$rowNum, $row['resident_LastName']);
            $sheet->setCellValue('J'.$rowNum, $row['resident_Suffix']);
            $sheet->setCellValue('K'.$rowNum, $row['resident_DateofBirth']);
            $sheet->setCellValue('L'.$rowNum, $age);
            $sheet->setCellValue('M'.$rowNum, $row['resident_Gender']);
            $sheet->setCellValue('N'.$rowNum, $row['resident_StreetPurok']);
            $sheet->setCellValue('O'.$rowNum, $row['resident_Barangay']);
            $sheet->setCellValue('P'.$rowNum, $row['resident_Municipality']);
            $sheet->setCellValue('Q'.$rowNum, $row['resident_Province']);
            $sheet->setCellValue('R'.$rowNum, $row['resident_CivilStatus']);
            $sheet->setCellValue('S'.$rowNum, $row['resident_Religion']);
            $sheet->setCellValue('T'.$rowNum, $row['resident_Nationality']);
            $sheet->setCellValue('U'.$rowNum, $row['resident_ContactNumber']);
            $sheet->setCellValue('V'.$rowNum, $row['resident_EmailAddress']);
            $sheet->setCellValue('W'.$rowNum, $row['resident_EducationAttainment']);
            $sheet->setCellValue('X'.$rowNum, $row['resident_Height']);
            $sheet->setCellValue('Y'.$rowNum, $row['resident_Weight']);
            $sheet->setCellValue('Z'.$rowNum, $row['resident_BloodType']);
            $sheet->setCellValue('AA'.$rowNum, $row['resident_ParentStatus']);
            $sheet->setCellValue('AB'.$rowNum, $row['resident_PWD'] ? 'YES' : 'NO');
            $sheet->setCellValue('AC'.$rowNum, $row['resident_Fourps'] ? 'YES' : 'NO');
            $sheet->setCellValue('AD'.$rowNum, $row['resident_Indigenous'] ? 'YES' : 'NO');
            $sheet->setCellValue('AE'.$rowNum, $row['resident_VoterStatus']);
            $sheet->setCellValue('AF'.$rowNum, $row['resident_IDType']);
            $sheet->setCellValue('AG'.$rowNum, $row['resident_IDTypeNumber']);
            $sheet->setCellValue('AH'.$rowNum, $row['resident_Occupation']);
            $sheet->setCellValue('AI'.$rowNum, $row['resident_EmployerBusinessName']);
            $sheet->setCellValue('AJ'.$rowNum, $row['resident_MonthlyIncome']);
            $sheet->setCellValue('AK'.$rowNum, $row['resident_EmployerStatus']);
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // // Alignments
        $sheet->getStyle('A16:AK'.$lastRow)
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Center numeric columns (example: No., Household Size, Total Residents)
        // Adjust these as needed
        $sheet->getStyle('A16:A'.$lastRow)->getAlignment()->setHorizontal('center');

        // Borders
        $sheet->getStyle('A15:AK'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A16');

        // Create User Logs
        $userid = $id;
        $action = "EXPORT";
        $module = "VOTERS";
        $recordid = "";
        $description = "USER EXPORTED INDIGENOUS PEOPLE LIST";
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

        // Export
        $filename = "Indigenous_People_".ucfirst(strtolower($appointed))."_" . date("YmdHis") . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    // Audit Logs
    elseif (isset($_GET['auditlogs_excl'])){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'AUDIT LOGS');
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->getFont()->setName('Calibri')->setSize(25)->setBold(true);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A2',strtoupper('AS OF '.date("F d, Y")));;
        $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A2')->getFont()->setName('Calibri')->setSize(12)->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Table Headers
        $headers = [
            'Username', 'Action', 'Module', 'Description', 'IP Address', 
            'Agent', 'Created'];
        $sheet->fromArray($headers, NULL, 'A4');

        // Header style
        $sheet->getStyle('A4:G4')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF'); // white text
        $sheet->getStyle('A4:G4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:G4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('1A1341');

        // Column widths
        foreach (range('A','B') as $col) {
            $sheet->getColumnDimension($col)->setWidth(20);
        }
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(50);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(50);
        $sheet->getColumnDimension('G')->setWidth(20);

        // Audit Logs List
        $result = mysqli_query($connection, "SELECT 
            rpms_users.user_Username, 
            rpms_userlogs.userlogs_Action, 
            rpms_userlogs.userlogs_Module, 
            rpms_userlogs.userlogs_Description, 
            rpms_userlogs.userlogs_IPAddress, 
            rpms_userlogs.userlogs_Agent, 
            rpms_userlogs.userlogs_Created FROM `rpms_userlogs` LEFT JOIN rpms_users ON rpms_users.user_ID = rpms_userlogs.user_ID 
            ORDER BY `userlogs_Created` DESC;
        ");

        $rowNum = 5; // Start after header
        $counter = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $sheet->setCellValue('A'.$rowNum, $row['user_Username']);
            $sheet->setCellValue('B'.$rowNum, $row['userlogs_Action']);
            $sheet->setCellValue('C'.$rowNum, $row['userlogs_Module']);
            $sheet->setCellValue('D'.$rowNum, $row['userlogs_Description']);
            $sheet->setCellValue('E'.$rowNum, $row['userlogs_IPAddress']);
            $sheet->setCellValue('F'.$rowNum, $row['userlogs_Agent']);
            $sheet->setCellValue('G'.$rowNum, $row['userlogs_Created']);
            $rowNum++;
            $counter++;
        }

        $lastRow = $rowNum - 1;

        // Alignments
        $sheet->getStyle('A5:G'.$lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Borders
        $sheet->getStyle('A4:G'.$lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],
        ]);

        // Freeze header
        $sheet->freezePane('A5');

        // Export
        $filename = "Audit_Logs_" . date("YmdHis") . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit();
    }

    // Database Backup
    elseif (isset($_GET['databasebackup'])) {
        // Folder path

        $file_path = "../storage/database/";

        // Create folder if not exists
        if (!is_dir($file_path)) {
            mkdir($file_path, 0777, true);
        }
        $backup = date("Y-m-d H:i:s");
        $dbfilename = $db_name."-".date("Y-m-d_H-i-s").".sql";

        $fullpath = $file_path.$dbfilename;

        // Detect mysqldump path
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $mysqldump = "C:/xampp/mysql/bin/mysqldump";
        } else {
            $mysqldump = "/usr/bin/mysqldump";
        }

        // Backup command
        $command = "\"$mysqldump\" --host=$host_name --user=$host_username --password=\"$host_password\" $db_name > \"$fullpath\"";

        system($command, $output);

        // Check if backup file exists
        if (!file_exists($fullpath)) {
            header("Location: databasebackup?notification=backupfailed");
            exit();
        }

        // Reset AUTO_INCREMENT if table is empty
        $stmtCheck = $connection->query("SELECT COUNT(*) as checktable FROM `rpms_databases`");
        $row = $stmtCheck->fetch_assoc();

        if ($row['checktable'] == 0) {
            $connection->query("ALTER TABLE `rpms_databases` AUTO_INCREMENT = 1");
        }

        // Insert record
        $stmtInsert = $connection->prepare("
            INSERT INTO `rpms_databases` (`database_Filename`, `database_Backup`) 
            VALUES (?, ?)
        ");

        $stmtInsert->bind_param("ss", $dbfilename, $backup);
        if ($stmtInsert->execute()) {
            $databasebackuplastid = $connection->insert_id;
            // Create User Logs
            $userid = $id;
            $action = "BACKUP";
            $module = "DATABASE";
            $recordid = $databasebackuplastid;
            $description = "USER PERFORMED DATABASE BACKUP";
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

            header("Location: ../auth/databasebackup?notification=databasecreated");
            exit();
        } else {
            header("Location: ../auth/databasebackup?notification=databaseerror");
            exit();
        }

        $stmtInsert->close();
    }
?>