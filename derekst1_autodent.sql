-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 06, 2016 at 12:20 AM
-- Server version: 5.5.42-37.1-log
-- PHP Version: 5.4.31

SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: "derekst1_autodent"
--

-- --------------------------------------------------------

--
-- Table structure for table "announcements"
--

CREATE TABLE "announcements" (
  "id" int NOT NULL,
  "user_id" int NOT NULL,
  "content" text NOT NULL,
  "added" datetime NOT NULL
);

--
-- Dumping data for table "announcements"
--

SET IDENTITY_INSERT "announcements" ON ;
INSERT INTO "announcements" ("id", "user_id", "content", "added") VALUES
(13, 32, 'Announc1', '2016-08-05 23:57:05'),
(14, 32, 'Good', '2016-08-06 00:01:43'),
(15, 32, 'Nice!', '2016-08-06 00:02:19');

SET IDENTITY_INSERT "announcements" OFF;

-- --------------------------------------------------------

--
-- Table structure for table "appointments"
--

CREATE TABLE "appointments" (
  "id" int NOT NULL,
  "customer_id" int NOT NULL,
  "datetime" datetime DEFAULT NULL,
  "adjuster_datetime" datetime DEFAULT NULL,
  "pick_up_datetime" datetime DEFAULT NULL,
  "vin" varchar(100) NOT NULL,
  "mileage" varchar(100) NOT NULL,
  "year" varchar(100) NOT NULL,
  "color" varchar(100) NOT NULL,
  "make" varchar(100) NOT NULL,
  "fuel" varchar(100) NOT NULL,
  "model" varchar(100) NOT NULL
);

--
-- Dumping data for table "appointments"
--

SET IDENTITY_INSERT "appointments" ON ;
INSERT INTO "appointments" ("id", "customer_id", "datetime", "adjuster_datetime", "pick_up_datetime", "vin", "mileage", "year", "color", "make", "fuel", "model") VALUES
(20, 24, '2016-08-06 00:00:00', '2016-08-15 00:00:00', '2016-08-17 00:00:00', 'vin', 'mileage', 'year', 'blue', 'make', 'e', 'm-39484932'),
(21, 25, '2016-08-04 00:00:00', '2016-08-09 00:00:00', '2016-08-17 00:00:00', 'vin', 'mileage', 'year', 'gray', 'make', 'e', 'm5-34945893');

SET IDENTITY_INSERT "appointments" OFF;

-- --------------------------------------------------------

--
-- Table structure for table "appointments_files"
--

CREATE TABLE "appointments_files" (
  "id" int NOT NULL,
  "customer_id" int NOT NULL,
  "filename" varchar(255) NOT NULL,
  "orig_name" varchar(255) NOT NULL,
  "rename" varchar(255) DEFAULT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "appointments_forms"
--

CREATE TABLE "appointments_forms" (
  "id" int NOT NULL,
  "customer_id" int NOT NULL,
  "form_name" varchar(100) NOT NULL,
  "form_data_json" text
);

--
-- Dumping data for table "appointments_forms"
--

SET IDENTITY_INSERT "appointments_forms" ON ;
INSERT INTO "appointments_forms" ("id", "customer_id", "form_name", "form_data_json") VALUES
(18, 23, 'rental_agreement', '{"rental_agreement":1}'),
(19, 24, 'rental_agreement', '{"rental_agreement":1}'),
(20, 25, 'rental_agreement', '{"rental_agreement":1}'),
(21, 23, 'repair_authorization', '{"parts_replace":["RF Belt","L Drip","Front Applique: L/R"],"r_&_i_information":["R&I Information","Decklid Assy"],"sig-ra":"{\\"lines\\":[[[94,24],[94,24],[96,26],[99,35],[100,37],[101,40],[102,42],[102,45],[102,48],[102,49],[102,51],[102,53],[102,54],[102,55],[102,56],[102,57],[102,58],[102,59],[102,60],[102,62],[101,62],[101,63],[100,63],[99,63],[102,59],[108,56],[121,50],[128,46],[139,40],[149,36],[160,32],[166,30],[173,26],[175,25],[176,24],[177,24]]]}"}'),
(22, 23, 'authorization_and_direction_to_pay', '{"location":"NM","sig-adp":"{\\"lines\\":[[[89.69,31],[89.69,31],[90.69,31],[92.69,33],[92.69,37],[92.69,39],[92.69,43],[93.69,46],[93.69,49],[93.69,52],[93.69,54],[93.69,55],[93.69,56],[93.69,57],[93.69,58],[93.69,61],[93.69,62],[93.69,63],[93.69,64],[94.69,65],[96.69,64],[97.69,64],[100.69,61],[102.69,58],[106.69,55],[109.69,51],[113.69,48],[116.69,45],[119.69,43],[122.69,39],[126.69,36],[128.69,34],[130.69,33],[133.69,31],[134.69,30],[135.69,29],[136.69,28],[136.69,27],[138.69,27],[140.69,26],[143.69,24],[144.69,24],[145.69,24],[146.69,23]]]}"}'),
(23, 23, 'prior_damage_report', '{"sig-pdr-customer":"{\\"lines\\":[[[92.84,30],[92.84,30],[92.84,31],[90.84,34],[90.84,37],[88.84,42],[86.84,47],[82.84,54],[79.84,60],[76.84,65],[74.84,68],[74.84,69],[73.84,70],[77.84,69],[87.84,66],[100.84,58],[113.84,50],[124.84,44],[137.84,37],[153.84,28],[163.84,22],[170.84,19],[173.84,15],[175.84,15],[176.84,14],[177.84,14],[177.84,13]]]}","sig-pdr-adc":"{\\"lines\\":[[[100.84,16],[100.84,16],[98.84,17],[98.84,19],[97.84,23],[97.84,26],[96.84,29],[93.84,36],[91.84,37],[89.84,41],[88.84,43],[86.84,46],[85.84,47],[84.84,49],[83.84,51],[84.84,51],[91.84,51],[100.84,49],[111.84,45],[122.84,43],[133.84,40],[145.84,36],[156.84,33],[166.84,29],[176.84,25],[183.84,23],[185.84,23],[186.84,23]]]}","annotations":"[]"}');

SET IDENTITY_INSERT "appointments_forms" OFF;

-- --------------------------------------------------------

--
-- Table structure for table "customers"
--

CREATE TABLE "customers" (
  "id" int NOT NULL,
  "name" varchar(50) NOT NULL,
  "address" varchar(255) NOT NULL,
  "insurance_company" varchar(100) NOT NULL,
  "po" varchar(100) NOT NULL,
  "estimator" varchar(100) NOT NULL,
  "claim" varchar(100) NOT NULL,
  "repair_order" varchar(100) NOT NULL,
  "phone" varchar(100) NOT NULL,
  "status" tinyint NOT NULL DEFAULT '0',
  "status_datetime" datetime DEFAULT NULL,
  "priority" tinyint NOT NULL DEFAULT '0',
  "creator_id" int NOT NULL,
  "added" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table "customers"
--

SET IDENTITY_INSERT "customers" ON ;
INSERT INTO "customers" ("id", "name", "address", "insurance_company", "po", "estimator", "claim", "repair_order", "phone", "status", "status_datetime", "priority", "creator_id", "added") VALUES
(23, 'customer', 'address', 'insurance', 'po', 'estimator', 'claim', 'repair', '194382749284', 1, '2016-09-07 00:00:00', 1, 34, '2016-08-05 20:26:43'),
(24, 'superuser''s cst', 'address', 'insurance', 'po', 'extimator', 'claim', 'repair', '3404938104', 0, NULL, 0, 32, '2016-08-06 03:55:04'),
(25, 'ashley''s cst2', 'address', 'insurance', 'po', 'estimator', 'claim', 'repair', '599583852423', 2, '2016-08-16 00:00:00', 1, 34, '2016-08-06 03:58:04');

SET IDENTITY_INSERT "customers" OFF;

-- --------------------------------------------------------

--
-- Table structure for table "customers_activity"
--

CREATE TABLE "customers_activity" (
  "id" int NOT NULL,
  "customer_id" int NOT NULL,
  "type" varchar(100) NOT NULL,
  "note" text,
  "user_id" int NOT NULL,
  "added" timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

--
-- Dumping data for table "customers_activity"
--

SET IDENTITY_INSERT "customers_activity" ON ;
INSERT INTO "customers_activity" ("id", "customer_id", "type", "note", "user_id", "added") VALUES
(178, 23, 'created', '', 34, '2016-08-05 20:26:43'),
(179, 23, 'datetime_24hours', '24 hours before Date/Time of appointment', 34, '2016-08-05 20:27:45'),
(180, 23, 'updated', '', 34, '2016-08-05 20:27:45'),
(181, 23, 'status_changed', '', 34, '2016-08-05 21:03:31'),
(182, 23, 'date_changed', '', 34, '2016-08-05 21:03:31'),
(183, 24, 'created', '', 32, '2016-08-06 03:55:04'),
(184, 24, 'datetime_24hours', '24 hours before Date/Time of appointment', 32, '2016-08-06 03:55:50'),
(185, 24, 'updated', '', 32, '2016-08-06 03:55:50'),
(186, 25, 'created', '', 34, '2016-08-06 03:58:04'),
(187, 25, 'datetime_24hours', '24 hours before Date/Time of appointment', 34, '2016-08-06 03:58:40'),
(188, 25, 'updated', '', 34, '2016-08-06 03:58:40'),
(189, 23, 'updated', '', 34, '2016-08-06 05:41:06'),
(190, 23, 'updated', '', 34, '2016-08-06 05:43:04'),
(191, 23, 'updated', '', 34, '2016-08-06 05:44:29'),
(192, 23, 'updated', '', 34, '2016-08-06 05:45:38'),
(193, 23, 'updated', '', 34, '2016-08-06 05:45:49'),
(194, 25, 'status_changed', '', 34, '2016-08-06 06:09:06'),
(195, 25, 'assigned', '33', 34, '2016-08-06 06:09:06'),
(196, 25, 'date_changed', '', 34, '2016-08-06 06:09:06'),
(197, 25, 'updated', '', 33, '2016-08-06 06:11:58'),
(198, 25, 'updated', '', 33, '2016-08-06 06:11:58'),
(199, 25, 'status_changed', '', 33, '2016-08-06 06:14:42'),
(200, 25, 'date_changed', '', 33, '2016-08-06 06:14:42');

SET IDENTITY_INSERT "customers_activity" OFF;

-- --------------------------------------------------------

--
-- Table structure for table "customers_activity_view"
--

CREATE TABLE "customers_activity_view" (
  "id" int NOT NULL,
  "user_id" int NOT NULL,
  "activity_id" int NOT NULL
);

--
-- Dumping data for table "customers_activity_view"
--

SET IDENTITY_INSERT "customers_activity_view" ON ;
INSERT INTO "customers_activity_view" ("id", "user_id", "activity_id") VALUES
(60, 34, 179),
(61, 32, 184),
(62, 34, 187),
(63, 32, 193),
(64, 32, 192),
(65, 32, 191),
(66, 32, 190),
(67, 32, 189),
(68, 32, 181),
(69, 32, 182),
(70, 32, 179),
(71, 32, 180),
(72, 32, 178),
(73, 32, 187),
(74, 32, 188),
(75, 32, 186),
(76, 33, 194),
(77, 33, 195);

SET IDENTITY_INSERT "customers_activity_view" OFF;

-- --------------------------------------------------------

--
-- Table structure for table "customers_users"
--

CREATE TABLE "customers_users" (
  "id" int NOT NULL,
  "customer_id" int NOT NULL,
  "user_id" int NOT NULL
);

-- --------------------------------------------------------

--
-- Table structure for table "statuses"
--

CREATE TABLE "statuses" (
  "id" int NOT NULL,
  "name" varchar(100) NOT NULL
);

--
-- Dumping data for table "statuses"
--

SET IDENTITY_INSERT "statuses" ON ;
INSERT INTO "statuses" ("id", "name") VALUES
(1, 'inProgress'),
(2, 'finished');

SET IDENTITY_INSERT "statuses" OFF;

-- --------------------------------------------------------

--
-- Table structure for table "users"
--

CREATE TABLE "users" (
  "id" int NOT NULL,
  "ip_address" varchar(15) NOT NULL,
  "username" varchar(100) DEFAULT NULL,
  "image" varchar(100) DEFAULT NULL,
  "password" varchar(255) NOT NULL,
  "salt" varchar(255) DEFAULT NULL,
  "email" varchar(100) NOT NULL,
  "activation_code" varchar(40) DEFAULT NULL,
  "forgotten_password_code" varchar(40) DEFAULT NULL,
  "forgotten_password_time" int DEFAULT NULL,
  "remember_code" varchar(40) DEFAULT NULL,
  "created_on" int NOT NULL,
  "last_login" int DEFAULT NULL,
  "active" tinyint DEFAULT NULL,
  "first_name" varchar(50) DEFAULT NULL,
  "last_name" varchar(50) DEFAULT NULL,
  "company" varchar(100) DEFAULT NULL,
  "phone" varchar(20) DEFAULT NULL
);

--
-- Dumping data for table "users"
--

SET IDENTITY_INSERT "users" ON ;
INSERT INTO "users" ("id", "ip_address", "username", "image", "password", "salt", "email", "activation_code", "forgotten_password_code", "forgotten_password_time", "remember_code", "created_on", "last_login", "active", "first_name", "last_name", "company", "phone") VALUES
(14, '127.0.0.1', 'derek.stock', 'ddd.png', '$2y$08$2yKq2NB5FJrl.KKjfnB8/.TtQLeZD2hXwaUhyTIDeBPP6vcW0PbNi', NULL, 'derek@ninthcoast.com', NULL, NULL, NULL, NULL, 1457579612, 1470463260, 1, 'Derek', 'Stock', NULL, NULL),
(32, '167.160.116.75', 'SuperUser', NULL, '$2y$08$2yKq2NB5FJrl.KKjfnB8/.TtQLeZD2hXwaUhyTIDeBPP6vcW0PbNi', NULL, 'super@gmail.com', 'd1c6226e0e3064aa00a7af26e29f589802b55c2b', NULL, NULL, NULL, 1470342422, 1470463782, 1, 'Super', 'User', NULL, NULL),
(33, '103.254.155.25', 'technicians.k', NULL, '$2y$08$5FhheBGKOnkcIxushpAS7.JOzhkdqYFHkFMJTKPPw7M1RsFR7spZy', NULL, 'torey.adler@noaa.gov', '6109a047b165e86e83b65b290c1716a3c0d9b155', NULL, NULL, NULL, 1470374673, 1470414913, 1, 'Technicians', 'K', NULL, NULL),
(34, '68.231.207.244', 'ashley.mcmillion', NULL, '$2y$08$5FhheBGKOnkcIxushpAS7.JOzhkdqYFHkFMJTKPPw7M1RsFR7spZy', NULL, 'ashley@ninthcoast.com', NULL, NULL, NULL, NULL, 1470415639, 1470464136, 1, 'Ashley', 'McMillion', NULL, NULL),
(37, '188.42.255.195', 'technician.d', NULL, '$2y$08$q9kQiXsTj8hm.TjjyRbe9.24swEcH3xI1jz88u9WZ2nXpV.zcE.3C', NULL, 'technician2@derek.com', NULL, NULL, NULL, NULL, 1470428741, NULL, 1, 'Technician', 'D', NULL, NULL),
(38, '103.254.155.25', 'technicians.technician', NULL, '$2y$08$9CFimle5StxWw8.8WLInA./JKgGS9iU2oRDVbWOuk7Q.ctKLtum.a', NULL, 'technicians@derek.com', NULL, NULL, NULL, NULL, 1470463101, NULL, 1, 'Technicians', 'Technician', NULL, NULL);

SET IDENTITY_INSERT "users" OFF;

-- --------------------------------------------------------

--
-- Table structure for table "users_groups"
--

CREATE TABLE "users_groups" (
  "id" int NOT NULL,
  "user_id" int NOT NULL,
  "group_id" mediumint(8) NOT NULL
);

--
-- Dumping data for table "users_groups"
--

SET IDENTITY_INSERT "users_groups" ON ;
INSERT INTO "users_groups" ("id", "user_id", "group_id") VALUES
(55, 14, 1),
(102, 32, 2),
(104, 33, 5),
(110, 34, 4),
(112, 37, 5),
(114, 38, 5);

SET IDENTITY_INSERT "users_groups" OFF;

-- --------------------------------------------------------

--
-- Table structure for table "users_login_attempts"
--

CREATE TABLE "users_login_attempts" (
  "id" int NOT NULL,
  "ip_address" varchar(15) NOT NULL,
  "login" varchar(100) NOT NULL,
  "time" int DEFAULT NULL
);

--
-- Dumping data for table "users_login_attempts"
--

SET IDENTITY_INSERT "users_login_attempts" ON ;
INSERT INTO "users_login_attempts" ("id", "ip_address", "login", "time") VALUES
(16, '188.42.255.195', 'star@gmail.com', 1470455622);

SET IDENTITY_INSERT "users_login_attempts" OFF;

-- --------------------------------------------------------

--
-- Table structure for table "users_relations"
--

CREATE TABLE "users_relations" (
  "id" int NOT NULL,
  "user_id" int NOT NULL,
  "creator_id" int NOT NULL
);

--
-- Dumping data for table "users_relations"
--

SET IDENTITY_INSERT "users_relations" ON ;
INSERT INTO "users_relations" ("id", "user_id", "creator_id") VALUES
(16, 32, 14),
(17, 33, 32),
(18, 34, 32),
(21, 37, 32),
(22, 38, 32);

SET IDENTITY_INSERT "users_relations" OFF;

-- --------------------------------------------------------

--
-- Table structure for table "users_role_groups"
--

CREATE TABLE "users_role_groups" (
  "id" mediumint(8) NOT NULL,
  "name" varchar(20) NOT NULL,
  "description" varchar(100) NOT NULL
);

--
-- Dumping data for table "users_role_groups"
--

SET IDENTITY_INSERT "users_role_groups" ON ;
INSERT INTO "users_role_groups" ("id", "name", "description") VALUES
(1, 'superadmin', 'Super Admin'),
(2, 'dealer', 'Dealer'),
(3, 'manager', 'Manager'),
(4, 'sales', 'Sales'),
(5, 'tech', 'Technician');

SET IDENTITY_INSERT "users_role_groups" OFF;

--
-- Indexes for dumped tables
--

--
-- Indexes for table "announcements"
--
ALTER TABLE "announcements"
  ADD PRIMARY KEY ("id"), ADD KEY "user_id" ("user_id");

--
-- Indexes for table "appointments"
--
ALTER TABLE "appointments"
  ADD PRIMARY KEY ("id"), ADD KEY "customer_id" ("customer_id");

--
-- Indexes for table "appointments_files"
--
ALTER TABLE "appointments_files"
  ADD PRIMARY KEY ("id"), ADD KEY "customer_id" ("customer_id");

--
-- Indexes for table "appointments_forms"
--
ALTER TABLE "appointments_forms"
  ADD PRIMARY KEY ("id"), ADD KEY "appt_id" ("customer_id"), ADD KEY "form_name" ("form_name");

--
-- Indexes for table "customers"
--
ALTER TABLE "customers"
  ADD PRIMARY KEY ("id"), ADD KEY "name" ("name");

--
-- Indexes for table "customers_activity"
--
ALTER TABLE "customers_activity"
  ADD PRIMARY KEY ("id"), ADD KEY "customer_id" ("customer_id");

--
-- Indexes for table "customers_activity_view"
--
ALTER TABLE "customers_activity_view"
  ADD PRIMARY KEY ("id"), ADD KEY "user_id" ("user_id"), ADD KEY "activity_id" ("activity_id");

--
-- Indexes for table "customers_users"
--
ALTER TABLE "customers_users"
  ADD PRIMARY KEY ("id"), ADD KEY "customer_id" ("customer_id"), ADD KEY "user_id" ("user_id");

--
-- Indexes for table "statuses"
--
ALTER TABLE "statuses"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "users"
--
ALTER TABLE "users"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "users_groups"
--
ALTER TABLE "users_groups"
  ADD PRIMARY KEY ("id"), ADD UNIQUE KEY "uc_users_groups" ("user_id","group_id"), ADD KEY "fk_users_groups_users1_idx" ("user_id"), ADD KEY "fk_users_groups_groups1_idx" ("group_id");

--
-- Indexes for table "users_login_attempts"
--
ALTER TABLE "users_login_attempts"
  ADD PRIMARY KEY ("id");

--
-- Indexes for table "users_relations"
--
ALTER TABLE "users_relations"
  ADD PRIMARY KEY ("id"), ADD KEY "user_id" ("user_id"), ADD KEY "creator_id" ("creator_id");

--
-- Indexes for table "users_role_groups"
--
ALTER TABLE "users_role_groups"
  ADD PRIMARY KEY ("id");

--
-- Constraints for dumped tables
--

--
-- Constraints for table "announcements"
--
ALTER TABLE "announcements"
ADD CONSTRAINT "fk_announcements_user_id" FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table "appointments"
--
ALTER TABLE "appointments"
ADD CONSTRAINT "fk_appointments_cid" FOREIGN KEY ("customer_id") REFERENCES "customers" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table "appointments_files"
--
ALTER TABLE "appointments_files"
ADD CONSTRAINT "fk_appointments_files_cid" FOREIGN KEY ("customer_id") REFERENCES "customers" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table "appointments_forms"
--
ALTER TABLE "appointments_forms"
ADD CONSTRAINT "fk_appointments_forms_cid" FOREIGN KEY ("customer_id") REFERENCES "customers" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table "customers_activity"
--
ALTER TABLE "customers_activity"
ADD CONSTRAINT "fk_customers_activity_cid" FOREIGN KEY ("customer_id") REFERENCES "customers" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table "customers_activity_view"
--
ALTER TABLE "customers_activity_view"
ADD CONSTRAINT "fk_activity_view_act_id" FOREIGN KEY ("activity_id") REFERENCES "customers_activity" ("id") ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT "fk_activity_view_user_id" FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table "customers_users"
--
ALTER TABLE "customers_users"
ADD CONSTRAINT "fk_custusers_cust_id" FOREIGN KEY ("customer_id") REFERENCES "customers" ("id") ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT "fk_custusers_user_id" FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table "users_groups"
--
ALTER TABLE "users_groups"
ADD CONSTRAINT "fk_users_groups_groups1" FOREIGN KEY ("group_id") REFERENCES "users_role_groups" ("id") ON DELETE CASCADE ON UPDATE NO ACTION,
ADD CONSTRAINT "fk_users_groups_users1" FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table "users_relations"
--
ALTER TABLE "users_relations"
ADD CONSTRAINT "fk_users_relations_user_id" FOREIGN KEY ("user_id") REFERENCES "users" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
