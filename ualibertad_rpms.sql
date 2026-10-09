-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2026 at 04:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ualibertad_rpms`
--

-- --------------------------------------------------------

--
-- Table structure for table `rpms_barangays`
--

CREATE TABLE `rpms_barangays` (
  `barangay_ID` int(11) NOT NULL,
  `barangay_Registered` datetime NOT NULL,
  `barangay_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_barangays`
--

INSERT INTO `rpms_barangays` (`barangay_ID`, `barangay_Registered`, `barangay_Name`) VALUES
(1, '2026-03-01 12:00:00', 'BARUSBUS'),
(2, '2026-02-26 12:00:00', 'BULANAO'),
(3, '2026-02-26 12:00:00', 'CENTRO ESTE (POBLACION)'),
(4, '2026-02-26 12:00:00', 'CENTRO WESTE (POBLACION)'),
(5, '2026-02-26 12:00:00', 'CODIONG'),
(6, '2026-02-26 12:00:00', 'CUBAY'),
(7, '2026-02-26 12:00:00', 'IGCAGAY'),
(8, '2026-02-26 12:00:00', 'INYAWAN'),
(9, '2026-02-26 12:00:00', 'LINDERO'),
(10, '2026-02-26 12:00:00', 'MARAMIG'),
(11, '2026-02-26 12:00:00', 'PUCIO'),
(12, '2026-02-26 12:00:00', 'PAJO'),
(13, '2026-02-26 12:00:00', 'PANANGKILON'),
(14, '2026-02-26 12:00:00', 'PAZ'),
(15, '2026-02-26 12:00:00', 'SAN ROQUE'),
(16, '2026-02-26 12:00:00', 'TINIGBAS'),
(17, '2026-02-26 12:00:00', 'TININDUGAN'),
(18, '2026-02-26 12:00:00', 'TABOC'),
(19, '2026-02-26 12:00:00', 'UNION A'),
(20, '2026-02-26 12:00:00', 'UNION B'),
(21, '2026-02-26 12:00:00', 'UNION C');

-- --------------------------------------------------------

--
-- Table structure for table `rpms_censusconfig`
--

CREATE TABLE `rpms_censusconfig` (
  `censusconfig_ID` int(11) NOT NULL,
  `censusconfig_Appointed` varchar(100) NOT NULL,
  `censusconfig_Type` varchar(100) NOT NULL,
  `censusconfig_Year` year(4) NOT NULL,
  `censusconfig_Context` varchar(100) NOT NULL,
  `censusconfig_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_censusconfig`
--

INSERT INTO `rpms_censusconfig` (`censusconfig_ID`, `censusconfig_Appointed`, `censusconfig_Type`, `censusconfig_Year`, `censusconfig_Context`, `censusconfig_Name`) VALUES
(1, 'UNION B', 'ANNUAL', '2026', '', ''),
(2, 'PAZ', 'ANNUAL', '2026', '', ''),
(3, 'TABOC', 'SPECIAL', '2026', 'LIVELIHOOD/ ECONOMIC IMPACT', 'COVVVI'),
(5, 'PUCIO', 'ANNUAL', '2026', '', ''),
(6, 'CODIONG', 'ANNUAL', '2026', '', ''),
(7, 'MAIN OFFICE', 'ANNUAL', '2026', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `rpms_databases`
--

CREATE TABLE `rpms_databases` (
  `database_ID` int(11) NOT NULL,
  `database_Filename` text NOT NULL,
  `database_Backup` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_databases`
--

INSERT INTO `rpms_databases` (`database_ID`, `database_Filename`, `database_Backup`) VALUES
(1, 'ualibertad_rpms-2026-03-28_22-26-06.sql', '2026-03-28 22:26:06'),
(2, 'ualibertad_rpms-2026-03-29_14-39-43.sql', '2026-03-29 14:39:43'),
(3, 'ualibertad_rpms-2026-03-29_16-30-18.sql', '2026-03-29 16:30:18'),
(4, 'ualibertad_rpms-2026-04-18_11-09-59.sql', '2026-04-18 11:09:59'),
(5, 'ualibertad_rpms-2026-04-18_11-11-19.sql', '2026-04-18 11:11:19'),
(6, 'ualibertad_rpms-2026-04-18_11-11-26.sql', '2026-04-18 11:11:26'),
(7, 'ualibertad_rpms-2026-04-18_11-11-33.sql', '2026-04-18 11:11:33'),
(8, 'ualibertad_rpms-2026-04-18_11-11-40.sql', '2026-04-18 11:11:40'),
(9, 'ualibertad_rpms-2026-04-18_11-11-50.sql', '2026-04-18 11:11:50'),
(10, 'ualibertad_rpms-2026-04-18_11-11-53.sql', '2026-04-18 11:11:53'),
(11, 'ualibertad_rpms-2026-04-18_11-11-56.sql', '2026-04-18 11:11:56');

-- --------------------------------------------------------

--
-- Table structure for table `rpms_householdcensus`
--

CREATE TABLE `rpms_householdcensus` (
  `hc_ID` int(11) NOT NULL,
  `hc_Created` datetime NOT NULL,
  `hc_Year` year(4) NOT NULL,
  `hc_Census` varchar(100) NOT NULL,
  `hc_Type` varchar(100) NOT NULL,
  `hc_Size` varchar(100) NOT NULL,
  `hc_Condition` varchar(100) NOT NULL,
  `hc_Utilities` text NOT NULL,
  `hc_Facilities` text NOT NULL,
  `household_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_householdcensus`
--

INSERT INTO `rpms_householdcensus` (`hc_ID`, `hc_Created`, `hc_Year`, `hc_Census`, `hc_Type`, `hc_Size`, `hc_Condition`, `hc_Utilities`, `hc_Facilities`, `household_ID`) VALUES
(1, '2026-06-09 12:00:19', '2026', 'ANNUAL', 'OWNED', 'SMALL (1-2 ROOMS)', 'NONE', 'NONE', 'NONE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rpms_householddisasterrelated`
--

CREATE TABLE `rpms_householddisasterrelated` (
  `hdr_ID` int(11) NOT NULL,
  `hdr_Created` datetime NOT NULL,
  `hdr_Year` year(4) NOT NULL,
  `hdr_DisasterName` varchar(100) NOT NULL,
  `hdr_DateofIncident` date NOT NULL,
  `hdr_DamageLevel` varchar(100) NOT NULL,
  `hdr_HouseStillLivable` int(11) NOT NULL,
  `hdr_EstimatedDamageCost` int(11) NOT NULL,
  `hdr_NumberofAffectedMembers` int(11) NOT NULL,
  `hdr_Evacuated` int(11) NOT NULL,
  `hdr_EvacuationCenterName` varchar(100) NOT NULL,
  `hdr_NeedsShelter` int(11) NOT NULL,
  `hdr_NeedsRepairAssistance` int(11) NOT NULL,
  `household_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_householddisasterrelated`
--

INSERT INTO `rpms_householddisasterrelated` (`hdr_ID`, `hdr_Created`, `hdr_Year`, `hdr_DisasterName`, `hdr_DateofIncident`, `hdr_DamageLevel`, `hdr_HouseStillLivable`, `hdr_EstimatedDamageCost`, `hdr_NumberofAffectedMembers`, `hdr_Evacuated`, `hdr_EvacuationCenterName`, `hdr_NeedsShelter`, `hdr_NeedsRepairAssistance`, `household_ID`) VALUES
(1, '2026-06-09 14:16:47', '2026', 'BAGYONG YOLANDA', '2026-06-09', 'NONE', 0, 0, 0, 0, '', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rpms_householdeducationschoolstatus`
--

CREATE TABLE `rpms_householdeducationschoolstatus` (
  `hess_ID` int(11) NOT NULL,
  `hess_Created` datetime NOT NULL,
  `hess_Year` year(4) NOT NULL,
  `hess_Name` varchar(100) NOT NULL,
  `hess_NumberofStudentsinHousehold` int(11) NOT NULL,
  `hess_NumberCurrentlyEnrolled` int(11) NOT NULL,
  `hess_NumberofOut-of-SchoolYouth` int(11) NOT NULL,
  `hess_AccesstoInternet` int(11) NOT NULL,
  `hess_HasGadgetsforLearning` int(11) NOT NULL,
  `hess_NeedsEducationalSupport` int(11) NOT NULL,
  `household_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_householdeducationschoolstatus`
--

INSERT INTO `rpms_householdeducationschoolstatus` (`hess_ID`, `hess_Created`, `hess_Year`, `hess_Name`, `hess_NumberofStudentsinHousehold`, `hess_NumberCurrentlyEnrolled`, `hess_NumberofOut-of-SchoolYouth`, `hess_AccesstoInternet`, `hess_HasGadgetsforLearning`, `hess_NeedsEducationalSupport`, `household_ID`) VALUES
(1, '2026-06-09 15:57:41', '2026', 'W876867', 0, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rpms_householdhealthemergency`
--

CREATE TABLE `rpms_householdhealthemergency` (
  `hhe_ID` int(11) NOT NULL,
  `hhe_Created` datetime NOT NULL,
  `hhe_Year` year(4) NOT NULL,
  `hhe_Name` varchar(100) NOT NULL,
  `hhe_HouseholdUnderMonitoring` int(11) NOT NULL,
  `hhe_NumberofSickMembers` int(11) NOT NULL,
  `hhe_TypeofDisease` varchar(100) NOT NULL,
  `hhe_QuarantineStatus` varchar(100) NOT NULL,
  `hhe_SanitationCondition` varchar(100) NOT NULL,
  `hhe_AccesstoCleanWater` int(11) NOT NULL,
  `hhe_NeedsMedicalAssistance` int(11) NOT NULL,
  `household_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_householdhealthemergency`
--

INSERT INTO `rpms_householdhealthemergency` (`hhe_ID`, `hhe_Created`, `hhe_Year`, `hhe_Name`, `hhe_HouseholdUnderMonitoring`, `hhe_NumberofSickMembers`, `hhe_TypeofDisease`, `hhe_QuarantineStatus`, `hhe_SanitationCondition`, `hhe_AccesstoCleanWater`, `hhe_NeedsMedicalAssistance`, `household_ID`) VALUES
(1, '2026-06-09 14:56:35', '2026', 'COVVVI', 0, 0, '', 'NONE', '0', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rpms_householdlivelihoodeconomicimpact`
--

CREATE TABLE `rpms_householdlivelihoodeconomicimpact` (
  `hlhe_ID` int(11) NOT NULL,
  `hlhe_Created` int(11) NOT NULL,
  `hlhe_Year` int(11) NOT NULL,
  `hlhe_Name` int(11) NOT NULL,
  `hlhe_MainSourceofIncome` varchar(100) NOT NULL,
  `hlhe_CombinedMonthlyIncomeBefore` int(11) NOT NULL,
  `hlhe_CombinedMonthlyIncomeAfter` int(11) NOT NULL,
  `hlhe_NumberofWorkingMember` int(11) NOT NULL,
  `hlhe_NumberofWorkingUnemployed` int(11) NOT NULL,
  `hlhe_NeedsLivelihoodAssistance` int(11) NOT NULL,
  `household_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_householdlivelihoodeconomicimpact`
--

INSERT INTO `rpms_householdlivelihoodeconomicimpact` (`hlhe_ID`, `hlhe_Created`, `hlhe_Year`, `hlhe_Name`, `hlhe_MainSourceofIncome`, `hlhe_CombinedMonthlyIncomeBefore`, `hlhe_CombinedMonthlyIncomeAfter`, `hlhe_NumberofWorkingMember`, `hlhe_NumberofWorkingUnemployed`, `hlhe_NeedsLivelihoodAssistance`, `household_ID`) VALUES
(1, 2026, 2026, 0, 'E324234432', 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rpms_households`
--

CREATE TABLE `rpms_households` (
  `household_ID` int(11) NOT NULL,
  `household_Registered` datetime NOT NULL,
  `household_IDNumber` varchar(100) NOT NULL,
  `household_StreetPurok` varchar(100) NOT NULL,
  `household_Barangay` varchar(100) NOT NULL,
  `household_Municipality` varchar(100) NOT NULL,
  `household_Province` varchar(100) NOT NULL,
  `household_Type` varchar(100) NOT NULL,
  `household_Size` varchar(100) NOT NULL,
  `household_Condition` varchar(100) NOT NULL,
  `household_Utilities` text NOT NULL,
  `household_Facilities` text NOT NULL,
  `household_LastModified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_households`
--

INSERT INTO `rpms_households` (`household_ID`, `household_Registered`, `household_IDNumber`, `household_StreetPurok`, `household_Barangay`, `household_Municipality`, `household_Province`, `household_Type`, `household_Size`, `household_Condition`, `household_Utilities`, `household_Facilities`, `household_LastModified`) VALUES
(1, '2026-03-01 12:28:51', 'HHTAB2026000001', 'PUROK I', 'TABOC', 'LIBERTAD', 'ANTIQUE', 'OWNED', 'SMALL (1-2 ROOMS)', 'NONE', 'NONE', 'NONE', '2026-06-09 12:00:19'),
(5, '2026-03-01 16:50:43', 'HHTAB2026000002', 'PUROK II', 'TABOC', 'LIBERTAD', 'ANTIQUE', 'OWNED', 'SMALL (1-2 ROOMS)', 'LIGHT MATERIALS', 'ELECTRICITY, WATER', 'KITCHEN, DINING AREA, LIVING ROOM, BEDROOMS', '0000-00-00 00:00:00'),
(6, '2026-03-01 17:10:46', 'HHTAB2026000003', 'PUROK I', 'TABOC', 'LIBERTAD', 'ANTIQUE', 'RENTED', 'LARGE (5+ ROOMS)', 'CONCRETE', 'ELECTRICITY, WATER, GAS/ LPG', 'KITCHEN, DINING AREA, LIVING ROOM, BEDROOMS', '2026-03-25 12:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `rpms_householdsocialassistancebeneficiary`
--

CREATE TABLE `rpms_householdsocialassistancebeneficiary` (
  `hsab_ID` int(11) NOT NULL,
  `hsab_Created` datetime NOT NULL,
  `hsab_Year` year(4) NOT NULL,
  `hsab_Name` varchar(100) NOT NULL,
  `hsab_4PsHousehold` int(11) NOT NULL,
  `hsab_TotalEligibleMembers` int(11) NOT NULL,
  `hsab_TotalSeniorCitizens` int(11) NOT NULL,
  `hsab_TotalPWDs` int(11) NOT NULL,
  `hsab_TotalSoloParents` int(11) NOT NULL,
  `household_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_householdsocialassistancebeneficiary`
--

INSERT INTO `rpms_householdsocialassistancebeneficiary` (`hsab_ID`, `hsab_Created`, `hsab_Year`, `hsab_Name`, `hsab_4PsHousehold`, `hsab_TotalEligibleMembers`, `hsab_TotalSeniorCitizens`, `hsab_TotalPWDs`, `hsab_TotalSoloParents`, `household_ID`) VALUES
(1, '2026-06-09 15:34:14', '2026', '453', 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rpms_rattachments`
--

CREATE TABLE `rpms_rattachments` (
  `rattachment_ID` int(11) NOT NULL,
  `rattachment_Filename` text NOT NULL,
  `rattachment_Size` text NOT NULL,
  `rattachment_Uploaded` datetime NOT NULL,
  `resident_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_rattachments`
--

INSERT INTO `rpms_rattachments` (`rattachment_ID`, `rattachment_Filename`, `rattachment_Size`, `rattachment_Uploaded`, `resident_ID`) VALUES
(8, 'DENR R6-REGIONAL CC 2025-final (2).pdf', '1.41 MB', '2026-03-21 21:57:42', 30),
(12, 'DENR R6-REGIONAL CC 2025-final (2)(1).pdf', '1.41 MB', '2026-03-21 22:10:57', 30),
(13, 'MASL-Resume.pdf', '188.92 KB', '2026-03-21 22:10:57', 30),
(14, 'Salary Loan SSS.pdf', '476.43 KB', '2026-03-21 22:10:57', 30),
(20, 'Bizlink Debit Memo.pdf', '388.22 KB', '2026-03-26 16:26:03', 32),
(23, 'Certificate of Live Birth - eCRMIS.pdf', '441.5 KB', '2026-03-26 16:27:23', 32),
(24, 'Ma. Aliza Resume.pdf', '239.28 KB', '2026-04-18 11:04:40', 34);

-- --------------------------------------------------------

--
-- Table structure for table `rpms_residentcensus`
--

CREATE TABLE `rpms_residentcensus` (
  `rc_ID` int(11) NOT NULL,
  `rc_Created` datetime NOT NULL,
  `rc_Year` year(4) NOT NULL,
  `rc_Census` varchar(100) NOT NULL,
  `rc_EducationAttainment` varchar(100) NOT NULL,
  `rc_PWD` int(11) NOT NULL,
  `rc_Fourps` int(11) NOT NULL,
  `rc_Occupation` varchar(100) NOT NULL,
  `rc_MonthlyIncome` int(11) NOT NULL,
  `rc_EmployerStatus` varchar(100) NOT NULL,
  `resident_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_residentcensus`
--

INSERT INTO `rpms_residentcensus` (`rc_ID`, `rc_Created`, `rc_Year`, `rc_Census`, `rc_EducationAttainment`, `rc_PWD`, `rc_Fourps`, `rc_Occupation`, `rc_MonthlyIncome`, `rc_EmployerStatus`, `resident_ID`) VALUES
(1, '2026-06-11 13:30:31', '2026', 'ANNUAL', 'NONE', 0, 1, 'NONERWRERW', 321321, 'NONE', 34),
(2, '2026-06-11 13:30:41', '2026', 'ANNUAL', 'NONE', 0, 0, '32434234234', 65879789, 'NONE', 33),
(6, '2026-06-11 15:31:17', '2026', 'MID-YEAR', 'NONE', 0, 0, '', 0, 'NONE', 34);

-- --------------------------------------------------------

--
-- Table structure for table `rpms_residentdisasterrelated`
--

CREATE TABLE `rpms_residentdisasterrelated` (
  `rdr_ID` int(11) NOT NULL,
  `rdr_Created` datetime NOT NULL,
  `rdr_Year` year(4) NOT NULL,
  `rdr_Name` varchar(100) NOT NULL,
  `rdr_Affected` int(11) NOT NULL,
  `rdr_Missing` int(11) NOT NULL,
  `rdr_Deceased` int(11) NOT NULL,
  `rdr_Displaced` int(11) NOT NULL,
  `rdr_NeedsMedicalAttention` int(11) NOT NULL,
  `rdr_NeedsFoodAssistance` int(11) NOT NULL,
  `rdr_NeedsShelter` int(11) NOT NULL,
  `rdr_InjuryStatus` varchar(100) NOT NULL,
  `rdr_CurrentLocation` varchar(100) NOT NULL,
  `resident_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_residentdisasterrelated`
--

INSERT INTO `rpms_residentdisasterrelated` (`rdr_ID`, `rdr_Created`, `rdr_Year`, `rdr_Name`, `rdr_Affected`, `rdr_Missing`, `rdr_Deceased`, `rdr_Displaced`, `rdr_NeedsMedicalAttention`, `rdr_NeedsFoodAssistance`, `rdr_NeedsShelter`, `rdr_InjuryStatus`, `rdr_CurrentLocation`, `resident_ID`) VALUES
(1, '2026-06-15 10:00:46', '2026', 'COVVVI', 0, 0, 0, 0, 0, 0, 0, 'MINOR', 'EVACUATION', 34);

-- --------------------------------------------------------

--
-- Table structure for table `rpms_residenteducationschoolstatus`
--

CREATE TABLE `rpms_residenteducationschoolstatus` (
  `ress_ID` int(11) NOT NULL,
  `ress_Created` datetime NOT NULL,
  `ress_Year` year(4) NOT NULL,
  `ress_Name` varchar(100) NOT NULL,
  `ress_CurrentlyEnrolled` int(11) NOT NULL,
  `ress_SchoolName` varchar(100) NOT NULL,
  `ress_GradeLevel` varchar(100) NOT NULL,
  `ress_ModeofLearning` varchar(100) NOT NULL,
  `ress_DroppedOut` int(11) NOT NULL,
  `ress_NeedsEducationalSupport` int(11) NOT NULL,
  `resident_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_residenteducationschoolstatus`
--

INSERT INTO `rpms_residenteducationschoolstatus` (`ress_ID`, `ress_Created`, `ress_Year`, `ress_Name`, `ress_CurrentlyEnrolled`, `ress_SchoolName`, `ress_GradeLevel`, `ress_ModeofLearning`, `ress_DroppedOut`, `ress_NeedsEducationalSupport`, `resident_ID`) VALUES
(1, '2026-04-18 14:20:13', '2026', '3213213', 0, 'SAS', 'SASA', 'FACE-TO-FACE', 0, 0, 34);

-- --------------------------------------------------------

--
-- Table structure for table `rpms_residenthealthemergency`
--

CREATE TABLE `rpms_residenthealthemergency` (
  `rhe_ID` int(11) NOT NULL,
  `rhe_Created` datetime NOT NULL,
  `rhe_Year` year(4) NOT NULL,
  `rhe_Name` varchar(100) NOT NULL,
  `rhe_Symptoms` int(11) NOT NULL,
  `rhe_UnderMonitoring` int(11) NOT NULL,
  `rhe_SymptomDetails` varchar(100) NOT NULL,
  `rhe_DiagnosedDisease` varchar(100) NOT NULL,
  `rhe_QuarantineStatus` varchar(100) NOT NULL,
  `rhe_VaccinationStatus` varchar(100) NOT NULL,
  `rhe_DateDiagnosed` date NOT NULL,
  `rhe_RecoveryStatus` varchar(100) NOT NULL,
  `resident_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_residenthealthemergency`
--

INSERT INTO `rpms_residenthealthemergency` (`rhe_ID`, `rhe_Created`, `rhe_Year`, `rhe_Name`, `rhe_Symptoms`, `rhe_UnderMonitoring`, `rhe_SymptomDetails`, `rhe_DiagnosedDisease`, `rhe_QuarantineStatus`, `rhe_VaccinationStatus`, `rhe_DateDiagnosed`, `rhe_RecoveryStatus`, `resident_ID`) VALUES
(1, '2026-06-15 11:53:19', '2026', 'COVVVI', 0, 0, 'SDDSADS', 'DSADSADSAD', 'NONE', 'NONE', '2026-06-15', 'RECOVERED', 33),
(2, '2026-06-15 11:53:30', '2026', 'COVVVI', 0, 0, 'DASDSAD', 'DSADEQWE', 'NONE', 'PARTIAL', '2026-06-15', 'RECOVERED', 26);

-- --------------------------------------------------------

--
-- Table structure for table `rpms_residentlivelihoodeconomicimpact`
--

CREATE TABLE `rpms_residentlivelihoodeconomicimpact` (
  `rlhei_ID` int(11) NOT NULL,
  `rlhei_Created` datetime NOT NULL,
  `rlhei_Year` year(4) NOT NULL,
  `rlhei_Name` varchar(100) NOT NULL,
  `rlhei_EmploymentStatus` varchar(100) NOT NULL,
  `rlhei_JobLost` int(11) NOT NULL,
  `rlhei_TypeofWork` varchar(100) NOT NULL,
  `rlhei_Occupation` varchar(100) NOT NULL,
  `rlhei_MonthlyIncomeBefore` int(11) NOT NULL,
  `rlhei_MonthlyIncomeAfter` int(11) NOT NULL,
  `rlhei_BusinessAffected` int(11) NOT NULL,
  `rlhei_NeedsLivelihoodAssistance` int(11) NOT NULL,
  `resident_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_residentlivelihoodeconomicimpact`
--

INSERT INTO `rpms_residentlivelihoodeconomicimpact` (`rlhei_ID`, `rlhei_Created`, `rlhei_Year`, `rlhei_Name`, `rlhei_EmploymentStatus`, `rlhei_JobLost`, `rlhei_TypeofWork`, `rlhei_Occupation`, `rlhei_MonthlyIncomeBefore`, `rlhei_MonthlyIncomeAfter`, `rlhei_BusinessAffected`, `rlhei_NeedsLivelihoodAssistance`, `resident_ID`) VALUES
(1, '2026-04-18 14:04:18', '2026', 'SASASA', 'UNEMPLOYED', 0, 'FORMAL', 'DSADSDA', 324344, 4324324, 0, 0, 34);

-- --------------------------------------------------------

--
-- Table structure for table `rpms_residents`
--

CREATE TABLE `rpms_residents` (
  `resident_ID` int(11) NOT NULL,
  `resident_Registered` datetime NOT NULL,
  `resident_IDNumber` varchar(100) NOT NULL,
  `resident_HouseRole` varchar(100) NOT NULL,
  `resident_ResidentStatus` varchar(100) NOT NULL,
  `resident_ProfilePicture` text NOT NULL,
  `resident_FirstName` varchar(100) NOT NULL,
  `resident_MiddleName` varchar(100) NOT NULL,
  `resident_LastName` varchar(100) NOT NULL,
  `resident_Suffix` varchar(100) NOT NULL,
  `resident_DateofBirth` date NOT NULL,
  `resident_Age` int(11) NOT NULL,
  `resident_Gender` varchar(100) NOT NULL,
  `resident_StreetPurok` varchar(100) NOT NULL,
  `resident_Barangay` varchar(100) NOT NULL,
  `resident_Municipality` varchar(100) NOT NULL,
  `resident_Province` varchar(100) NOT NULL,
  `resident_CivilStatus` varchar(100) NOT NULL,
  `resident_Religion` varchar(100) NOT NULL,
  `resident_Nationality` varchar(100) NOT NULL,
  `resident_ContactNumber` varchar(11) NOT NULL,
  `resident_EmailAddress` varchar(100) NOT NULL,
  `resident_EducationAttainment` varchar(100) NOT NULL,
  `resident_Height` varchar(50) NOT NULL,
  `resident_Weight` decimal(5,2) NOT NULL,
  `resident_BloodType` varchar(100) NOT NULL,
  `resident_ParentStatus` varchar(100) NOT NULL,
  `resident_PWD` int(11) NOT NULL,
  `resident_Fourps` int(11) NOT NULL,
  `resident_Indigenous` int(11) NOT NULL,
  `resident_VoterStatus` varchar(100) NOT NULL,
  `resident_IDType` varchar(100) NOT NULL,
  `resident_IDTypeNumber` varchar(100) NOT NULL,
  `resident_Occupation` varchar(100) NOT NULL,
  `resident_EmployerBusinessName` varchar(100) NOT NULL,
  `resident_MonthlyIncome` int(11) NOT NULL,
  `resident_EmployerStatus` varchar(100) NOT NULL,
  `household_ID` int(11) NOT NULL,
  `resident_LastModified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_residents`
--

INSERT INTO `rpms_residents` (`resident_ID`, `resident_Registered`, `resident_IDNumber`, `resident_HouseRole`, `resident_ResidentStatus`, `resident_ProfilePicture`, `resident_FirstName`, `resident_MiddleName`, `resident_LastName`, `resident_Suffix`, `resident_DateofBirth`, `resident_Age`, `resident_Gender`, `resident_StreetPurok`, `resident_Barangay`, `resident_Municipality`, `resident_Province`, `resident_CivilStatus`, `resident_Religion`, `resident_Nationality`, `resident_ContactNumber`, `resident_EmailAddress`, `resident_EducationAttainment`, `resident_Height`, `resident_Weight`, `resident_BloodType`, `resident_ParentStatus`, `resident_PWD`, `resident_Fourps`, `resident_Indigenous`, `resident_VoterStatus`, `resident_IDType`, `resident_IDTypeNumber`, `resident_Occupation`, `resident_EmployerBusinessName`, `resident_MonthlyIncome`, `resident_EmployerStatus`, `household_ID`, `resident_LastModified`) VALUES
(21, '2025-03-01 14:13:40', 'RTAB20262096', 'HEAD OF HOUSEHOLD', 'PERMANENT', 'RTAB20262096(260515092927).webp', 'CSASA', 'C', 'C', 'N/A', '1950-01-17', 76, 'MALE', 'PUROK I', 'TABOC', 'LIBERTAD', 'ANTIQUE', 'SINGLE', 'A', 'A', '09123456789', 'sample@gmail.com', 'ELEMENTARY GRADUATE', '5\'5\'\'', 86.00, 'A', 'N/A', 0, 0, 0, 'NOT ELIGIBLE', 'EWQEQW', '3434', '', '4', 0, 'SELF-EMPLOYED', 1, '2026-05-15 09:29:27'),
(24, '2026-03-01 16:50:43', 'RTAB20268869', 'HEAD OF HOUSEHOLD', 'PERMANENT', 'Default.png', 'CRISTINA', 'ALFONSO', 'GIN', 'N/A', '1945-05-04', 80, 'FEMALE', 'PUROK II', 'TABOC', 'LIBERTAD', 'ANTIQUE', 'LIVE-IN', 'N/A', 'FILIPINO', '', '', 'NO EDUCATION', '5\'5\"', 0.00, 'A', 'YES', 0, 0, 0, 'REGISTERED', 'NONE', '', 'N/A', '', 0, 'UNEMPLOYED', 5, '2026-03-29 21:01:02'),
(25, '2026-03-01 17:10:46', 'RTAB20266981', 'HEAD OF HOUSEHOLD', 'PERMANENT', 'RTAB20266981(260515092907).webp', 'UYIUY', 'IUIU', 'DSFSD', 'N/A', '1999-06-08', 26, 'FEMALE', 'PUROK I', 'TABOC', 'LIBERTAD', 'ANTIQUE', 'MARRIED', 'CATHOLIC', 'FILIPINO', '09779787978', '', 'NONE', '5\'4', 45.00, 'A', 'N/A', 0, 0, 0, 'REGISTERED', 'TIN ID', '78998769669', 'I68678787867', 'NONE', 0, 'NONE', 6, '2026-06-11 14:56:10'),
(26, '2026-03-01 17:13:20', 'RTAB20263979', 'SPOUSE', 'TEMPORARY', 'RTAB20263979(260515092818).webp', 'AAAA', 'AA', 'REWR', 'N/A', '1999-01-17', 27, 'FEMALE', 'PUROK I', 'TABOC', 'LIBERTAD', 'ANTIQUE', 'MARRIED', 'CATHOLCI', 'FILIPINO', '09656546565', '', 'COLLEGE GRADUATE', '5\'5', 70.00, 'B', 'N/A', 0, 0, 0, 'NOT ELIGIBLE', 'TIN ID', '432434342', 'SOFTWARE ENGINEER', 'N/A', 40000, 'SELF-EMPLOYED', 6, '2026-05-15 09:28:28'),
(30, '2026-03-20 22:31:15', 'RTAB20262970', 'CHILD', 'PERMANENT', 'RTAB20262970(260515092850).webp', 'SDAD', 'DSAD', 'DSADS', 'I', '2026-03-20', 0, 'MALE', 'PUROK I', 'TABOC', 'LIBERTAD', 'ANTIQUE', 'MARRIED', 'DASDD', 'DSADSAD', '', '', 'NONE', '6\'6', 66.00, 'O', 'N/A', 0, 1, 0, 'NOT ELIGIBLE', 'NONE', '', '', '', 5454, 'NONE', 6, '2026-06-22 11:36:05'),
(31, '2026-03-21 22:48:03', 'RTAB20266682', 'CHILD', 'TEMPORARY', 'Default.png', 'EWE', 'EWQE', 'EQW', 'JR', '2026-03-21', 0, 'MALE', 'PUROK I', 'TABOC', 'LIBERTAD', 'ANTIQUE', 'MARRIED', 'EWQE', 'EQWE', '', '', 'NONE', '3\'', 3.00, 'A', 'YES', 0, 0, 0, 'NOT ELIGIBLE', 'NONE', '', '', '', 0, 'NONE', 6, '2026-06-11 15:31:26'),
(33, '2026-04-18 11:02:11', 'RTAB20264862', 'PARENT', 'RENTER', 'Default.png', 'DSDADAS', 'DSDSA', 'DSADAS', 'II', '2026-04-18', 0, 'FEMALE', 'PUROK I', 'TABOC', 'LIBERTAD', 'ANTIQUE', 'MARRIED', 'DSDAS', 'DSADSAD', '09545435345', '', 'NONE', '4\'4\"', 44.00, 'B', 'N/A', 0, 0, 0, 'NOT ELIGIBLE', 'DRIVERS LICENSE', '', '', '', 0, 'NONE', 1, '2026-06-11 15:31:21'),
(34, '2026-04-18 11:04:40', 'RTAB20262631', 'GRANDCHILD', 'PERMANENT', 'Default.png', 'JJJ', 'JJJ', 'JJ', 'SR', '2026-04-18', 0, 'MALE', 'PUROK I', 'TABOC', 'LIBERTAD', 'ANTIQUE', 'MARRIED', 'J', 'J', '09808908909', '', 'NONE', '5\'55', 66.00, 'B', 'N/A', 0, 0, 1, 'NOT ELIGIBLE', 'NONE', '', '', '', 0, 'NONE', 1, '2026-06-22 11:35:55');

-- --------------------------------------------------------

--
-- Table structure for table `rpms_residentsocialassistancebeneficiary`
--

CREATE TABLE `rpms_residentsocialassistancebeneficiary` (
  `rsab_ID` int(11) NOT NULL,
  `rsab_Created` datetime NOT NULL,
  `rsab_Year` year(4) NOT NULL,
  `rsab_Name` varchar(100) NOT NULL,
  `rsab_4PsBeneficiary` int(11) NOT NULL,
  `rsab_SeniorCitizen` int(11) NOT NULL,
  `rsab_PersonwithDisability` int(11) NOT NULL,
  `rsab_SoloParent` int(11) NOT NULL,
  `rsab_AssistanceType` varchar(100) NOT NULL,
  `rsab_AmountReceived` int(11) NOT NULL,
  `rsab_DateReceived` date NOT NULL,
  `resident_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_residentsocialassistancebeneficiary`
--

INSERT INTO `rpms_residentsocialassistancebeneficiary` (`rsab_ID`, `rsab_Created`, `rsab_Year`, `rsab_Name`, `rsab_4PsBeneficiary`, `rsab_SeniorCitizen`, `rsab_PersonwithDisability`, `rsab_SoloParent`, `rsab_AssistanceType`, `rsab_AmountReceived`, `rsab_DateReceived`, `resident_ID`) VALUES
(1, '2026-04-18 14:11:31', '2026', '3243432', 0, 0, 0, 0, 'CASH', 3213213, '2026-04-18', 34);

-- --------------------------------------------------------

--
-- Table structure for table `rpms_settings`
--

CREATE TABLE `rpms_settings` (
  `setting_ID` int(11) NOT NULL,
  `setting_Key` varchar(100) NOT NULL,
  `setting_Value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_settings`
--

INSERT INTO `rpms_settings` (`setting_ID`, `setting_Key`, `setting_Value`) VALUES
(1, 'system_logo', 'Libertad Logo.webp'),
(3, 'system_api_email', 'ittm nhuj nnnj yjwa');

-- --------------------------------------------------------

--
-- Table structure for table `rpms_userlogs`
--

CREATE TABLE `rpms_userlogs` (
  `userlogs_ID` int(11) NOT NULL,
  `user_ID` int(11) NOT NULL,
  `userlogs_Action` varchar(100) NOT NULL,
  `userlogs_Module` varchar(100) NOT NULL,
  `userlogs_RecordID` int(11) NOT NULL,
  `userlogs_Description` text NOT NULL,
  `userlogs_IPAddress` varchar(100) NOT NULL,
  `userlogs_Agent` text NOT NULL,
  `userlogs_Created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_userlogs`
--

INSERT INTO `rpms_userlogs` (`userlogs_ID`, `user_ID`, `userlogs_Action`, `userlogs_Module`, `userlogs_RecordID`, `userlogs_Description`, `userlogs_IPAddress`, `userlogs_Agent`, `userlogs_Created`) VALUES
(1, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 20:23:01'),
(2, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 20:27:13'),
(3, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 20:36:58'),
(4, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 20:38:46'),
(5, 14, 'PASSWORD CHANGE', 'CHANGE PASSWORD', 14, 'USER CHANGED THEIR ACCOUNT PASSWORD', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 20:49:00'),
(6, 14, 'UPDATE', 'USER PROFILE', 14, 'USER UPDATED THEIR PERSONAL INFORMATION', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 20:50:14'),
(8, 14, 'UPDATE', 'HOUSEHOLD MANAGEMENT', 6, 'USER UPDATED HOUSEHOLD INFORMATION FOR HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 20:58:19'),
(9, 14, 'CREATE', 'RESIDENT MANAGEMENT', 6, 'USER ADDED NEW RESIDENT(S) TO HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:12:39'),
(10, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 6, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20261639 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:18:19'),
(11, 14, 'DELETE', 'RESIDENT MANAGEMENT', 29, 'USER DELETED RESIDENT RTAB20261639 FROM HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:22:25'),
(12, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 26, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20263979 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:28:06'),
(13, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:30:44'),
(14, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:30:54'),
(15, 1, 'UPDATE', 'USER MANAGEMENT', 4, 'USER UPDATED PASSWORD FOR USER ACCOUNT A A A', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:37:07'),
(16, 1, 'UPDATE', 'USER MANAGEMENT', 4, 'USER UPDATED INFORMATION FOR USER ACCOUNT A A A', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:38:06'),
(17, 1, 'DELETE', 'USER MANAGEMENT', 4, 'USER DELETED USER ACCOUNT A A A', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:39:43'),
(18, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:44:33'),
(19, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:44:42'),
(20, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:57:29'),
(21, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:57:37'),
(22, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:58:43'),
(23, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:58:55'),
(24, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:59:04'),
(25, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 21:59:15'),
(26, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 22:05:12'),
(27, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 22:05:38'),
(28, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 22:06:23'),
(29, 14, 'CREATE', 'RESIDENT MANAGEMENT', 6, 'USER ADDED NEW RESIDENT(S) TO HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 22:31:16'),
(30, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 26, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20263979 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 22:31:57'),
(31, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 26, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20263979 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 22:32:36'),
(32, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 26, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20263979 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 22:33:09'),
(33, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 26, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20263979 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-20 22:33:45'),
(34, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 09:45:40'),
(35, 1, 'CREATE', 'BARANGAY MANAGEMENT', 1, 'USER CREATED A NEW BARANGAY DASDSDSAD', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:09:24'),
(36, 1, 'CREATE', 'BARANGAY MANAGEMENT', 24, 'USER CREATED A NEW BARANGAY 543545', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:09:59'),
(37, 1, 'CREATE', 'BARANGAY MANAGEMENT', 48, 'USER CREATED A NEW BARANGAY 676767', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:12:25'),
(38, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 48, 'USER UPDATED DETAILS FOR BARANGAY 676767', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:39:16'),
(39, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 48, 'USER UPDATED DETAILS FOR BARANGAY 676767', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:39:19'),
(40, 1, 'DELETE', 'BARANGAY MANAGEMENT', 47, 'USER DELETED BARANGAY NAME DSADASDS', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:46:01'),
(41, 1, 'DELETE', 'BARANGAY MANAGEMENT', 25, 'USER DELETED BARANGAY NAME DSADS', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:47:06'),
(42, 1, 'DELETE', 'BARANGAY MANAGEMENT', 24, 'USER DELETED BARANGAY NAME 543545', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:48:02'),
(43, 1, 'DELETE', 'BARANGAY MANAGEMENT', 23, 'USER DELETED BARANGAY NAME DASDSDSAD', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:48:06'),
(44, 1, 'DELETE', 'BARANGAY MANAGEMENT', 22, 'USER DELETED BARANGAY NAME DSAD', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:48:09'),
(45, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 1, 'USER UPDATED DETAILS FOR BARANGAY BARUSBUS', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:48:26'),
(46, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 13, 'USER UPDATED DETAILS FOR BARANGAY PANANGKILON', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:48:29'),
(47, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 14, 'USER UPDATED DETAILS FOR BARANGAY PAZ', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:48:32'),
(48, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 15, 'USER UPDATED DETAILS FOR BARANGAY SAN ROQUE', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:48:35'),
(49, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 16, 'USER UPDATED DETAILS FOR BARANGAY TINIGBAS', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:48:39'),
(50, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 17, 'USER UPDATED DETAILS FOR BARANGAY TININDUGAN', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:48:43'),
(51, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 18, 'USER UPDATED DETAILS FOR BARANGAY TABOC', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:48:47'),
(52, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 19, 'USER UPDATED DETAILS FOR BARANGAY UNION A', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:48:51'),
(53, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 12, 'USER UPDATED DETAILS FOR BARANGAY PAJO', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:48:54'),
(54, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 11, 'USER UPDATED DETAILS FOR BARANGAY PUCIO', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:48:58'),
(55, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 10, 'USER UPDATED DETAILS FOR BARANGAY MARAMIG', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:49:02'),
(56, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 2, 'USER UPDATED DETAILS FOR BARANGAY BULANAO', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:49:05'),
(57, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 3, 'USER UPDATED DETAILS FOR BARANGAY CENTRO ESTE (POBLACION)', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 11:49:13'),
(58, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 4, 'USER UPDATED DETAILS FOR BARANGAY CENTRO WESTE (POBLACION)', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 12:55:17'),
(59, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 5, 'USER UPDATED DETAILS FOR BARANGAY CODIONG', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 12:55:22'),
(60, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 6, 'USER UPDATED DETAILS FOR BARANGAY CUBAY', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 12:55:26'),
(61, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 7, 'USER UPDATED DETAILS FOR BARANGAY IGCAGAY', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 13:28:58'),
(62, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 8, 'USER UPDATED DETAILS FOR BARANGAY INYAWAN', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 13:29:02'),
(63, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 9, 'USER UPDATED DETAILS FOR BARANGAY LINDERO', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 13:29:06'),
(64, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 21, 'USER UPDATED DETAILS FOR BARANGAY UNION C', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 13:29:10'),
(65, 1, 'BACKUP', 'DATABASE', 7, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 14:10:36'),
(66, 1, 'BACKUP', 'DATABASE', 8, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 14:13:58'),
(67, 1, 'BACKUP', 'DATABASE', 9, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 14:15:29'),
(68, 1, 'BACKUP', 'DATABASE', 10, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 14:16:15'),
(69, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 19:24:21'),
(70, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 19:24:55'),
(71, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 19:28:54'),
(72, 14, 'UPLOAD', 'FILE MANAGEMENT', 30, 'USER UPLOADED A FILE FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 20:52:49'),
(73, 14, 'UPLOAD', 'FILE MANAGEMENT', 30, 'USER UPLOADED A FILE FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 20:55:50'),
(74, 14, 'UPLOAD', 'FILE MANAGEMENT', 30, 'USER UPLOADED A FILE FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 20:55:59'),
(75, 14, 'UPLOAD', 'FILE MANAGEMENT', 30, 'USER UPLOADED A FILE FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 20:56:25'),
(76, 14, 'DELETE', 'FILE MANAGEMENT', 30, 'USER DELETED FILE MASL-Resume.pdf FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 21:39:25'),
(77, 14, 'DELETE', 'FILE MANAGEMENT', 30, 'USER DELETED FILE Salary Loan SSS.pdf FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 21:48:39'),
(78, 14, 'DELETE', 'FILE MANAGEMENT', 30, 'USER DELETED FILE Cetrificate of Employment(1).pdf FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 21:54:45'),
(79, 14, 'DELETE', 'FILE MANAGEMENT', 30, 'USER DELETED FILE Application Letter.docx FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 21:55:13'),
(80, 14, 'DELETE', 'FILE MANAGEMENT', 30, 'USER DELETED FILE Cetrificate of Employment.pdf FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 21:57:27'),
(81, 14, 'DELETE', 'FILE MANAGEMENT', 30, 'USER DELETED FILE DENR R6-REGIONAL CC 2025-final (2).pdf FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 21:57:33'),
(82, 14, 'UPLOAD', 'FILE MANAGEMENT', 30, 'USER UPLOADED A FILE FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 21:57:42'),
(83, 14, 'DELETE', 'FILE MANAGEMENT', 30, 'USER DELETED FILE Salary Loan SSS.pdf FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 21:58:33'),
(84, 14, 'DELETE', 'FILE MANAGEMENT', 30, 'USER DELETED FILE MASL-Resume.pdf FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 22:00:14'),
(85, 14, 'DELETE', 'FILE MANAGEMENT', 30, 'USER DELETED FILE Cetrificate of Employment.pdf FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 22:08:54'),
(86, 14, 'UPLOAD', 'FILE MANAGEMENT', 30, 'USER UPLOADED A FILE FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 22:10:57'),
(87, 14, 'DELETE', 'FILE MANAGEMENT', 30, 'USER DELETED FILE Cetrificate of Employment.pdf FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 22:11:00'),
(88, 14, 'UPLOAD', 'FILE MANAGEMENT', 30, 'USER UPLOADED A FILE FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 22:13:15'),
(89, 14, 'UPLOAD', 'FILE MANAGEMENT', 30, 'USER UPLOADED A FILE FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 22:13:38'),
(90, 14, 'DELETE', 'FILE MANAGEMENT', 30, 'USER DELETED FILE Application Letter(1).docx FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 22:15:41'),
(91, 14, 'DELETE', 'FILE MANAGEMENT', 30, 'USER DELETED FILE Application Letter.docx FOR RESIDENT RTAB20262970', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 22:15:47'),
(92, 14, 'CREATE', 'RESIDENT MANAGEMENT', 6, 'USER ADDED NEW RESIDENT(S) TO HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 22:49:45'),
(93, 14, 'DELETE', 'FILE MANAGEMENT', 32, 'USER DELETED FILE eDFPMS Updates.docx.pdf FOR RESIDENT RTAB20262659', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 22:51:22'),
(94, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 22:55:23'),
(95, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 22:55:31'),
(96, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 23:11:54'),
(97, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-21 23:43:29'),
(98, 1, 'REQUEST', 'USER MANAGEMENT', 1, 'USER ACCESSED FORGOT PASSWORD AND REQUESTED RESET EMAIL FOR ACCOUNT JUAN DELA CRUZ', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 00:01:25'),
(99, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 00:01:36'),
(100, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 00:02:45'),
(101, 1, 'REQUEST', 'USER MANAGEMENT', 1, 'USER ACCESSED FORGOT PASSWORD AND REQUESTED RESET EMAIL FOR ACCOUNT JUAN DELA CRUZ', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 00:03:08'),
(102, 1, 'REQUEST', 'USER MANAGEMENT', 1, 'USER ACCESSED FORGOT PASSWORD AND REQUESTED RESET EMAIL FOR ACCOUNT JUAN DELA CRUZ', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 00:06:02'),
(103, 1, 'REQUEST', 'USER MANAGEMENT', 1, 'USER ACCESSED FORGOT PASSWORD AND REQUESTED RESET EMAIL FOR ACCOUNT JUAN DELA CRUZ', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 00:06:51'),
(104, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 00:08:14'),
(105, 1, 'PASSWORD CHANGE', 'CHANGE PASSWORD', 1, 'USER CHANGED THEIR ACCOUNT PASSWORD', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 00:08:26'),
(106, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 00:08:28'),
(107, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 00:08:33'),
(108, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 00:09:04'),
(109, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 00:10:08'),
(110, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 00:10:14'),
(111, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 00:10:28'),
(112, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 01:51:47'),
(113, 14, 'EXPORT', 'RESIDENT MANAGEMENT', 0, 'USER EXPORTED RESIDENTS MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 01:53:00'),
(114, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 14:33:42'),
(115, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 14:34:07'),
(116, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'User exported household master list', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 14:39:46'),
(117, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 14:41:48'),
(118, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 15:55:09'),
(119, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-22 16:20:13'),
(120, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 13:55:32'),
(121, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 14:03:33'),
(122, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 14:04:08'),
(123, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 14:12:12'),
(124, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 15:14:16'),
(125, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 15:26:36'),
(126, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 15:29:34'),
(127, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 15:39:32'),
(128, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 15:39:45'),
(129, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 15:41:47'),
(130, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 15:42:52'),
(131, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 15:47:23'),
(132, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 16:26:50'),
(133, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 16:26:59'),
(134, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 16:30:12'),
(135, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 16:30:45'),
(136, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-24 16:32:51'),
(137, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 10:51:40'),
(138, 14, 'UPDATE', 'HOUSEHOLD MANAGEMENT', 6, 'USER UPDATED HOUSEHOLD INFORMATION FOR HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 12:32:13'),
(139, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 32, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262659 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 12:34:39'),
(140, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 32, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262659 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 12:34:44'),
(141, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 12:50:03'),
(142, 1, 'CREATE', 'USER MANAGEMENT', 16, 'USER CREATED A NEW USER ACCOUNT A A A', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 13:10:57'),
(143, 1, 'UPDATE', 'USER MANAGEMENT', 16, 'USER UPDATED PASSWORD FOR USER ACCOUNT A A A', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 13:11:06'),
(144, 1, 'UPDATE', 'USER MANAGEMENT', 16, 'USER UPDATED INFORMATION FOR USER ACCOUNT A A A', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 13:11:10'),
(145, 1, 'DELETE', 'USER MANAGEMENT', 16, 'USER DELETED USER ACCOUNT A A A', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 13:11:13'),
(146, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 13:19:12'),
(147, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 13:19:36'),
(148, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 13:19:49'),
(149, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 13:21:36'),
(150, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 13:21:42'),
(151, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 13:32:14'),
(152, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 13:32:18'),
(153, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 13:35:36'),
(154, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 13:35:39'),
(155, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 14:53:19'),
(156, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 14:53:20'),
(157, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 15:15:00'),
(158, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 15:15:04'),
(159, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 15:35:28'),
(160, 1, 'DELETE', 'USER MANAGEMENT', 5, 'USER DELETED USER ACCOUNT B B B', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-25 16:23:37'),
(161, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 13:37:49'),
(162, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 13:42:00'),
(163, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 13:43:36'),
(164, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 13:54:51'),
(165, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 13:56:04'),
(166, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 13:56:48'),
(167, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 13:59:41'),
(168, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 14:00:36'),
(169, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 14:01:03'),
(170, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 14:01:14'),
(171, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 14:33:02'),
(172, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 14:35:28'),
(173, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 14:35:59'),
(174, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 14:37:02'),
(175, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 14:38:24'),
(176, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 14:39:35'),
(177, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 14:40:48'),
(178, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 14:41:22'),
(179, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 14:42:56'),
(180, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 14:43:33'),
(181, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 14:44:00'),
(182, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 14:45:20'),
(183, 14, 'UPDATE', 'USER PROFILE', 14, 'USER UPDATED THEIR PERSONAL INFORMATION', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:03:57'),
(184, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 32, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262659 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:09:37'),
(185, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 32, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262659 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:14:12'),
(186, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 30, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262970 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:15:29'),
(187, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 26, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20263979 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:15:48'),
(188, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 26, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20263979 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:16:50'),
(189, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 30, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262970 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:17:14'),
(190, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 25, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20266981 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:17:38'),
(191, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 21, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262096 IN HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:20:14'),
(192, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 32, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262659 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:22:19'),
(193, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:23:19'),
(194, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:23:28'),
(195, 1, 'UPDATE', 'USER PROFILE', 1, 'USER UPDATED THEIR PERSONAL INFORMATION', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:24:39'),
(196, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:25:16'),
(197, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:25:42'),
(198, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 15:31:36'),
(199, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 16:09:28'),
(200, 14, 'UPLOAD', 'FILE MANAGEMENT', 32, 'USER UPLOADED A FILE FOR RESIDENT RTAB20262659', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 16:23:29'),
(201, 14, 'DELETE', 'FILE MANAGEMENT', 32, 'USER DELETED FILE SGC Deposit Slip Last 03162026.pdf FOR RESIDENT RTAB20262659', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 16:24:58'),
(202, 14, 'DELETE', 'FILE MANAGEMENT', 32, 'USER DELETED FILE Bizlink Bank Transfer.pdf FOR RESIDENT RTAB20262659', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 16:25:45'),
(203, 14, 'UPLOAD', 'FILE MANAGEMENT', 32, 'USER UPLOADED A FILE FOR RESIDENT RTAB20262659', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 16:26:03'),
(204, 14, 'DELETE', 'FILE MANAGEMENT', 32, 'USER DELETED FILE SGC Deposit Slip Last 03162026.pdf FOR RESIDENT RTAB20262659', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 16:26:16'),
(205, 14, 'UPLOAD', 'FILE MANAGEMENT', 32, 'USER UPLOADED A FILE FOR RESIDENT RTAB20262659', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 16:27:23'),
(206, 14, 'DELETE', 'FILE MANAGEMENT', 32, 'USER DELETED FILE Bizlink Bank Transfer.pdf FOR RESIDENT RTAB20262659', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 16:28:08'),
(207, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 16:29:23'),
(208, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 16:30:26'),
(209, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-26 16:30:35');
INSERT INTO `rpms_userlogs` (`userlogs_ID`, `user_ID`, `userlogs_Action`, `userlogs_Module`, `userlogs_RecordID`, `userlogs_Description`, `userlogs_IPAddress`, `userlogs_Agent`, `userlogs_Created`) VALUES
(210, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-27 11:46:40'),
(211, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-27 11:46:43'),
(212, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-27 14:11:11'),
(213, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-27 14:11:13'),
(214, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-27 14:15:41'),
(215, 1, 'UPDATE', 'SYSTEM SETTINGS', 1, 'USER UPDATED SYSTEM LOGO', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-27 14:46:01'),
(216, 1, 'UPDATE', 'SYSTEM SETTINGS', 1, 'USER UPDATED SYSTEM LOGO', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-27 15:04:16'),
(217, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-27 15:12:27'),
(218, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-27 15:16:05'),
(219, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 10:47:25'),
(220, 1, 'UPDATE', 'SYSTEM SETTINGS', 1, 'USER UPDATED SYSTEM LOGO', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 10:48:06'),
(221, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 10:48:45'),
(222, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 13:31:52'),
(223, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 13:32:30'),
(224, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 13:49:24'),
(225, 1, 'UPDATE', 'SYSTEM SETTINGS', 1, 'USER UPDATED SYSTEM LOGO', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 13:49:38'),
(226, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 13:49:42'),
(227, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 13:50:43'),
(228, 1, 'UPDATE', 'SYSTEM SETTINGS', 1, 'USER UPDATED SYSTEM LOGO', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 13:50:58'),
(229, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 13:51:01'),
(230, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 13:55:20'),
(231, 1, 'CREATE', 'BARANGAY MANAGEMENT', 49, 'USER CREATED A NEW BARANGAY EQWEWQ', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 13:59:43'),
(232, 1, 'DELETE', 'BARANGAY MANAGEMENT', 49, 'USER DELETED BARANGAY NAME EQWEWQ', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 13:59:50'),
(233, 1, 'BACKUP', 'DATABASE', 11, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 14:07:58'),
(234, 1, 'BACKUP', 'DATABASE', 12, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 14:08:40'),
(235, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 20:44:45'),
(236, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 20:44:58'),
(237, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 20:45:05'),
(238, 1, 'BACKUP', 'DATABASE', 13, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 22:22:47'),
(239, 1, 'BACKUP', 'DATABASE', 14, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 22:24:08'),
(240, 1, 'BACKUP', 'DATABASE', 15, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 22:24:30'),
(241, 1, 'BACKUP', 'DATABASE', 1, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 22:26:06'),
(242, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', '10.17.190.150', 'MOZILLA/5.0 (X11; LINUX X86_64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/143.0.0.0 SAFARI/537.36', '2026-03-28 22:42:44'),
(243, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', '10.17.190.150', 'MOZILLA/5.0 (X11; LINUX X86_64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/143.0.0.0 SAFARI/537.36', '2026-03-28 22:43:06'),
(244, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', '10.17.190.150', 'MOZILLA/5.0 (X11; LINUX X86_64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/143.0.0.0 SAFARI/537.36', '2026-03-28 22:43:42'),
(245, 14, 'UPDATE', 'USER PROFILE', 14, 'USER UPDATED THEIR PERSONAL INFORMATION', '10.17.190.150', 'MOZILLA/5.0 (X11; LINUX X86_64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/143.0.0.0 SAFARI/537.36', '2026-03-28 22:44:47'),
(246, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', '10.17.190.150', 'MOZILLA/5.0 (X11; LINUX X86_64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/143.0.0.0 SAFARI/537.36', '2026-03-28 22:45:03'),
(247, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', '10.17.190.150', 'MOZILLA/5.0 (X11; LINUX X86_64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/143.0.0.0 SAFARI/537.36', '2026-03-28 22:51:53'),
(248, 14, 'UPDATE', 'USER PROFILE', 14, 'USER UPDATED THEIR PERSONAL INFORMATION', '10.17.190.150', 'MOZILLA/5.0 (X11; LINUX X86_64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/143.0.0.0 SAFARI/537.36', '2026-03-28 22:53:08'),
(249, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', '10.17.190.150', 'MOZILLA/5.0 (X11; LINUX X86_64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/143.0.0.0 SAFARI/537.36', '2026-03-28 23:00:36'),
(250, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', '10.17.190.150', 'MOZILLA/5.0 (X11; LINUX X86_64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/143.0.0.0 SAFARI/537.36', '2026-03-28 23:10:57'),
(251, 1, 'UPDATE', 'SYSTEM SETTINGS', 1, 'USER UPDATED SYSTEM LOGO', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 23:11:32'),
(252, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', '10.17.190.150', 'MOZILLA/5.0 (X11; LINUX X86_64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/143.0.0.0 SAFARI/537.36', '2026-03-28 23:11:40'),
(253, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 23:12:02'),
(254, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-28 23:12:09'),
(255, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 14:03:29'),
(256, 1, 'BACKUP', 'DATABASE', 2, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 14:39:43'),
(257, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 15:59:11'),
(258, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 15:59:19'),
(259, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 16:23:33'),
(260, 1, 'BACKUP', 'DATABASE', 3, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 16:30:18'),
(261, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 16:40:43'),
(262, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 16:40:57'),
(263, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 19:48:17'),
(264, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 20:19:44'),
(265, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 20:35:37'),
(266, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 21, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262096 IN HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 20:52:08'),
(267, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 24, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20268869 IN HOUSEHOLD HHTAB2026000002', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 21:01:02'),
(268, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 21:16:47'),
(269, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 21:55:46'),
(270, 14, 'EXPORT', 'SOLO PARENTS', 0, 'USER EXPORTED SOLO PARENTS LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 22:04:54'),
(271, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 22:05:32'),
(272, 14, 'EXPORT', 'VOTERS', 0, 'USER EXPORTED VOTERS LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 22:10:38'),
(273, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 22:14:31'),
(274, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-29 22:14:57'),
(275, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-30 09:57:25'),
(276, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', '192.168.254.114', 'MOZILLA/5.0 (LINUX; ANDROID 10; K) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 MOBILE SAFARI/537.36', '2026-03-30 10:12:41'),
(277, 1, 'UPDATE', 'USER PROFILE', 1, 'USER UPDATED THEIR PERSONAL INFORMATION', '192.168.254.114', 'MOZILLA/5.0 (LINUX; ANDROID 10; K) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 MOBILE SAFARI/537.36', '2026-03-30 10:12:59'),
(278, 1, 'UPDATE', 'BARANGAY MANAGEMENT', 21, 'USER UPDATED DETAILS FOR BARANGAY UNION C', '192.168.254.114', 'MOZILLA/5.0 (LINUX; ANDROID 10; K) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 MOBILE SAFARI/537.36', '2026-03-30 10:13:16'),
(279, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', '192.168.254.114', 'MOZILLA/5.0 (LINUX; ANDROID 10; K) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 MOBILE SAFARI/537.36', '2026-03-30 10:13:34'),
(280, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', '192.168.254.114', 'MOZILLA/5.0 (LINUX; ANDROID 10; K) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 MOBILE SAFARI/537.36', '2026-03-30 10:42:21'),
(281, 1, 'CREATE', 'USER MANAGEMENT', 17, 'USER CREATED A NEW USER ACCOUNT A A A', '192.168.254.114', 'MOZILLA/5.0 (LINUX; ANDROID 10; K) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 MOBILE SAFARI/537.36', '2026-03-30 10:42:54'),
(282, 1, 'DELETE', 'USER MANAGEMENT', 17, 'USER DELETED USER ACCOUNT A A A', '192.168.254.114', 'MOZILLA/5.0 (LINUX; ANDROID 10; K) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 MOBILE SAFARI/537.36', '2026-03-30 10:44:50'),
(283, 1, 'CREATE', 'USER MANAGEMENT', 18, 'USER CREATED A NEW USER ACCOUNT B B B', '192.168.254.114', 'MOZILLA/5.0 (LINUX; ANDROID 10; K) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 MOBILE SAFARI/537.36', '2026-03-30 10:47:19'),
(284, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', '192.168.254.114', 'MOZILLA/5.0 (LINUX; ANDROID 10; K) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 MOBILE SAFARI/537.36', '2026-03-30 14:10:00'),
(285, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-30 15:23:18'),
(286, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-30 15:23:27'),
(287, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-31 14:28:10'),
(288, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-31 14:32:59'),
(289, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-31 22:02:37'),
(290, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-03-31 22:03:15'),
(291, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-01 18:02:03'),
(292, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-01 18:05:36'),
(293, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-01 18:06:37'),
(294, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-01 18:06:50'),
(295, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-01 18:10:38'),
(296, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-01 18:27:29'),
(297, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-01 18:27:36'),
(298, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-01 18:27:42'),
(299, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 21, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262096 IN HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-01 18:47:39'),
(300, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-01 19:38:46'),
(301, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-01 20:13:54'),
(302, 14, 'DELETE', 'RESIDENT MANAGEMENT', 32, 'USER DELETED RESIDENT RTAB20262659 FROM HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-01 20:19:41'),
(303, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-02 12:46:37'),
(304, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-02 12:47:15'),
(305, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-02 20:33:40'),
(306, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-02 20:33:50'),
(307, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-02 21:08:11'),
(308, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-02 21:08:41'),
(309, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-02 21:09:23'),
(310, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-02 21:09:51'),
(311, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-02 21:12:53'),
(312, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-02 21:17:44'),
(313, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-02 21:18:22'),
(314, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-03 12:42:22'),
(315, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-03 13:32:51'),
(316, 1, 'CREATE', 'USER MANAGEMENT', 26, 'USER CREATED A NEW USER ACCOUNT 000 00 00', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-03 13:41:02'),
(317, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-03 13:44:44'),
(318, 1, 'CREATE', 'USER MANAGEMENT', 27, 'USER CREATED A NEW USER ACCOUNT 1 1 1', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-03 13:54:17'),
(319, 1, 'CREATE', 'USER MANAGEMENT', 28, 'USER CREATED A NEW USER ACCOUNT DFSFFD 0980890 0980', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-03 13:59:25'),
(320, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-03 14:11:23'),
(321, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-03 15:41:50'),
(322, 1, 'CREATE', 'USER MANAGEMENT', 29, 'USER CREATED A NEW USER ACCOUNT 6756 7657 76765', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-03 15:49:38'),
(323, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-03 16:39:44'),
(324, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-03 17:06:03'),
(325, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-03 17:16:46'),
(326, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-03 17:18:02'),
(327, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-03 17:24:41'),
(328, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-03 19:20:40'),
(329, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-04 10:54:50'),
(330, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-04 11:10:42'),
(331, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-04 16:57:03'),
(332, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-04 16:57:17'),
(333, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-04 16:57:56'),
(334, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-04 17:07:19'),
(335, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-04 17:07:48'),
(336, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-05 13:08:29'),
(337, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A DISASTER-RELATED CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-05 16:05:38'),
(338, 14, 'CREATE', 'RESIDENT MANAGEMENT', 21, 'USER CREATE A EDUCATION/ SCHOOL STATUS CENSUS RECORD FOR RESIDENT RTAB20262096 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-05 16:07:06'),
(339, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-05 19:41:00'),
(340, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-06 15:10:41'),
(341, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-09 17:01:41'),
(342, 1, 'CREATE', 'USER MANAGEMENT', 30, 'USER CREATED A NEW USER ACCOUNT JASAS DSADSDSADS DSA', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-09 17:06:01'),
(343, 1, 'DELETE', 'USER MANAGEMENT', 30, 'USER DELETED USER ACCOUNT JASAS DSADSDSADS DSA', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-09 17:07:20'),
(344, 1, 'CREATE', 'USER MANAGEMENT', 31, 'USER CREATED A NEW USER ACCOUNT WEEWE EW WE', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-09 17:09:21'),
(345, 1, 'UPDATE', 'SYSTEM SETTINGS', 1, 'USER UPDATED SYSTEM LOGO', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-09 17:14:24'),
(346, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-09 17:16:50'),
(347, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/146.0.0.0 SAFARI/537.36', '2026-04-09 17:17:14'),
(348, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-17 16:44:58'),
(349, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 10:25:22'),
(350, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 10:25:38'),
(351, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 10:25:45'),
(352, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 10:34:43'),
(353, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 10:34:54'),
(354, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 10:41:24'),
(355, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 10:47:29'),
(356, 14, 'CREATE', 'RESIDENT MANAGEMENT', 1, 'USER ADDED NEW RESIDENT(S) TO HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:02:11'),
(357, 14, 'CREATE', 'RESIDENT MANAGEMENT', 1, 'USER ADDED NEW RESIDENT(S) TO HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:04:40'),
(358, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:06:16'),
(359, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:09:09'),
(360, 1, 'BACKUP', 'DATABASE', 4, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:09:59'),
(361, 1, 'BACKUP', 'DATABASE', 5, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:11:19'),
(362, 1, 'BACKUP', 'DATABASE', 6, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:11:26'),
(363, 1, 'BACKUP', 'DATABASE', 7, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:11:33'),
(364, 1, 'BACKUP', 'DATABASE', 8, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:11:40'),
(365, 1, 'BACKUP', 'DATABASE', 9, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:11:50'),
(366, 1, 'BACKUP', 'DATABASE', 10, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:11:53'),
(367, 1, 'BACKUP', 'DATABASE', 11, 'USER PERFORMED DATABASE BACKUP', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:11:56'),
(368, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:20:21'),
(369, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:20:45'),
(370, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:23:19'),
(371, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:23:26'),
(372, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:26:21'),
(373, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 11:27:14'),
(374, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 12:18:53'),
(375, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 12:19:03'),
(376, 1, 'CREATE', 'USER MANAGEMENT', 32, 'USER CREATED A NEW USER ACCOUNT HJKJH KJKJH KJHKJH', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 12:19:54'),
(377, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 12:20:07'),
(378, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 12:20:16'),
(379, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A  CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 12:45:16'),
(380, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A  CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 12:51:52'),
(381, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A  CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 12:53:22'),
(382, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A  CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 12:54:26'),
(383, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A  CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 12:58:28'),
(384, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A DISASTER-RELATED CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 13:13:51'),
(385, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 34, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262631 IN HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 13:30:58'),
(386, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A DISASTER-RELATED CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 13:31:10'),
(387, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A DISASTER-RELATED CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 13:49:41'),
(388, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A HEALTH EMERGENCY CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 13:55:21'),
(389, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A LIVELIHOOD/ ECONOMIC IMPACT CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:04:18'),
(390, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A SOCIAL ASSISTANCE/ BENEFICIARY CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:07:57'),
(391, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A SOCIAL ASSISTANCE/ BENEFICIARY CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:11:31'),
(392, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A EDUCATION/ SCHOOL STATUS CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:20:13'),
(393, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 34, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262631 IN HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:23:55'),
(394, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A  CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:24:13'),
(395, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:25:17'),
(396, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:31:04'),
(397, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:31:32'),
(398, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:31:55'),
(399, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:32:15'),
(400, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:32:33'),
(401, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:32:51'),
(402, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:33:49'),
(403, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:34:55'),
(404, 14, 'EXPORT', 'SENIOR CITIZENS', 0, 'USER EXPORTED SENIOR CITIZENS LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-18 14:35:12'),
(405, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-20 14:56:03'),
(406, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-20 15:07:31'),
(407, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-21 09:49:23'),
(408, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-21 09:49:30'),
(409, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-21 13:00:24'),
(410, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-22 09:26:10'),
(411, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-22 09:26:18'),
(412, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-22 14:20:16'),
(413, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-22 14:23:22'),
(414, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-04-22 14:23:35'),
(415, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-01 19:12:32'),
(416, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-01 19:15:05'),
(417, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-09 09:01:38');
INSERT INTO `rpms_userlogs` (`userlogs_ID`, `user_ID`, `userlogs_Action`, `userlogs_Module`, `userlogs_RecordID`, `userlogs_Description`, `userlogs_IPAddress`, `userlogs_Agent`, `userlogs_Created`) VALUES
(418, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-09 09:21:21'),
(419, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-09 09:23:00'),
(420, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-09 09:23:30'),
(421, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-09 09:27:47'),
(422, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-09 09:27:55'),
(423, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-09 11:15:24'),
(424, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-09 11:15:31'),
(425, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-09 11:17:32'),
(426, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-09 11:17:40'),
(427, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-09 11:26:43'),
(428, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-09 11:26:50'),
(429, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-09 20:18:00'),
(430, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-10 21:16:06'),
(431, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-10 21:16:58'),
(432, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-10 21:28:12'),
(433, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-10 21:36:03'),
(434, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-10 21:36:10'),
(435, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-10 21:48:10'),
(436, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-10 21:48:17'),
(437, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-10 22:01:03'),
(438, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-10 22:01:14'),
(439, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-10 22:04:23'),
(440, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-10 22:04:32'),
(441, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-11 10:50:20'),
(442, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-11 10:58:34'),
(443, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/147.0.0.0 SAFARI/537.36', '2026-05-11 10:58:41'),
(444, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-13 11:24:22'),
(445, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:15:53'),
(446, 1, 'UPDATE', 'SYSTEM SETTINGS', 1, 'USER UPDATED SYSTEM LOGO', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:16:25'),
(447, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:16:33'),
(448, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:17:27'),
(449, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:24:46'),
(450, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:24:54'),
(451, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 26, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20263979 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:28:19'),
(452, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 26, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20263979 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:28:28'),
(453, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 30, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262970 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:28:50'),
(454, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 25, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20266981 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:29:08'),
(455, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 21, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262096 IN HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:29:27'),
(456, 14, 'UPDATE', 'USER PROFILE', 14, 'USER UPDATED THEIR PERSONAL INFORMATION', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:30:56'),
(457, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:33:08'),
(458, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:35:35'),
(459, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:35:41'),
(460, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:36:33'),
(461, 14, 'EXPORT', 'SENIOR CITIZENS', 0, 'USER EXPORTED SENIOR CITIZENS LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-05-15 09:37:22'),
(462, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-09 11:21:30'),
(463, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-09 11:54:38'),
(464, 14, 'CREATE', 'HOUSEHOLD MANAGEMENT', 1, 'USER CREATE A  CENSUS RECORD FOR HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-09 11:59:12'),
(465, 14, 'CREATE', 'HOUSEHOLD MANAGEMENT', 1, 'USER CREATE A  CENSUS RECORD FOR HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-09 12:00:19'),
(466, 14, 'CREATE', 'HOUSEHOLD MANAGEMENT', 1, 'USER CREATE A DISASTER-RELATED CENSUS RECORD FOR HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-09 14:16:47'),
(467, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-09 14:21:38'),
(468, 14, 'CREATE', 'HOUSEHOLD MANAGEMENT', 1, 'USER CREATE A HEALTH EMERGENCY CENSUS RECORD FOR HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-09 14:56:35'),
(469, 14, 'CREATE', 'HOUSEHOLD MANAGEMENT', 1, 'USER CREATE A SOCIAL ASSISTANCE/ BENEFICIARY CENSUS RECORD FOR HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-09 15:32:58'),
(470, 14, 'CREATE', 'HOUSEHOLD MANAGEMENT', 1, 'USER CREATE A SOCIAL ASSISTANCE/ BENEFICIARY CENSUS RECORD FOR HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-09 15:34:14'),
(471, 14, 'CREATE', 'HOUSEHOLD MANAGEMENT', 1, 'USER CREATE A EDUCATION/ SCHOOL STATUS CENSUS RECORD FOR HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-09 15:57:41'),
(472, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-10 09:33:01'),
(473, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-10 14:37:33'),
(474, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 10:27:39'),
(475, 14, 'CREATE', 'RESIDENT MANAGEMENT', 33, 'USER CREATE A  CENSUS RECORD FOR RESIDENT RTAB20264862 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 11:41:48'),
(476, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A  CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 13:30:31'),
(477, 14, 'CREATE', 'RESIDENT MANAGEMENT', 33, 'USER CREATE A  CENSUS RECORD FOR RESIDENT RTAB20264862 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 13:30:41'),
(478, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 13:46:32'),
(479, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 13:51:08'),
(480, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 13:53:56'),
(481, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 13:57:10'),
(482, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 13:58:01'),
(483, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 13:59:04'),
(484, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 13:59:33'),
(485, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:00:20'),
(486, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:01:15'),
(487, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:01:33'),
(488, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:02:08'),
(489, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:03:07'),
(490, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:03:26'),
(491, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:04:19'),
(492, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:04:37'),
(493, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:05:30'),
(494, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:07:56'),
(495, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:19:14'),
(496, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:20:40'),
(497, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:22:22'),
(498, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:23:35'),
(499, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:24:10'),
(500, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:25:00'),
(501, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:43:36'),
(502, 14, 'EXPORT', 'HOUSEHOLD MANAGEMENT', 0, 'USER EXPORTED HOUSEHOLD MASTER LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:44:49'),
(503, 14, 'CREATE', 'RESIDENT MANAGEMENT', 25, 'USER CREATE A  CENSUS RECORD FOR RESIDENT RTAB20266981 FROM HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 14:56:10'),
(504, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A  CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 15:23:04'),
(505, 14, 'CREATE', 'RESIDENT MANAGEMENT', 30, 'USER CREATE A  CENSUS RECORD FOR RESIDENT RTAB20262970 FROM HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 15:23:21'),
(506, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A  CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 15:31:17'),
(507, 14, 'CREATE', 'RESIDENT MANAGEMENT', 33, 'USER CREATE A  CENSUS RECORD FOR RESIDENT RTAB20264862 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 15:31:21'),
(508, 14, 'CREATE', 'RESIDENT MANAGEMENT', 31, 'USER CREATE A  CENSUS RECORD FOR RESIDENT RTAB20266682 FROM HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/148.0.0.0 SAFARI/537.36', '2026-06-11 15:31:26'),
(509, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-14 20:58:48'),
(510, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-15 09:52:54'),
(511, 14, 'CREATE', 'RESIDENT MANAGEMENT', 34, 'USER CREATE A DISASTER-RELATED CENSUS RECORD FOR RESIDENT RTAB20262631 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-15 10:00:46'),
(512, 14, 'CREATE', 'RESIDENT MANAGEMENT', 33, 'USER CREATE A HEALTH EMERGENCY CENSUS RECORD FOR RESIDENT RTAB20264862 FROM HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-15 11:53:19'),
(513, 14, 'CREATE', 'RESIDENT MANAGEMENT', 26, 'USER CREATE A HEALTH EMERGENCY CENSUS RECORD FOR RESIDENT RTAB20263979 FROM HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-15 11:53:30'),
(514, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-15 18:59:41'),
(515, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-16 09:12:41'),
(516, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-16 09:14:08'),
(517, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-16 09:14:15'),
(518, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-16 11:24:50'),
(519, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-16 13:48:20'),
(520, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-17 10:40:11'),
(521, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-17 11:05:56'),
(522, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-21 10:46:47'),
(523, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-21 10:47:13'),
(524, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 10:05:26'),
(525, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 10:32:16'),
(526, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 10:48:54'),
(527, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 10:49:01'),
(528, 14, 'EXPORT', 'VOTERS', 0, 'USER EXPORTED VOTERS LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 10:59:49'),
(529, 14, 'EXPORT', 'VOTERS', 0, 'USER EXPORTED VOTERS LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 11:01:02'),
(530, 14, 'EXPORT', 'VOTERS', 0, 'USER EXPORTED VOTERS LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 11:20:35'),
(531, 14, 'EXPORT', 'VOTERS', 0, 'USER EXPORTED 4PS LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 11:21:47'),
(532, 14, 'EXPORT', 'VOTERS', 0, 'USER EXPORTED 4PS LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 11:21:54'),
(533, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 34, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262631 IN HOUSEHOLD HHTAB2026000001', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 11:35:55'),
(534, 14, 'UPDATE', 'RESIDENT MANAGEMENT', 30, 'USER UPDATED RESIDENT INFORMATION FOR RESIDENT RTAB20262970 IN HOUSEHOLD HHTAB2026000003', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 11:36:05'),
(535, 14, 'EXPORT', 'VOTERS', 0, 'USER EXPORTED INDIGENOUS PEOPLE LIST', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 11:39:38'),
(536, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:15:42'),
(537, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:15:48'),
(538, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:15:58'),
(539, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:16:00'),
(540, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:16:08'),
(541, 1, 'CREATE', 'USER MANAGEMENT', 33, 'USER CREATED A NEW USER ACCOUNT EWQE EWQ EQWE', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:26:01'),
(542, 1, 'DELETE', 'USER MANAGEMENT', 33, 'USER DELETED USER ACCOUNT EWQE EWQ EQWE', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:26:14'),
(543, 1, 'DELETE', 'USER MANAGEMENT', 32, 'USER DELETED USER ACCOUNT HJKJH KJKJH KJHKJH', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:26:21'),
(544, 1, 'DELETE', 'USER MANAGEMENT', 22, 'USER DELETED USER ACCOUNT 43434 432434 4324', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:26:25'),
(545, 1, 'DELETE', 'USER MANAGEMENT', 6, 'USER DELETED USER ACCOUNT FDFSD FSDF FSDF', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:26:31'),
(546, 1, 'DELETE', 'USER MANAGEMENT', 7, 'USER DELETED USER ACCOUNT C C C', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:26:35'),
(547, 1, 'DELETE', 'USER MANAGEMENT', 8, 'USER DELETED USER ACCOUNT D D D', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:26:42'),
(548, 1, 'DELETE', 'USER MANAGEMENT', 18, 'USER DELETED USER ACCOUNT B B B', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:26:49'),
(549, 1, 'DELETE', 'USER MANAGEMENT', 27, 'USER DELETED USER ACCOUNT 1 1 1', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:26:53'),
(550, 1, 'DELETE', 'USER MANAGEMENT', 28, 'USER DELETED USER ACCOUNT DFSFFD 0980890 0980', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:26:57'),
(551, 1, 'DELETE', 'USER MANAGEMENT', 29, 'USER DELETED USER ACCOUNT 6756 7657 76765', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:27:22'),
(552, 1, 'DELETE', 'USER MANAGEMENT', 31, 'USER DELETED USER ACCOUNT WEEWE EW WE', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:27:26'),
(553, 1, 'DELETE', 'USER MANAGEMENT', 26, 'USER DELETED USER ACCOUNT 000 00 00', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:28:50'),
(554, 1, 'DELETE', 'USER MANAGEMENT', 25, 'USER DELETED USER ACCOUNT DSD EWQE EWQE', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:28:54'),
(555, 1, 'DELETE', 'USER MANAGEMENT', 24, 'USER DELETED USER ACCOUNT DSD EWQE EWQE', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:28:59'),
(556, 1, 'DELETE', 'USER MANAGEMENT', 23, 'USER DELETED USER ACCOUNT 33 3 3', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:29:03'),
(557, 1, 'DELETE', 'USER MANAGEMENT', 21, 'USER DELETED USER ACCOUNT 43434 432434 4324', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:29:07'),
(558, 1, 'DELETE', 'USER MANAGEMENT', 20, 'USER DELETED USER ACCOUNT 2 2 2', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:29:11'),
(559, 1, 'DELETE', 'USER MANAGEMENT', 19, 'USER DELETED USER ACCOUNT DWQE EWE EWQE', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 12:29:15'),
(560, 1, 'CREATE', 'USER MANAGEMENT', 34, 'USER CREATED A NEW USER ACCOUNT HA HE HI', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 13:11:48'),
(561, 1, 'UPDATE', 'USER MANAGEMENT', 34, 'USER UPDATED PASSWORD FOR USER ACCOUNT HA HE HI', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 13:44:28'),
(562, 14, 'LOGOUT', 'AUTHENTICATION', 14, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 13:44:47'),
(563, 34, 'LOGIN', 'AUTHENTICATION', 34, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 13:44:58'),
(564, 34, 'LOGOUT', 'AUTHENTICATION', 34, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 13:45:26'),
(565, 34, 'LOGIN', 'AUTHENTICATION', 34, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 14:37:17'),
(566, 34, 'LOGOUT', 'AUTHENTICATION', 34, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-22 14:37:19'),
(567, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-24 10:17:19'),
(568, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-24 15:22:42'),
(569, 1, 'LOGIN', 'AUTHENTICATION', 1, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-26 09:54:30'),
(570, 1, 'LOGOUT', 'AUTHENTICATION', 1, 'USER LOGGED OUT OF THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-26 09:54:37'),
(571, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-26 09:54:44'),
(572, 14, 'LOGIN', 'AUTHENTICATION', 14, 'USER LOGGED INTO THE SYSTEM', 'LOCALHOST', 'MOZILLA/5.0 (WINDOWS NT 10.0; WIN64; X64) APPLEWEBKIT/537.36 (KHTML, LIKE GECKO) CHROME/149.0.0.0 SAFARI/537.36', '2026-06-26 13:28:17');

-- --------------------------------------------------------

--
-- Table structure for table `rpms_users`
--

CREATE TABLE `rpms_users` (
  `user_ID` int(11) NOT NULL,
  `user_Registered` datetime NOT NULL,
  `user_ProfilePicture` text NOT NULL,
  `user_FirstName` varchar(100) NOT NULL,
  `user_MiddleName` varchar(100) NOT NULL,
  `user_LastName` varchar(100) NOT NULL,
  `user_EmailAddress` varchar(100) NOT NULL,
  `user_ContactNumber` varchar(11) NOT NULL,
  `user_Username` varchar(100) NOT NULL,
  `user_Password` varchar(100) NOT NULL,
  `user_Appointed` varchar(100) NOT NULL,
  `user_Role` int(11) NOT NULL,
  `user_Status` int(11) NOT NULL,
  `user_LastModified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rpms_users`
--

INSERT INTO `rpms_users` (`user_ID`, `user_Registered`, `user_ProfilePicture`, `user_FirstName`, `user_MiddleName`, `user_LastName`, `user_EmailAddress`, `user_ContactNumber`, `user_Username`, `user_Password`, `user_Appointed`, `user_Role`, `user_Status`, `user_LastModified`) VALUES
(1, '2026-02-26 15:18:05', 'Profile260326152438.webp', 'JUAN', 'DELA', 'CRUZ', 'layslomugdang@gmail.com', '09984849243', 'Juan123', '$2y$10$bCynYwKmAVPn6CLLBfOCT.S6YJp8yltLANnui74vpyAVy5Fs16a2y', 'MAIN OFFICE', 1, 1, '2026-03-30 10:12:58'),
(14, '2026-02-26 15:58:07', 'Profile260515093056.webp', 'MARIA', 'JUAN', 'SY', 'ta@gmail.com', '09342423423', 'Taboc123', '$2y$10$WYNS2cVwTmK/KmOtO5Edqeb3ojh.Cp0.XBS37a263C4f/KfVsNwXW', 'TABOC', 2, 1, '2026-05-15 09:30:56'),
(34, '2026-06-22 13:11:41', 'Default.png', 'HA', 'HE', 'HI', 'm.alizalomugdangtrikee@gmail.com', '09543534545', 'Sample123', '$2y$10$fDfFoL0R6mwYL5KPixyXceadt/VfTdYG.NccuMaTMfV5ezSfcqz4S', 'MAIN OFFICE', 1, 1, '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rpms_barangays`
--
ALTER TABLE `rpms_barangays`
  ADD PRIMARY KEY (`barangay_ID`);

--
-- Indexes for table `rpms_censusconfig`
--
ALTER TABLE `rpms_censusconfig`
  ADD PRIMARY KEY (`censusconfig_ID`);

--
-- Indexes for table `rpms_databases`
--
ALTER TABLE `rpms_databases`
  ADD PRIMARY KEY (`database_ID`);

--
-- Indexes for table `rpms_householdcensus`
--
ALTER TABLE `rpms_householdcensus`
  ADD PRIMARY KEY (`hc_ID`);

--
-- Indexes for table `rpms_householddisasterrelated`
--
ALTER TABLE `rpms_householddisasterrelated`
  ADD PRIMARY KEY (`hdr_ID`);

--
-- Indexes for table `rpms_householdeducationschoolstatus`
--
ALTER TABLE `rpms_householdeducationschoolstatus`
  ADD PRIMARY KEY (`hess_ID`);

--
-- Indexes for table `rpms_householdhealthemergency`
--
ALTER TABLE `rpms_householdhealthemergency`
  ADD PRIMARY KEY (`hhe_ID`);

--
-- Indexes for table `rpms_householdlivelihoodeconomicimpact`
--
ALTER TABLE `rpms_householdlivelihoodeconomicimpact`
  ADD PRIMARY KEY (`hlhe_ID`);

--
-- Indexes for table `rpms_households`
--
ALTER TABLE `rpms_households`
  ADD PRIMARY KEY (`household_ID`);

--
-- Indexes for table `rpms_householdsocialassistancebeneficiary`
--
ALTER TABLE `rpms_householdsocialassistancebeneficiary`
  ADD PRIMARY KEY (`hsab_ID`);

--
-- Indexes for table `rpms_rattachments`
--
ALTER TABLE `rpms_rattachments`
  ADD PRIMARY KEY (`rattachment_ID`);

--
-- Indexes for table `rpms_residentcensus`
--
ALTER TABLE `rpms_residentcensus`
  ADD PRIMARY KEY (`rc_ID`);

--
-- Indexes for table `rpms_residentdisasterrelated`
--
ALTER TABLE `rpms_residentdisasterrelated`
  ADD PRIMARY KEY (`rdr_ID`);

--
-- Indexes for table `rpms_residenteducationschoolstatus`
--
ALTER TABLE `rpms_residenteducationschoolstatus`
  ADD PRIMARY KEY (`ress_ID`);

--
-- Indexes for table `rpms_residenthealthemergency`
--
ALTER TABLE `rpms_residenthealthemergency`
  ADD PRIMARY KEY (`rhe_ID`);

--
-- Indexes for table `rpms_residentlivelihoodeconomicimpact`
--
ALTER TABLE `rpms_residentlivelihoodeconomicimpact`
  ADD PRIMARY KEY (`rlhei_ID`);

--
-- Indexes for table `rpms_residents`
--
ALTER TABLE `rpms_residents`
  ADD PRIMARY KEY (`resident_ID`);

--
-- Indexes for table `rpms_residentsocialassistancebeneficiary`
--
ALTER TABLE `rpms_residentsocialassistancebeneficiary`
  ADD PRIMARY KEY (`rsab_ID`);

--
-- Indexes for table `rpms_settings`
--
ALTER TABLE `rpms_settings`
  ADD PRIMARY KEY (`setting_ID`);

--
-- Indexes for table `rpms_userlogs`
--
ALTER TABLE `rpms_userlogs`
  ADD PRIMARY KEY (`userlogs_ID`);

--
-- Indexes for table `rpms_users`
--
ALTER TABLE `rpms_users`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rpms_barangays`
--
ALTER TABLE `rpms_barangays`
  MODIFY `barangay_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `rpms_censusconfig`
--
ALTER TABLE `rpms_censusconfig`
  MODIFY `censusconfig_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rpms_databases`
--
ALTER TABLE `rpms_databases`
  MODIFY `database_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rpms_householdcensus`
--
ALTER TABLE `rpms_householdcensus`
  MODIFY `hc_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rpms_householddisasterrelated`
--
ALTER TABLE `rpms_householddisasterrelated`
  MODIFY `hdr_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rpms_householdeducationschoolstatus`
--
ALTER TABLE `rpms_householdeducationschoolstatus`
  MODIFY `hess_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rpms_householdhealthemergency`
--
ALTER TABLE `rpms_householdhealthemergency`
  MODIFY `hhe_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rpms_householdlivelihoodeconomicimpact`
--
ALTER TABLE `rpms_householdlivelihoodeconomicimpact`
  MODIFY `hlhe_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rpms_households`
--
ALTER TABLE `rpms_households`
  MODIFY `household_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rpms_householdsocialassistancebeneficiary`
--
ALTER TABLE `rpms_householdsocialassistancebeneficiary`
  MODIFY `hsab_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rpms_rattachments`
--
ALTER TABLE `rpms_rattachments`
  MODIFY `rattachment_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `rpms_residentcensus`
--
ALTER TABLE `rpms_residentcensus`
  MODIFY `rc_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `rpms_residentdisasterrelated`
--
ALTER TABLE `rpms_residentdisasterrelated`
  MODIFY `rdr_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rpms_residenteducationschoolstatus`
--
ALTER TABLE `rpms_residenteducationschoolstatus`
  MODIFY `ress_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rpms_residenthealthemergency`
--
ALTER TABLE `rpms_residenthealthemergency`
  MODIFY `rhe_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rpms_residentlivelihoodeconomicimpact`
--
ALTER TABLE `rpms_residentlivelihoodeconomicimpact`
  MODIFY `rlhei_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rpms_residents`
--
ALTER TABLE `rpms_residents`
  MODIFY `resident_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `rpms_residentsocialassistancebeneficiary`
--
ALTER TABLE `rpms_residentsocialassistancebeneficiary`
  MODIFY `rsab_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rpms_settings`
--
ALTER TABLE `rpms_settings`
  MODIFY `setting_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rpms_userlogs`
--
ALTER TABLE `rpms_userlogs`
  MODIFY `userlogs_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=573;

--
-- AUTO_INCREMENT for table `rpms_users`
--
ALTER TABLE `rpms_users`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
