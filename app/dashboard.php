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

    if($role == 1){
        // Barangay Household and Population
        $getbhp = "SELECT b.barangay_Name, COUNT(DISTINCT r.resident_ID) AS totalbarangayresidents, COUNT(DISTINCT h.household_ID) AS totalbarangayhouseholds FROM rpms_barangays b LEFT JOIN rpms_residents r ON b.barangay_Name = r.resident_Barangay LEFT JOIN rpms_households h ON b.barangay_Name = h.household_Barangay GROUP BY b.barangay_Name ORDER BY b.barangay_Name";
        $resultbhp = mysqli_query($connection, $getbhp);
        while($row = mysqli_fetch_assoc($resultbhp)){
            $bn[] = $row['barangay_Name'];
            $tbrf[] = number_format($row['totalbarangayresidents']);
            $tbhf[] = number_format($row['totalbarangayhouseholds']);
        }

        // Total Count
        $gettotalcount = "SELECT 
            (SELECT COUNT(*) FROM rpms_barangays) AS totalbarangays,
            COUNT(DISTINCT h.household_ID) AS totalhouseholds,
            COUNT(DISTINCT r.resident_ID) AS totalresidents,
            SUM(r.resident_VoterStatus = 'REGISTERED') AS totalregisteredvoters,
            SUM(r.resident_PWD = 1) AS totalpwd,
            SUM(r.resident_Fourps = 1) AS total4ps,
            SUM(r.resident_Indigenous = 1) AS totalindigenous,
            SUM(r.resident_ParentStatus = 'YES') AS totalsoloparents,
            COUNT(DISTINCT CASE 
                    WHEN TIMESTAMPDIFF(YEAR, r.`resident_DateofBirth`, CURDATE()) >= 60 
                    THEN r.`resident_ID` 
                END) AS totalseniorscitizens
            FROM rpms_households h
            LEFT JOIN rpms_residents r 
            ON h.household_Barangay = r.resident_Barangay";
        $resulttotalcount = mysqli_query($connection, $gettotalcount);
        $row = mysqli_fetch_assoc($resulttotalcount);
        $otbf   = number_format($row['totalbarangays']);
        $othf   = number_format($row['totalhouseholds']);
        $otpf   = number_format($row['totalresidents']);
        $otrvf  = number_format($row['totalregisteredvoters']);
        $otpwdf = number_format($row['totalpwd']);
        $otfpf  = number_format($row['total4ps']);
        $otipf  = number_format($row['totalindigenous']);
        $otspf  = number_format($row['totalsoloparents']);
        $otsc  = number_format($row['totalseniorscitizens']);

        // New Total Count
        $getnewtotalcount = "SELECT
            (SELECT COUNT(DISTINCT `barangay_ID`) FROM `rpms_barangays` WHERE MONTH(`barangay_Registered`) = MONTH(CURDATE()) AND YEAR(`barangay_Registered`) = YEAR(CURDATE())
            ) AS tnb,

            (SELECT COUNT(*) 
             FROM `rpms_households` 
             WHERE MONTH(`household_Registered`) = MONTH(CURDATE())
               AND YEAR(`household_Registered`) = YEAR(CURDATE())
            ) AS tnh,

            (SELECT COUNT(*) 
             FROM `rpms_residents` 
             WHERE MONTH(`resident_Registered`) = MONTH(CURDATE())
               AND YEAR(`resident_Registered`) = YEAR(CURDATE())
            ) AS tnr";
        $resultnewtotalcount = mysqli_query($connection, $getnewtotalcount);
        $row = mysqli_fetch_assoc($resultnewtotalcount);
        $tnbf   = number_format($row['tnb']);
        $tnhf   = number_format($row['tnh']);
        $tnrf   = number_format($row['tnr']);

        // Household Type
        $gettotalhht = "SELECT category.household_Type,
                   COUNT(r.household_Type) AS othht
            FROM (
                SELECT 'Owned' AS household_Type
                UNION ALL
                SELECT 'Rented'
            ) AS category
            LEFT JOIN rpms_households r
                ON category.household_Type = r.household_Type
            GROUP BY category.household_Type
            ORDER BY FIELD(category.household_Type, 'Owned', 'Rented');";
        $resulttotalhht = mysqli_query($connection, $gettotalhht);
        while($row = mysqli_fetch_assoc($resulttotalhht)){
            $hhtype[] = ucfirst(strtolower($row['household_Type']));
            $othhtf[] = number_format($row['othht']);
        }

        // Household Size Distribution
        $gettotalhhsd = "SELECT category.household_Size,
                   COUNT(r.household_Size) AS oths
            FROM (
                SELECT 'Small (1-2 rooms)' AS household_Size
                UNION ALL
                SELECT 'Medium (3-4 rooms)'
                UNION ALL
                SELECT 'Large (5+ rooms)'
            ) AS category
            LEFT JOIN rpms_households r
                ON category.household_Size = r.household_Size
            GROUP BY category.household_Size
            ORDER BY 
                FIELD(category.household_Size,
                    'Small (1-2 rooms)',
                    'Medium (3-4 rooms)',
                    'Large (5+ rooms)'
                )";
        $resulttotalhhsd = mysqli_query($connection, $gettotalhhsd);
        while($row = mysqli_fetch_assoc($resulttotalhhsd)){
            $hhs[] = ucfirst(strtolower($row['household_Size']));
            $othsf[] = number_format($row['oths']);
        }

        // Age Distribution
        $getad = "SELECT ag.age_group AS agedistribution,
                   COALESCE(COUNT(r.resident_ID), 0) AS otad
            FROM (
                SELECT 'Infant 0-2' AS age_group
                UNION ALL SELECT 'Child 3-12'
                UNION ALL SELECT 'Teen 13-17'
                UNION ALL SELECT 'Young Adult 18-25'
                UNION ALL SELECT 'Adult 26-40'
                UNION ALL SELECT 'Middle Age 41-59'
                UNION ALL SELECT 'Senior Citizen 60+'
            ) AS ag
            LEFT JOIN `rpms_residents` r
                ON (
                    (ag.age_group = 'Infant 0-2' AND TIMESTAMPDIFF(YEAR, r.resident_DateofBirth, CURDATE()) BETWEEN 0 AND 2) OR
                    (ag.age_group = 'Child 3-12' AND TIMESTAMPDIFF(YEAR, r.resident_DateofBirth, CURDATE()) BETWEEN 3 AND 12) OR
                    (ag.age_group = 'Teen 13-17' AND TIMESTAMPDIFF(YEAR, r.resident_DateofBirth, CURDATE()) BETWEEN 13 AND 17) OR
                    (ag.age_group = 'Young Adult 18-25' AND TIMESTAMPDIFF(YEAR, r.resident_DateofBirth, CURDATE()) BETWEEN 18 AND 25) OR
                    (ag.age_group = 'Adult 26-40' AND TIMESTAMPDIFF(YEAR, r.resident_DateofBirth, CURDATE()) BETWEEN 26 AND 40) OR
                    (ag.age_group = 'Middle Age 41-59' AND TIMESTAMPDIFF(YEAR, r.resident_DateofBirth, CURDATE()) BETWEEN 41 AND 59) OR
                    (ag.age_group = 'Senior Citizen 60+' AND TIMESTAMPDIFF(YEAR, r.resident_DateofBirth, CURDATE()) >= 60)
                )
            GROUP BY ag.age_group
            ORDER BY
                CASE ag.age_group
                    WHEN 'Infant 0-2' THEN 1
                    WHEN 'Child 3-12' THEN 2
                    WHEN 'Teen 13-17' THEN 3
                    WHEN 'Young Adult 18-25' THEN 4
                    WHEN 'Adult 26-40' THEN 5
                    WHEN 'Middle Age 41-59' THEN 6
                    WHEN 'Senior Citizen 60+' THEN 7
                END";
        $resultad = mysqli_query($connection, $getad);
        while($row = mysqli_fetch_assoc($resultad)){
            $agedistribution[] = $row['agedistribution'];
            $otadf[] = number_format($row['otad']);
        }

        // Gender Distribution
        $gettotalgd = "SELECT category.resident_Gender,
                   COUNT(r.resident_Gender) AS otgd
            FROM (
                SELECT 'Male' AS resident_Gender
                UNION ALL
                SELECT 'Female'
            ) AS category
            LEFT JOIN rpms_residents r
                ON category.resident_Gender = r.resident_Gender
            GROUP BY category.resident_Gender
            ORDER BY FIELD(category.resident_Gender, 'Male', 'Female')";
        $resulttotalgd = mysqli_query($connection, $gettotalgd);
        while($row = mysqli_fetch_assoc($resulttotalgd)){
            $rg[] = ucfirst(strtolower($row['resident_Gender']));
            $otgf[] = number_format($row['otgd']);
        }

        // Employment Status
        $gettotales = "SELECT category.resident_EmployerStatus, COUNT(r.resident_EmployerStatus) AS otes FROM ( SELECT 'Employed' AS resident_EmployerStatus UNION ALL SELECT 'Self-Employed' UNION ALL SELECT 'Unemployed' UNION ALL SELECT 'Retired' ) AS category LEFT JOIN rpms_residents r ON category.resident_EmployerStatus = r.resident_EmployerStatus GROUP BY category.resident_EmployerStatus ORDER BY FIELD(category.resident_EmployerStatus, 'Employed', 'Self-Employed', 'Unemployed', 'Retired' )";
        $resulttotales = mysqli_query($connection, $gettotales);
        while($row = mysqli_fetch_assoc($resulttotales)){
            $es[] = ucfirst(strtolower($row['resident_EmployerStatus']));
            $otesf[] = number_format($row['otes']);
        }

        // Civil Status
        $gettotalcs = "SELECT category.resident_CivilStatus, COUNT(r.resident_CivilStatus) AS otcs FROM ( SELECT 'Single' AS resident_CivilStatus UNION ALL SELECT 'Married' UNION ALL SELECT 'Civil' UNION ALL SELECT 'Live-in' UNION ALL SELECT 'Separated' UNION ALL SELECT 'Divorced' UNION ALL SELECT 'Widowed' UNION ALL SELECT 'Annuled' ) AS category LEFT JOIN rpms_residents r ON category.resident_CivilStatus = r.resident_CivilStatus GROUP BY category.resident_CivilStatus ORDER BY FIELD(category.resident_CivilStatus, 'Single', 'Married', 'Civil', 'Live-in', 'Separated', 'Divorced', 'Widowed', 'Annuled' )";
        $resulttotalcs = mysqli_query($connection, $gettotalcs);
        while($row = mysqli_fetch_assoc($resulttotalcs)){
            $cs[] = ucfirst(strtolower($row['resident_CivilStatus']));
            $otcsf[] = number_format($row['otcs']);
        }

        // Educational Attainment
        $gettotalet = "SELECT category.resident_EducationAttainment,
                   COUNT(r.resident_EducationAttainment) AS otet
            FROM (
                SELECT 'No Education' AS resident_EducationAttainment
                UNION ALL SELECT 'Elementary Level'
                UNION ALL SELECT 'Elementary Graduate'
                UNION ALL SELECT 'High School Level'
                UNION ALL SELECT 'High School Graduate'
                UNION ALL SELECT 'Junior High School Level'
                UNION ALL SELECT 'Junior High School Graduate'
                UNION ALL SELECT 'Senior High School Level'
                UNION ALL SELECT 'Senior High School Graduate'
                UNION ALL SELECT 'College Level'
                UNION ALL SELECT 'College Graduate'
                UNION ALL SELECT 'Vocational'
                UNION ALL SELECT 'Post-Graduate'
            ) AS category
            LEFT JOIN rpms_residents r
                ON category.resident_EducationAttainment = r.resident_EducationAttainment
            GROUP BY category.resident_EducationAttainment
            ORDER BY FIELD(category.resident_EducationAttainment,
                'No Education',
                'Elementary Level',
                'Elementary Graduate',
                'High School Level',
                'High School Graduate',
                'Junior High School Level',
                'Junior High School Graduate',
                'Senior High School Level',
                'Senior High School Graduate',
                'College Level',
                'College Graduate',
                'Vocational',
                'Post-Graduate'
            );";
        $resulttotalet = mysqli_query($connection, $gettotalet);
        while($row = mysqli_fetch_assoc($resulttotalet)){
            $et[] = ucfirst(strtolower($row['resident_EducationAttainment']));
            $otetf[] = number_format($row['otet']);
        }

        // Population Growth Trend
        $gettotalpgt = "SELECT YEAR(resident_Registered) AS yearregistered, COUNT(*) AS otyc FROM rpms_residents WHERE resident_Registered IS NOT NULL GROUP BY YEAR(resident_Registered) ORDER BY yearregistered DESC LIMIT 5";
        $resulttotalpgt = mysqli_query($connection, $gettotalpgt);
        while($row = mysqli_fetch_assoc($resulttotalpgt)){
            $yr[] = $row['yearregistered'];
            $otycf[] = number_format($row['otyc']);
        }

    }else{

        // Total Count
        $gettotalcount = "SELECT 
<<<<<<< HEAD
            COUNT(DISTINCT h.`household_ID`) AS totalhouseholds,
            COUNT(DISTINCT h.`household_StreetPurok`) AS totalpuroks, 
            COUNT(DISTINCT r.`resident_ID`) AS totalresidents, 
            COUNT(DISTINCT CASE WHEN r.`resident_VoterStatus` = 'REGISTERED' THEN r.`resident_ID` END) AS totalregisteredvoters, 
            COUNT(DISTINCT CASE WHEN r.`resident_PWD` = 1 THEN r.`resident_ID` END) AS totalpwd, 
            COUNT(DISTINCT CASE WHEN r.`resident_Fourps` = 1 THEN r.`resident_ID` END) AS total4ps, 
            COUNT(DISTINCT CASE WHEN r.`resident_Indigenous` = 1 THEN r.`resident_ID` END) AS totalindigenous, 
            COUNT(DISTINCT CASE WHEN r.`resident_ParentStatus` = 'YES' THEN r.`resident_ID` END) AS totalsoloparents, 
            COUNT(DISTINCT CASE WHEN TIMESTAMPDIFF(YEAR, r.`resident_DateofBirth`, CURDATE()) >= 60 THEN r.`resident_ID` END) AS totalseniorscitizens FROM `rpms_households` h LEFT JOIN `rpms_residents` r ON h.`household_Barangay` = r.`resident_Barangay` WHERE h.`household_Barangay` = '$appointed'";
=======
                COUNT(DISTINCT h.`household_ID`) AS totalhouseholds,
                COUNT(DISTINCT h.`household_StreetPurok`) AS totalpuroks,
                COUNT(DISTINCT r.`resident_ID`) AS totalresidents,
                SUM(r.`resident_VoterStatus` = 'REGISTERED') AS totalregisteredvoters,
                SUM(r.`resident_PWD` = 1) AS totalpwd,
                SUM(r.`resident_Fourps` = 1) AS total4ps,
                SUM(r.`resident_Indigenous` = 1) AS totalindigenous,
                SUM(r.`resident_ParentStatus` = 'YES') AS totalsoloparents,
                COUNT(DISTINCT CASE 
                    WHEN TIMESTAMPDIFF(YEAR, r.`resident_DateofBirth`, CURDATE()) >= 60 
                    THEN r.`resident_ID` 
                END) AS totalseniorscitizens
            FROM `rpms_households` h
            LEFT JOIN `rpms_residents` r ON h.`household_Barangay` = r.`resident_Barangay`
            WHERE h.`household_Barangay` = '$appointed'";
>>>>>>> ec28f0859aace89c457ce703dfd179e5118fdcdd
        $resulttotalcount = mysqli_query($connection, $gettotalcount);
        $row = mysqli_fetch_assoc($resulttotalcount);
        $othf   = number_format($row['totalhouseholds']);
        $otprf  = number_format($row['totalpuroks']);
        $otpf   = number_format($row['totalresidents']);
        $otrvf  = number_format($row['totalregisteredvoters']);
        $otpwdf = number_format($row['totalpwd']);
        $otfpf  = number_format($row['total4ps']);
        $otipf  = number_format($row['totalindigenous']);
        $otspf  = number_format($row['totalsoloparents']);
        $otsc  = number_format($row['totalseniorscitizens']);

        // New Total Count
        $getnewtotalcount = "SELECT
            (SELECT COUNT(*) 
             FROM `rpms_households` 
             WHERE `household_Barangay` = '$appointed'
               AND MONTH(`household_Registered`) = MONTH(CURDATE())
               AND YEAR(`household_Registered`) = YEAR(CURDATE())
            ) AS tnh,

            (SELECT COUNT(*) 
             FROM `rpms_residents` 
             WHERE `resident_Barangay` = '$appointed'
               AND MONTH(`resident_Registered`) = MONTH(CURDATE())
               AND YEAR(`resident_Registered`) = YEAR(CURDATE())
            ) AS tnr";
        $resultnewtotalcount = mysqli_query($connection, $getnewtotalcount);
        $row = mysqli_fetch_assoc($resultnewtotalcount);
        $tnhf   = number_format($row['tnh']);
        $tnrf   = number_format($row['tnr']);

        // Household Type
        $gettotalhht = "SELECT category.household_Type,
                   COUNT(r.household_Type) AS othht
            FROM (
                SELECT 'Owned' AS household_Type
                UNION ALL
                SELECT 'Rented'
            ) AS category
            LEFT JOIN rpms_households r
                ON category.household_Type = r.household_Type
                AND r.household_Barangay = '$appointed'
            GROUP BY category.household_Type
            ORDER BY FIELD(category.household_Type, 'Owned', 'Rented');";
        $resulttotalhht = mysqli_query($connection, $gettotalhht);
        while($row = mysqli_fetch_assoc($resulttotalhht)){
            $hhtype[] = ucfirst(strtolower($row['household_Type']));
            $othhtf[] = number_format($row['othht']);
        }

        // Household Size Distribution
        $gettotalhhsd = "SELECT category.household_Size,
                   COUNT(r.household_Size) AS oths
            FROM (
                SELECT 'Small (1-2 rooms)' AS household_Size
                UNION ALL
                SELECT 'Medium (3-4 rooms)'
                UNION ALL
                SELECT 'Large (5+ rooms)'
            ) AS category
            LEFT JOIN rpms_households r
                ON category.household_Size = r.household_Size
                AND r.household_Barangay = '$appointed'
            GROUP BY category.household_Size
            ORDER BY 
                FIELD(category.household_Size,
                    'Small (1-2 rooms)',
                    'Medium (3-4 rooms)',
                    'Large (5+ rooms)'
                )";
        $resulttotalhhsd = mysqli_query($connection, $gettotalhhsd);
        while($row = mysqli_fetch_assoc($resulttotalhhsd)){
            $hhs[] = ucfirst(strtolower($row['household_Size']));
            $othsf[] = number_format($row['oths']);
        }

        // Age Distribution
        $getad = "SELECT ag.age_group AS agedistribution,
                   COALESCE(COUNT(r.resident_ID), 0) AS otad
            FROM (
                SELECT 'Infant 0-2' AS age_group
                UNION ALL SELECT 'Child 3-12'
                UNION ALL SELECT 'Teen 13-17'
                UNION ALL SELECT 'Young Adult 18-25'
                UNION ALL SELECT 'Adult 26-40'
                UNION ALL SELECT 'Middle Age 41-59'
                UNION ALL SELECT 'Senior Citizen 60+'
            ) AS ag
            LEFT JOIN `rpms_residents` r
                ON r.resident_Barangay = '$appointed'
               AND (
                    (ag.age_group = 'Infant 0-2' AND TIMESTAMPDIFF(YEAR, r.resident_DateofBirth, CURDATE()) BETWEEN 0 AND 2) OR
                    (ag.age_group = 'Child 3-12' AND TIMESTAMPDIFF(YEAR, r.resident_DateofBirth, CURDATE()) BETWEEN 3 AND 12) OR
                    (ag.age_group = 'Teen 13-17' AND TIMESTAMPDIFF(YEAR, r.resident_DateofBirth, CURDATE()) BETWEEN 13 AND 17) OR
                    (ag.age_group = 'Young Adult 18-25' AND TIMESTAMPDIFF(YEAR, r.resident_DateofBirth, CURDATE()) BETWEEN 18 AND 25) OR
                    (ag.age_group = 'Adult 26-40' AND TIMESTAMPDIFF(YEAR, r.resident_DateofBirth, CURDATE()) BETWEEN 26 AND 40) OR
                    (ag.age_group = 'Middle Age 41-59' AND TIMESTAMPDIFF(YEAR, r.resident_DateofBirth, CURDATE()) BETWEEN 41 AND 59) OR
                    (ag.age_group = 'Senior Citizen 60+' AND TIMESTAMPDIFF(YEAR, r.resident_DateofBirth, CURDATE()) >= 60)
               )
            GROUP BY ag.age_group
            ORDER BY
                CASE ag.age_group
                    WHEN 'Infant 0-2' THEN 1
                    WHEN 'Child 3-12' THEN 2
                    WHEN 'Teen 13-17' THEN 3
                    WHEN 'Young Adult 18-25' THEN 4
                    WHEN 'Adult 26-40' THEN 5
                    WHEN 'Middle Age 41-59' THEN 6
                    WHEN 'Senior Citizen 60+' THEN 7
                END";
        $resultad = mysqli_query($connection, $getad);
        while($row = mysqli_fetch_assoc($resultad)){
            $agedistribution[] = $row['agedistribution'];
            $otadf[] = number_format($row['otad']);
        }

        // Gender Distribution
        $gettotalgd = "SELECT category.resident_Gender,
                   COUNT(r.resident_Gender) AS otgd
            FROM (
                SELECT 'Male' AS resident_Gender
                UNION ALL
                SELECT 'Female'
            ) AS category
            LEFT JOIN rpms_residents r
                ON category.resident_Gender = r.resident_Gender
                AND r.resident_Barangay = '$appointed'
            GROUP BY category.resident_Gender
            ORDER BY FIELD(category.resident_Gender, 'Male', 'Female')";
        $resulttotalgd = mysqli_query($connection, $gettotalgd);
        while($row = mysqli_fetch_assoc($resulttotalgd)){
            $rg[] = ucfirst(strtolower($row['resident_Gender']));
            $otgf[] = number_format($row['otgd']);
        }

        // Employment Status
        $gettotales = "SELECT category.resident_EmployerStatus, COUNT(r.resident_EmployerStatus) AS otes FROM ( SELECT 'Employed' AS resident_EmployerStatus UNION ALL SELECT 'Self-Employed' UNION ALL SELECT 'Unemployed' UNION ALL SELECT 'Retired' ) AS category LEFT JOIN rpms_residents r ON category.resident_EmployerStatus = r.resident_EmployerStatus AND r.resident_Barangay = '$appointed' GROUP BY category.resident_EmployerStatus ORDER BY FIELD(category.resident_EmployerStatus, 'Employed', 'Self-Employed', 'Unemployed', 'Retired' )";
        $resulttotales = mysqli_query($connection, $gettotales);
        while($row = mysqli_fetch_assoc($resulttotales)){
            $es[] = ucfirst(strtolower($row['resident_EmployerStatus']));
            $otesf[] = number_format($row['otes']);
        }

        // Civil Status
        $gettotalcs = "SELECT category.resident_CivilStatus, COUNT(r.resident_CivilStatus) AS otcs FROM ( SELECT 'Single' AS resident_CivilStatus UNION ALL SELECT 'Married' UNION ALL SELECT 'Civil' UNION ALL SELECT 'Live-in' UNION ALL SELECT 'Separated' UNION ALL SELECT 'Divorced' UNION ALL SELECT 'Widowed' UNION ALL SELECT 'Annuled' ) AS category LEFT JOIN rpms_residents r ON category.resident_CivilStatus = r.resident_CivilStatus AND r.resident_Barangay = '$appointed' GROUP BY category.resident_CivilStatus ORDER BY FIELD(category.resident_CivilStatus, 'Single', 'Married', 'Civil', 'Live-in', 'Separated', 'Divorced', 'Widowed', 'Annuled' )";
        $resulttotalcs = mysqli_query($connection, $gettotalcs);
        while($row = mysqli_fetch_assoc($resulttotalcs)){
            $cs[] = ucfirst(strtolower($row['resident_CivilStatus']));
            $otcsf[] = number_format($row['otcs']);
        }
        
        // Educational Attainment
        $gettotalet = "SELECT category.resident_EducationAttainment,
                   COUNT(r.resident_EducationAttainment) AS otet
            FROM (
                SELECT 'No Education' AS resident_EducationAttainment
                UNION ALL SELECT 'Elementary Level'
                UNION ALL SELECT 'Elementary Graduate'
                UNION ALL SELECT 'High School Level'
                UNION ALL SELECT 'High School Graduate'
                UNION ALL SELECT 'Junior High School Level'
                UNION ALL SELECT 'Junior High School Graduate'
                UNION ALL SELECT 'Senior High School Level'
                UNION ALL SELECT 'Senior High School Graduate'
                UNION ALL SELECT 'College Level'
                UNION ALL SELECT 'College Graduate'
                UNION ALL SELECT 'Vocational'
                UNION ALL SELECT 'Post-Graduate'
            ) AS category
            LEFT JOIN rpms_residents r
                ON category.resident_EducationAttainment = r.resident_EducationAttainment
                AND r.resident_Barangay = '$appointed'
            GROUP BY category.resident_EducationAttainment
            ORDER BY FIELD(category.resident_EducationAttainment,
                'No Education',
                'Elementary Level',
                'Elementary Graduate',
                'High School Level',
                'High School Graduate',
                'Junior High School Level',
                'Junior High School Graduate',
                'Senior High School Level',
                'Senior High School Graduate',
                'College Level',
                'College Graduate',
                'Vocational',
                'Post-Graduate'
            );";
        $resulttotalet = mysqli_query($connection, $gettotalet);
        while($row = mysqli_fetch_assoc($resulttotalet)){
            $et[] = ucfirst(strtolower($row['resident_EducationAttainment']));
            $otetf[] = number_format($row['otet']);
        }

        // Population Growth Trend
        $gettotalpgt = "SELECT YEAR(resident_Registered) AS yearregistered, COUNT(*) AS otyc FROM rpms_residents WHERE resident_Barangay = '$appointed' AND resident_Registered IS NOT NULL GROUP BY YEAR(resident_Registered) ORDER BY yearregistered DESC LIMIT 5";
        $resulttotalpgt = mysqli_query($connection, $gettotalpgt);
        while($row = mysqli_fetch_assoc($resulttotalpgt)){
            $yr[] = $row['yearregistered'];
            $otycf[] = number_format($row['otyc']);
        }
    }
        
?>