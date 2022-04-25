-- users 

INSERT INTO `cpbit_8`.`users`(`id`, `login`, `user`, `admin`, `name`, `image`, `department`, `office_id`, `office_contact`, `personal_contact`, `office_email`, `personal_email`, `office`, `business_unit`, `nid`, `manager_id`, `manager_emails`, `verify`, `verify_by`, `status`, `delete_temp`, `delete_by`, `created_at`, `updated_at`) SELECT `id`, `login`, `user`, `admin`, `name`, `image`,  `designation`, `office_id`, `office_contact`, `personal_contact`, `office_email`, `personal_email`, `office`, `business_unit`, `nid`, `manager_id`, `manager_emails`, `verify`, `verify_by`, `status`, `delete_temp`, `delete_by`, `created_at`, `updated_at` FROM `cpbit`.`users`

UPDATE `users` SET `image`= REPLACE(`image`, 'images/users/original/', '')

UPDATE `users` SET `zone_office` = `office`
UPDATE `users` SET `zone_office`= "Account and Finance"  WHERE `zone_office`= "Account & Finance" 
UPDATE `users` SET `zone_office`= "TAX and VAT" WHERE `zone_office`= "TAX & VAT"
UPDATE `users` SET `zone_office`= "Valuka 14 and 15 Farm" WHERE `zone_office`= "Valuka 14 & 15 Farm"; 



-- roles

INSERT INTO `cpbit_8`.`roles`(`id`, `name`, `delete_temp`, `delete_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `delete_temp`, `delete_by`, `created_at`, `updated_at` FROM `cpbit`.`roles`

UPDATE `cpbit_8`.`roles` SET `status`= 1


-- role_user

INSERT INTO `cpbit_8`.`role_user`(`id`, `role_id`, `user_id`, `created_at`, `updated_at`) SELECT `id`, `role_id`, `user_id`, `created_at`, `updated_at` FROM `cpbit`.`role_user`



-- sms_operations
INSERT INTO `cpbit_8`.`sms_operations`(`id`, `name`, `code`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `code`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`iservice_operations`

-- sms_operation_user
INSERT INTO `cpbit_8`.`sms_operation_user`(`id`, `sms_operation_id`, `user_id`, `created_at`, `updated_at`) SELECT `id`, `iservice_operation_id`, `user_id`, `created_at`, `updated_at` FROM `cpbit`.`iservice_operation_user`







-- application_categories
INSERT INTO `cpbit_8`.`application_categories`(`id`, `name`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`application_categories`

-- application_subcategories
INSERT INTO `cpbit_8`.`application_subcategories`(`id`, `cat_id`, `name`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `cat_id`, `name`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`application_subcategories`


-- category update by id

-- Win Food = SmartSoft_Food
-- Smart_iLab = SmartSoft_iLab

UPDATE `application_complains` SET `category`='6' WHERE `category` = 'SmartSoft';
UPDATE `application_complains` SET `category`='7' WHERE `category` = 'SmartSoft_Feed';
UPDATE `application_complains` SET `category`='8' WHERE `category` = 'SmartSoft_Farm (Poultry)';
UPDATE `application_complains` SET `category`='9' WHERE `category` = 'SmartSoft_iLab';
UPDATE `application_complains` SET `category`='9' WHERE `category` = 'Smart_iLab';
UPDATE `application_complains` SET `category`='10' WHERE `category` = 'SmartSoft_Farm (Aqua)';
UPDATE `application_complains` SET `category`='11' WHERE `category` = 'SmartSoft_Food';
UPDATE `application_complains` SET `category`='11' WHERE `category` = 'Win Food';
UPDATE `application_complains` SET `category`='13' WHERE `category` = 'Smartsoft_nir';





-- subcategory update by id
--  Live birds Information = Livebird System
-- Send Gl To Ss	= Send Gl To Ss
-- Payment Module   = Bill
-- Sales System Module = Sale Management
-- Payment Module  = Check

UPDATE `application_complains` SET `subcategory`='9' WHERE `subcategory` = 'Payment Module';
UPDATE `application_complains` SET `subcategory`='9' WHERE `subcategory` = 'Check';
UPDATE `application_complains` SET `subcategory`='9' WHERE `subcategory` = 'Bill';
UPDATE `application_complains` SET `subcategory`='10' WHERE `subcategory` = 'Receipt Module';
UPDATE `application_complains` SET `subcategory`='12' WHERE `subcategory` = 'Fixed Asset Module';
UPDATE `application_complains` SET `subcategory`='13' WHERE `subcategory` = 'Production Module';
UPDATE `application_complains` SET `subcategory`='14' WHERE `subcategory` = 'Sales Module';
UPDATE `application_complains` SET `subcategory`='15' WHERE `subcategory` = 'Purchases Module';
UPDATE `application_complains` SET `subcategory`='16' WHERE `subcategory` = 'Cost Module';
UPDATE `application_complains` SET `subcategory`='17' WHERE `subcategory` = 'Generate Module';
UPDATE `application_complains` SET `subcategory`='18' WHERE `subcategory` = 'Inventory Module';
UPDATE `application_complains` SET `subcategory`='19' WHERE `subcategory` = 'Interface Transaction';
UPDATE `application_complains` SET `subcategory`='20' WHERE `subcategory` = 'Smart Credit Module';
UPDATE `application_complains` SET `subcategory`='21' WHERE `subcategory` = 'Master Set Up';
UPDATE `application_complains` SET `subcategory`='22' WHERE `subcategory` = 'Queue Module';
UPDATE `application_complains` SET `subcategory`='23' WHERE `subcategory` = 'Weight Module';
UPDATE `application_complains` SET `subcategory`='24' WHERE `subcategory` = 'Purchasing Direct Module (QC Pass)';
UPDATE `application_complains` SET `subcategory`='25' WHERE `subcategory` = 'Purchasing Indirect Module (Non QC )';
UPDATE `application_complains` SET `subcategory`='26' WHERE `subcategory` = 'Credit Control Module';
UPDATE `application_complains` SET `subcategory`='27' WHERE `subcategory` = 'Accounting Stock Module';
UPDATE `application_complains` SET `subcategory`='28' WHERE `subcategory` = 'Cost Accounting Module';
UPDATE `application_complains` SET `subcategory`='29' WHERE `subcategory` = 'Spare Part Module';
UPDATE `application_complains` SET `subcategory`='30' WHERE `subcategory` = 'Sales System Module';
UPDATE `application_complains` SET `subcategory`='30' WHERE `subcategory` = 'Sale Management';
UPDATE `application_complains` SET `subcategory`='31' WHERE `subcategory` = 'Finish goods Inventory Management Module';
UPDATE `application_complains` SET `subcategory`='32' WHERE `subcategory` = 'Raw Material Inventory Management Module';
UPDATE `application_complains` SET `subcategory`='33' WHERE `subcategory` = 'NCR-CAR Online Module';
UPDATE `application_complains` SET `subcategory`='34' WHERE `subcategory` = 'Set Up Module';
UPDATE `application_complains` SET `subcategory`='35' WHERE `subcategory` = 'Winfarm';
UPDATE `application_complains` SET `subcategory`='36' WHERE `subcategory` = 'Purchases or Transfer in';
UPDATE `application_complains` SET `subcategory`='37' WHERE `subcategory` = 'Sale or Transfer Out';
UPDATE `application_complains` SET `subcategory`='38' WHERE `subcategory` = 'Stock System';
UPDATE `application_complains` SET `subcategory`='39' WHERE `subcategory` = 'Breeder Farm Management';
UPDATE `application_complains` SET `subcategory`='40' WHERE `subcategory` = 'Set Up for Accountant';
UPDATE `application_complains` SET `subcategory`='41' WHERE `subcategory` = 'Set Up Module';
UPDATE `application_complains` SET `subcategory`='42' WHERE `subcategory` = 'Generate PO to Feed Mill';
UPDATE `application_complains` SET `subcategory`='43' WHERE `subcategory` = 'Interface';


-- application_complains
INSERT INTO `cpbit_8`.`application_complains`(`id`, `user_id`, `cat_id`, `subcat_id`, `details`, `process`, `document`, `document2`, `document3`, `document4`, `status`, `created_at`, `updated_at`) SELECT `id`, `user_id`, `category`, `subcategory`, `details`, `process`, `document`, `document2`, `document3`, `document4`, `status`, `created_at`, `updated_at` FROM `cpbit`.`application_complains`

-- application_remarks
INSERT INTO `cpbit_8`.`application_remarks`(`id`, `comp_id`, `process`, `details`, `document`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `comp_id`, `process`, `details`, `document`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`application_remarks`



-- hardware_complains
INSERT INTO `cpbit_8`.`hardware_complains`(`id`, `user_id`,  `details`, `process`, `computer_name`, `document`, `accessories`, `status`, `created_at`, `updated_at`) SELECT `id`, `user_id`, `details`, `process`, `computer_name`, `document`, `tools`, `status`, `created_at`, `updated_at` FROM `cpbit`.`hardware_complains`






-- Inventory

-- inventory_new_products
INSERT INTO `cpbit_8`.`inventory_new_products`(`id`, `cat_id`, `subcat_id`, `name`, `serial`, `remarks`, `document`, `purchase`, `warranty`, `created_by`, `give_st`, `delete_temp`, `delete_by`, `created_at`, `updated_at`) SELECT `id`, `category`, `subcategory`, `name`, `serial`, `remarks`, `document`, `purchase`, `warranty`, `created_by`, `give_st`, `delete_temp`, `delete_by`, `created_at`, `updated_at` FROM `cpbit`.`inventory_new_products`

UPDATE `inventory_new_products` SET `document`= REPLACE(`document`, 'images/inventory/', '');


UPDATE `inventory_new_products` SET `category`= 30 WHERE `category` = 'Attendance Machine';

UPDATE `inventory_new_products` SET `category`= 9 WHERE `category` = 'Printer Laser';

UPDATE `inventory_new_products` SET `category`= 10 WHERE `category` = 'Printer Thermal';

UPDATE `inventory_new_products` SET `category`= 16 WHERE `category` = 'Printer Dot Matrix';

UPDATE `inventory_new_products` SET `category`= 6 WHERE `category` = 'UPS';

UPDATE `inventory_new_products` SET `category`= 8 WHERE `category` = 'Monitor';

UPDATE `inventory_new_products` SET `category`= 21 WHERE `category` = 'Projector';

UPDATE `inventory_new_products` SET `category`= 28 WHERE `category` = 'Mouse';

UPDATE `inventory_new_products` SET `category`= 23 WHERE `category` = 'WIFI';

UPDATE `inventory_new_products` SET `category`= 42 WHERE `category` = 'Weight Scale';

UPDATE `inventory_new_products` SET `category`= 24 WHERE `category` = 'Switch';

UPDATE `inventory_new_products` SET `category`= 12 WHERE `category` = 'Computer Desktop';

UPDATE `inventory_new_products` SET `category`= 22 WHERE `category` = 'CCTV';

UPDATE `inventory_new_products` SET `category`= 26 WHERE `category` = 'Barcode Scanner';

UPDATE `inventory_new_products` SET `category`= 25 WHERE `category` = 'Router';

UPDATE `inventory_new_products` SET `category`= 17 WHERE `category` = 'Printer Inkjet';

UPDATE `inventory_new_products` SET `category`= 27 WHERE `category` = 'Keyboard';

UPDATE `inventory_new_products` SET `category`= 20 WHERE `category` = 'Laptop'; 

UPDATE `inventory_new_products` SET `category`= 19 WHERE `category` = 'Computer All IN One';

-- subcategory
UPDATE `inventory_new_products` SET `subcategory`= 59 WHERE `subcategory` = 'Canon';

UPDATE `inventory_new_products` SET `subcategory`= 116 WHERE `subcategory` = 'Actatek';

UPDATE `inventory_new_products` SET `subcategory`= 104 WHERE `subcategory` = 'A4Tech';

UPDATE `inventory_new_products` SET `subcategory`= 57 WHERE `subcategory` = 'HP';

UPDATE `inventory_new_products` SET `subcategory`= 64 WHERE `subcategory` = 'Epson';

UPDATE `inventory_new_products` SET `subcategory`= 84 WHERE `subcategory` = 'Online 10000 VA';

UPDATE `inventory_new_products` SET `subcategory`= 58 WHERE `subcategory` = 'Samsung';

UPDATE `inventory_new_products` SET `subcategory`= 101 WHERE `subcategory` = 'Netgear Gigaport';

UPDATE `inventory_new_products` SET `subcategory`= 62 WHERE `subcategory` = 'Brother';

UPDATE `inventory_new_products` SET `subcategory`= 91 WHERE `subcategory` = 'Altai';

UPDATE `inventory_new_products` SET `subcategory`= 92 WHERE `subcategory` = 'Wireless';

UPDATE `inventory_new_products` SET `subcategory`= 93 WHERE `subcategory` = 'Wired (USB)';

UPDATE `inventory_new_products` SET `subcategory`= 94 WHERE `subcategory` = 'Mikrotik';

UPDATE `inventory_new_products` SET `subcategory`= 88 WHERE `subcategory` = 'Camera HD';

UPDATE `inventory_new_products` SET `subcategory`= 69 WHERE `subcategory` = 'HP CPU';

UPDATE `inventory_new_products` SET `subcategory`= 63 WHERE `subcategory` = 'Zebra';

UPDATE `inventory_new_products` SET `subcategory`= 238 WHERE `subcategory` = 'Fm21e 300 Kg';

UPDATE `inventory_new_products` SET `subcategory`= 25 WHERE `subcategory` = 'Offline 1000 VA ';

UPDATE `inventory_new_products` SET `subcategory`= 70 WHERE `subcategory` = 'Lenovo';

UPDATE `inventory_new_products` SET `subcategory`= 68 WHERE `subcategory` = 'Dell CPU';

UPDATE `inventory_new_products` SET `subcategory`= 56 WHERE `subcategory` = 'Dell';

UPDATE `inventory_new_products` SET `subcategory`= 71 WHERE `subcategory` = 'Asus';

-- operation
UPDATE `inventory_old_products` SET `operation` = 2 WHERE `operation` = 'Head Office'
UPDATE `inventory_old_products` SET `operation` = 3 WHERE `operation` = 'Feedmil'
UPDATE `inventory_old_products` SET `operation` = 4 WHERE `operation` = 'Breeder & Hatchery'
UPDATE `inventory_old_products` SET `operation` = 5 WHERE `operation` = 'Integration Business'
UPDATE `inventory_old_products` SET `operation` = 6 WHERE `operation` = 'Aqua Business'
UPDATE `inventory_old_products` SET `operation` = 7 WHERE `operation` = 'Food Business'


-- inventory old product
INSERT INTO `cpbit_8`.`inventory_old_products`( `id`, `new_pro_id`, `cat_id`, `subcat_id`, `office`, `business_unit`, `operation_id`, `name`, `serial`, `remarks`, `type`, `rec_name`, `rec_contact`, `rec_position`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at`) SELECT `id`, `new_pro_id`, `category`, `subcategory`, `office`, `business_unit`, `operation`, `name`, `serial`, `remarks`, `type`, `rec_name`, `rec_contact`, `rec_position`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at` FROM `cpbit`.`inventory_old_products`









-- Power BI

-- pbi_roles
INSERT INTO `cpbit_8`.`pbi_roles`(`id`, `name`, `link`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `link`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`iservice_powerbis` 

-- pbi_user_role
INSERT INTO `cpbit_8`.`pbi_user_role`(`id`, `pbi_role_id`, `user_id`, `created_at`, `updated_at`) SELECT `id`, `iservice_powerbi_id`, `user_id`, `created_at`, `updated_at` FROM `cpbit`.`iservice_powerbi_user`





-- mobile_app_roles
INSERT INTO `cpbit_8`.`mobile_app_roles`(`id`, `name`, `status`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `status`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`isales_roles`

-- mobile_app_role_user
INSERT INTO `cpbit_8`.`mobile_app_role_user`(`id`, `mobile_app_role_id`, `user_id`, `created_at`, `updated_at`) SELECT `id`, `iqscm_role_id`, `user_id`, `created_at`, `updated_at` FROM `cpbit`.`isales_role_user`

-- mobile_app_versions
INSERT INTO `cpbit_8`.`mobile_app_versions`(`id`, `name`, `version`, `status`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `version`, `status`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`isales_app_versions`




-- Room Booking
INSERT INTO `cpbit_8`.`rooms`(`id`, `name`, `capacity`, `projector`, `image`, `image2`, `image3`, `remarks`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `capacity`, `projector`, `image`, `image2`, `image3`, `remarks`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at` FROM `cpbit`.`rooms`


UPDATE `rooms` SET `image`=REPLACE(`image`, 'images/room/original/', ''),
`image2`=REPLACE(`image2`, 'images/room/original/', ''),
`image3`=REPLACE(`image3`, 'images/room/original/', '');


UPDATE `rooms` SET `projector`= 1  where `id` = 7;
UPDATE `rooms` SET `projector`= 1  where `id` = 8;
UPDATE `rooms` SET `projector`= 1  where `id` = 13;

-- room_bookings
INSERT INTO `cpbit_8`.`room_bookings`(`id`, `user_id`, `room_id`, `start`, `end`, `duration`, `purpose`, `status`, `created_at`, `updated_at`) SELECT `id`, `user_id`, `room_id`, `start`, `end`, `hours`, `purpose`, `status`, `created_at`, `updated_at` FROM `cpbit`.`room_bookings`



--Carpool

--carpool_bookings
INSERT INTO `cpbit_8`.`carpool_bookings`(`id`, `user_id`, `car_id`, `driver_id`, `start`, `end`, `destination`, `purpose`, `status`, `gas`, `octane`, `toll`, `cost`, `driver_rating`, `start_mileage`, `end_mileage`, `km`, `comit_st`, `created_at`, `updated_at`) SELECT `id`, `user_id`, `car_id`, `driver_id`, `start`, `end`, `destination`, `purpose`, `status`, `gas`, `octane`, `toll`, `cost`, `driver_rating`, `start_mileage`, `end_mileage`, `km`, `comit_st`, `created_at`, `updated_at` FROM `cpbit`.`carpool_bookings` 

-- carpool_cars
INSERT INTO `cpbit_8`.`carpool_cars`(`id`, `number`, `name`, `capacity`, `temporary`, `image`, `image2`, `image3`, `remarks`, `last_use`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at`) SELECT `id`, `number`, `name`, `capacity`, `temporary`, `image`, `image2`, `image3`, `remarks`, `last_use`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at` FROM `cpbit`.`carpool_cars`


UPDATE `carpool_cars` SET `image`=REPLACE(`image`, 'images/carpool/cars/original/', ''),
`image2`=REPLACE(`image2`, 'images/carpool/cars/original/', ''),
`image3`=REPLACE(`image3`, 'images/carpool/cars/original/', '');


INSERT INTO `cpbit_8`.`carpool_car_maintenances`(`id`, `car_id`, `driver_id`, `start`, `end`, `status`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `car_id`, `driver_id`, `start`, `end`, `status`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`carpool_car_maintenances`


INSERT INTO `cpbit_8`.`carpool_car_requisitions`(`id`, `car_id`, `driver_id`, `start`, `end`, `status`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `car_id`, `driver_id`, `start`, `end`, `status`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`carpool_car_requisitions`

INSERT INTO `cpbit_8`.`carpool_destinations`(`id`, `name`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`carpool_destinations`

-- carpool_drivers
INSERT INTO `cpbit_8`.`carpool_drivers`(`id`, `name`, `contact`, `car_id`, `image`, `image_small`, `license`, `nid`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at`) SELECT `id`, `name`, `contact`, `car_id`, `image`, `image_small`, `license`, `nid`, `status`, `created_by`, `delete_temp`, `delete_by`, `created_at`, `updated_at` FROM `cpbit`.`carpool_drivers`

-- carpool_driver_leaves
INSERT INTO `cpbit_8`.`carpool_driver_leaves`(`id`, `car_id`, `driver_id`, `start`, `end`, `status`, `created_by`, `created_at`, `updated_at`) SELECT `id`, `car_id`, `driver_id`, `start`, `end`, `status`, `created_by`, `created_at`, `updated_at` FROM `cpbit`.`carpool_driver_leaves`
 






-- hardware_complains


UPDATE `hardware_complains` SET `category`= 30 WHERE `category` = 'Attendance Machine';

UPDATE `hardware_complains` SET `category`= 9 WHERE `category` = 'Printer Laser';

UPDATE `hardware_complains` SET `category`= 10 WHERE `category` = 'Printer Thermal';

UPDATE `hardware_complains` SET `category`= 16 WHERE `category` = 'Printer Dot Matrix';

UPDATE `hardware_complains` SET `category`= 6 WHERE `category` = 'UPS';

UPDATE `hardware_complains` SET `category`= 8 WHERE `category` = 'Monitor';

UPDATE `hardware_complains` SET `category`= 21 WHERE `category` = 'Projector';

UPDATE `hardware_complains` SET `category`= 28 WHERE `category` = 'Mouse';

UPDATE `hardware_complains` SET `category`= 23 WHERE `category` = 'WIFI';

UPDATE `hardware_complains` SET `category`= 42 WHERE `category` = 'Weight Scale';

UPDATE `hardware_complains` SET `category`= 24 WHERE `category` = 'Switch';

UPDATE `hardware_complains` SET `category`= 12 WHERE `category` = 'Computer Desktop';

UPDATE `hardware_complains` SET `category`= 22 WHERE `category` = 'CCTV';

UPDATE `hardware_complains` SET `category`= 26 WHERE `category` = 'Barcode Scanner';

UPDATE `hardware_complains` SET `category`= 25 WHERE `category` = 'Router';

UPDATE `hardware_complains` SET `category`= 17 WHERE `category` = 'Printer Inkjet';

UPDATE `hardware_complains` SET `category`= 27 WHERE `category` = 'Keyboard';

UPDATE `hardware_complains` SET `category`= 20 WHERE `category` = 'Laptop'; 

UPDATE `hardware_complains` SET `category`= 19 WHERE `category` = 'Computer All IN One';

UPDATE `hardware_complains` SET `category`= 44 WHERE `category` = 'Adapter';

UPDATE `hardware_complains` SET `category`= 43 WHERE `category` = 'Battery';

UPDATE `hardware_complains` SET `category`= 40 WHERE `category` = 'Cable';

UPDATE `hardware_complains` SET `category`= 31 WHERE `category` = 'CPB-NAS';

UPDATE `hardware_complains` SET `category`= 51 WHERE `category` = 'Hard Disk Drive';

UPDATE `hardware_complains` SET `category`= 38 WHERE `category` = 'Networking';

UPDATE `hardware_complains` SET `category`= 35 WHERE `category` = 'Operating System (Windows) ';

UPDATE `hardware_complains` SET `category`= 46 WHERE `category` = 'P.D.A';

UPDATE `hardware_complains` SET `category`= 53 WHERE `category` = 'RAM';

UPDATE `hardware_complains` SET `category`= 41 WHERE `category` = 'Rotem';

UPDATE `hardware_complains` SET `category`= 34 WHERE `category` = 'Software';

UPDATE `hardware_complains` SET `category`= 50 WHERE `category` = 'Solid State Drive';

UPDATE `hardware_complains` SET `category`= 39 WHERE `category` = 'USB / Flash Drive';


-- subcategory

UPDATE `hardware_complains` SET `subcategory`= 260 WHERE `subcategory` = '1 TB';

UPDATE `hardware_complains` SET `subcategory`= 268 WHERE `subcategory` = '2 GB';

UPDATE `hardware_complains` SET `subcategory`= 269 WHERE `subcategory` = '4 GB';

UPDATE `hardware_complains` SET `subcategory`= 259 WHERE `subcategory` = '500 GB';

UPDATE `hardware_complains` SET `subcategory`= 270 WHERE `subcategory` = '8 GB';

UPDATE `hardware_complains` SET `subcategory`= 77 WHERE `subcategory` = 'Acer';

UPDATE `hardware_complains` SET `subcategory`= 116 WHERE `subcategory` = 'Actatek';

UPDATE `hardware_complains` SET `subcategory`= 136 WHERE `subcategory` = 'Actatek Login';

UPDATE `hardware_complains` SET `subcategory`= 242 WHERE `subcategory` = 'All In One Pc';

UPDATE `hardware_complains` SET `subcategory`= 104 WHERE `subcategory` = 'A4Tech';

UPDATE `hardware_complains` SET `subcategory`= 91 WHERE `subcategory` = 'Altai';

UPDATE `hardware_complains` SET `subcategory`= 71 WHERE `subcategory` = 'Asus';

UPDATE `hardware_complains` SET `subcategory`= 62 WHERE `subcategory` = 'Brother';

UPDATE `hardware_complains` SET `subcategory`= 59 WHERE `subcategory` = 'Canon';

UPDATE `hardware_complains` SET `subcategory`= 89 WHERE `subcategory` = 'Camera Analog';

UPDATE `hardware_complains` SET `subcategory`= 88 WHERE `subcategory` = 'Camera HD';

UPDATE `hardware_complains` SET `subcategory`= 140 WHERE `subcategory` = 'Camera Storage';

UPDATE `hardware_complains` SET `subcategory`= 95 WHERE `subcategory` = 'Cisco';

UPDATE `hardware_complains` SET `subcategory`= 97 WHERE `subcategory` = 'Cisco Gigaport';

UPDATE `hardware_complains` SET `subcategory`= 96 WHERE `subcategory` = 'Cisco SFP Gigaport';

UPDATE `hardware_complains` SET `subcategory`= 68 WHERE `subcategory` = 'Dell CPU';

UPDATE `hardware_complains` SET `subcategory`= 267 WHERE `subcategory` = 'Data/Fiber connenction cable';

UPDATE `hardware_complains` SET `subcategory`= 56 WHERE `subcategory` = 'Dell';

UPDATE `hardware_complains` SET `subcategory`= 12 WHERE `subcategory` = 'Dell CPU';

UPDATE `hardware_complains` SET `subcategory`= 59 WHERE `subcategory` = 'Dlink';

UPDATE `hardware_complains` SET `subcategory`= 98 WHERE `subcategory` = 'Dlink Gigaport';

UPDATE `hardware_complains` SET `subcategory`= 86 WHERE `subcategory` = 'DVR/AVR';

UPDATE `hardware_complains` SET `subcategory`= 64 WHERE `subcategory` = 'Epson';

UPDATE `hardware_complains` SET `subcategory`= 238 WHERE `subcategory` = 'Fm21e 300 Kg';

UPDATE `hardware_complains` SET `subcategory`= 78 WHERE `subcategory` = 'Fujitsu';

UPDATE `hardware_complains` SET `subcategory`= 236 WHERE `subcategory` = 'Gmail/Others';

UPDATE `hardware_complains` SET `subcategory`= 57 WHERE `subcategory` = 'HP';

UPDATE `hardware_complains` SET `subcategory`= 69 WHERE `subcategory` = 'HP CPU';

UPDATE `hardware_complains` SET `subcategory`= 146 WHERE `subcategory` = 'HDMI';

UPDATE `hardware_complains` SET `subcategory`= 81 WHERE `subcategory` = 'Hitachi';

UPDATE `hardware_complains` SET `subcategory`= 143 WHERE `subcategory` = 'Install';

UPDATE `hardware_complains` SET `subcategory`= 134 WHERE `subcategory` = 'Internet Captive Portal ';

UPDATE `hardware_complains` SET `subcategory`= 243 WHERE `subcategory` = 'Internet Switch';

UPDATE `hardware_complains` SET `subcategory`= 135 WHERE `subcategory` = 'LAN Connection';

UPDATE `hardware_complains` SET `subcategory`= 241 WHERE `subcategory` = 'Laptop';

UPDATE `hardware_complains` SET `subcategory`= 263 WHERE `subcategory` = 'Laptop-Dell';

UPDATE `hardware_complains` SET `subcategory`= 262 WHERE `subcategory` = 'Laptop-HP';

UPDATE `hardware_complains` SET `subcategory`= 129 WHERE `subcategory` = 'LG';

UPDATE `hardware_complains` SET `subcategory`= 122 WHERE `subcategory` = 'License Activation';

UPDATE `hardware_complains` SET `subcategory`= 264 WHERE `subcategory` = 'Logitech';

UPDATE `hardware_complains` SET `subcategory`= 244 WHERE `subcategory` = 'Media Converter ( Mc )';

UPDATE `hardware_complains` SET `subcategory`= 73 WHERE `subcategory` = 'Microsoft (surface)';

UPDATE `hardware_complains` SET `subcategory`= 94 WHERE `subcategory` = 'Mikrotik';

UPDATE `hardware_complains` SET `subcategory`= 101 WHERE `subcategory` = 'Netgear Gigaport';

UPDATE `hardware_complains` SET `subcategory`= 84 WHERE `subcategory` = 'Online 10000 VA';

UPDATE `hardware_complains` SET `subcategory`= 25 WHERE `subcategory` = 'Online 1000 VA';

UPDATE `hardware_complains` SET `subcategory`= 24 WHERE `subcategory` = 'Online 1000 VA (China)';

UPDATE `hardware_complains` SET `subcategory`= 26 WHERE `subcategory` = 'Online 2000 VA';

UPDATE `hardware_complains` SET `subcategory`= 23 WHERE `subcategory` = 'Online 650 VA (China)';

UPDATE `hardware_complains` SET `subcategory`= 28 WHERE `subcategory` = 'Online 3000 VA';

UPDATE `hardware_complains` SET `subcategory`= 83 WHERE `subcategory` = 'Online 5000 VA';

UPDATE `hardware_complains` SET `subcategory`= 139 WHERE `subcategory` = 'Online 6000 VA';

UPDATE `hardware_complains` SET `subcategory`= 82 WHERE `subcategory` = 'Optoma';

UPDATE `hardware_complains` SET `subcategory`= 118 WHERE `subcategory` = 'Others';

UPDATE `hardware_complains` SET `subcategory`= 249 WHERE `subcategory` = 'P.D.A Charger Cradle(terminal)';

UPDATE `hardware_complains` SET `subcategory`= 250 WHERE `subcategory` = 'P.D.A Handheld Devices Mobile';

UPDATE `hardware_complains` SET `subcategory`= 248 WHERE `subcategory` = 'P.D.A Power Adapter';

UPDATE `hardware_complains` SET `subcategory`= 118 WHERE `subcategory` = 'Plc';

UPDATE `hardware_complains` SET `subcategory`= 149 WHERE `subcategory` = 'Power';

UPDATE `hardware_complains` SET `subcategory`= 117 WHERE `subcategory` = 'Quota Limit';

UPDATE `hardware_complains` SET `subcategory`= 240 WHERE `subcategory` = 'Rotem';

UPDATE `hardware_complains` SET `subcategory`= 235 WHERE `subcategory` = 'Rotem Alarm';

UPDATE `hardware_complains` SET `subcategory`= 58 WHERE `subcategory` = 'Samsung';

UPDATE `hardware_complains` SET `subcategory`= 258 WHERE `subcategory` = 'Sata 2.5''' ;

UPDATE `hardware_complains` SET `subcategory`= 58 WHERE `subcategory` = 'Samsung';

UPDATE `hardware_complains` SET `subcategory`= 145 WHERE `subcategory` = 'SmartSoft/WinFeed/WinFarm/WinFood';

UPDATE `hardware_complains` SET `subcategory`= 100 WHERE `subcategory` = 'Tenda  Gigaport';

UPDATE `hardware_complains` SET `subcategory`= 265 WHERE `subcategory` = 'Trendnet';

UPDATE `hardware_complains` SET `subcategory`= 144 WHERE `subcategory` = 'Update';

UPDATE `hardware_complains` SET `subcategory`= 148 WHERE `subcategory` = 'USB';

UPDATE `hardware_complains` SET `subcategory`= 256 WHERE `subcategory` = 'USB cable(Printer)';

UPDATE `hardware_complains` SET `subcategory`= 255 WHERE `subcategory` = 'USB Converter(RS-232)';

UPDATE `hardware_complains` SET `subcategory`= 254 WHERE `subcategory` = 'V.P.N';

UPDATE `hardware_complains` SET `subcategory`= 147 WHERE `subcategory` = 'VGA';

UPDATE `hardware_complains` SET `subcategory`= 44 WHERE `subcategory` = 'wifi';

UPDATE `hardware_complains` SET `subcategory`= 128 WHERE `subcategory` = 'Windows Update';

UPDATE `hardware_complains` SET `subcategory`= 92 WHERE `subcategory` = 'Wireless';

UPDATE `hardware_complains` SET `subcategory`= 93 WHERE `subcategory` = 'Wired (USB)';

UPDATE `hardware_complains` SET `subcategory`= 63 WHERE `subcategory` = 'Zebra';

UPDATE `hardware_complains` SET `subcategory`= 233 WHERE `subcategory` = 'ZKTeco';



INSERT INTO `hardware_complains`(`id`, `user_id`, `cat_id`, `subcat_id`, `details`, `process`, `computer_name`, `document`, `accessories`, `status`, `created_at`, `updated_at`) SELECT `id`, `user_id`, `category`, `subcategory`, `details`, `process`, `computer_name`, `document`, `tools`, `status`, `created_at`, `updated_at` FROM `cpbit_copy`.`hardware_complains`;







INSERT INTO `pbi_expenses`(`id`, `expense_date`, `business`, `business_unit`, `operation`, `department`, `unit_level_code`, `unit_level_name`, `control_account_code`, `control_account_name`, `account_code`, `account_name`, `expense_type`, `expense_group`, `amount`, `created_at`, `updated_at`) SELECT `id`, `expense_date`, `business`, `business_unit`, `operation`, `department`, `unit_level_code`, `unit_level_name`, `control_account_code`, `control_account_name`, `account_code`, `account_name`, `expense_type`, `expense_group`, `amount`, `created_at`, `updated_at` FROM `cpbit_copy`.`bi_expenses`;

INSERT INTO `pbi_farm_aqua_purchases`(`id`, `purchase_date`, `business_area`, `business_place`, `vendor_code`, `vendor_name`, `vendor_group`, `product_code`, `product_name`, `product_group`, `product_line`, `measurement`, `quantity`, `weight`, `amount`, `created_at`, `updated_at`) SELECT `id`, `purchase_date`, `business_area`, `business_place`, `vendor_code`, `vendor_name`, `vendor_group`, `product_code`, `product_name`, `product_group`, `product_line`, `measurement`, `quantity`, `weight`, `amount`, `created_at`, `updated_at` FROM `cpbit_copy`.`bi_farm_aqua_purchases`;

INSERT INTO `pbi_farm_aqua_sales`(`id`, `sale_date`, `business_area`, `business_place`, `customer_code`, `customer_name`, `customer_group`, `district_code`, `district_name`, `product_code`, `product_name`, `product_group`, `product_line`, `measurement`, `quantity`, `weight`, `amount`, `created_at`, `updated_at`) SELECT `id`, `sale_date`, `business_area`, `business_place`, `customer_code`, `customer_name`, `customer_group`, `district_code`, `district_name`, `product_code`, `product_name`, `product_group`, `product_line`, `measurement`, `quantity`, `weight`, `amount`, `created_at`, `updated_at` FROM `cpbit_copy`.`bi_farm_aqua_sales`;

INSERT INTO `pbi_farm_poultry_purchases`(`id`, `purchase_date`, `business_area`, `business_place`, `vendor_code`, `vendor_name`, `vendor_group`, `product_code`, `product_name`, `product_group`, `product_line`, `measurement`, `quantity`, `weight`, `amount`, `created_at`, `updated_at`) SELECT `id`, `purchase_date`, `business_area`, `business_place`, `vendor_code`, `vendor_name`, `vendor_group`, `product_code`, `product_name`, `product_group`, `product_line`, `measurement`, `quantity`, `weight`, `amount`, `created_at`, `updated_at` FROM `cpbit_copy`.`bi_farm_poultry_purchases`;

INSERT INTO `pbi_farm_poultry_sales`(`id`, `sale_date`, `business_area`, `business_place`, `customer_code`, `customer_name`, `customer_group`, `district_code`, `district_name`, `product_code`, `product_name`, `product_group`, `product_line`, `measurement`, `quantity`, `weight`, `amount`, `created_at`, `updated_at`) SELECT `id`, `sale_date`, `business_area`, `business_place`, `customer_code`, `customer_name`, `customer_group`, `district_code`, `district_name`, `product_code`, `product_name`, `product_group`, `product_line`, `measurement`, `quantity`, `weight`, `amount`, `created_at`, `updated_at` FROM `cpbit_copy`.`bi_farm_poultry_sales`;

INSERT INTO `pbi_feed_productions`(`id`, `production_date`, `plant`, `production_line`, `production_no`, `brand_name`, `product_code`, `product_name`, `packing_size`, `shift1_q`, `shift1_w`, `shift2_q`, `shift2_w`, `shift3_q`, `shift3_w`, `created_at`, `updated_at`) SELECT `id`, `production_date`, `plant`, `production_line`, `production_no`, `brand_name`, `product_code`, `product_name`, `packing_size`, `shift1_q`, `shift1_w`, `shift2_q`, `shift2_w`, `shift3_q`, `shift3_w`, `created_at`, `updated_at` FROM `cpbit_copy`.`bi_feed_productions`;

INSERT INTO `pbi_feed_purchases`(`id`, `purchase_date`, `plant`, `vendor_code`, `vendor_name`, `product_code`, `product_name`, `product_category`, `product_group`, `measurement`, `quantity`, `weight`, `amount`, `created_at`, `updated_at`) SELECT `id`, `purchase_date`, `plant`, `vendor_code`, `vendor_name`, `product_code`, `product_name`, `product_category`, `product_group`, `measurement`, `quantity`, `weight`, `amount`, `created_at`, `updated_at` FROM `cpbit_copy`.`bi_feed_purchases`;

INSERT INTO `pbi_food_further_sales`(`id`, `sale_date`, `business_area`, `business_place`, `customer_code`, `customer_name`, `customer_group`, `district_code`, `district_name`, `product_code`, `product_name`, `product_group`, `product_line`, `measurement`, `quantity`, `weight`, `amount`, `created_at`, `updated_at`) SELECT `id`, `sale_date`, `business_area`, `business_place`, `customer_code`, `customer_name`, `customer_group`, `district_code`, `district_name`, `product_code`, `product_name`, `product_group`, `product_line`, `measurement`, `quantity`, `weight`, `amount`, `created_at`, `updated_at` FROM `cpbit_copy`.`bi_food_further_sales`;

INSERT INTO `pbi_food_slaughter_sales`(`id`, `sale_date`, `business_area`, `business_place`, `customer_code`, `customer_name`, `customer_group`, `district_code`, `district_name`, `product_code`, `product_name`, `product_group`, `product_line`, `product_type`, `measurement`, `quantity`, `weight`, `amount`, `created_at`, `updated_at`) SELECT `id`, `sale_date`, `business_area`, `business_place`, `customer_code`, `customer_name`, `customer_group`, `district_code`, `district_name`, `product_code`, `product_name`, `product_group`, `product_line`, `product_type`, `measurement`, `quantity`, `weight`, `amount`, `created_at`, `updated_at` FROM `cpbit_copy`.`bi_food_slaughter_sales`;




