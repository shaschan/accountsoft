CREATE TABLE `fms_invoice` (
  `id` int(100) NOT NULL,
  `invoiceNum` varchar(100) NOT NULL,
  `adOrInOrFin` varchar(100) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `netValue` varchar(100) NOT NULL,
  `tax` varchar(100) NOT NULL,
  `totalValue` varchar(100) NOT NULL,
  `paymentDate` date NOT NULL,
  `status` varchar(100) NOT NULL COMMENT 'cancelled/active/overwritten',
  `addedBy` varchar(100) NOT NULL,
  `approvedBy1` varchar(100) NOT NULL,
  `approvedBy2` varchar(100) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `fms_invoice`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `fms_invoice`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;



CREATE TABLE `fms_creditNotes` (
  `id` int(100) NOT NULL,
  `creditNoteNo` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `netValue` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL COMMENT 'cancelled/active',
  `addedBy` varchar(100) NOT NULL,
  `approvedBy1` varchar(100) NOT NULL,
  `approvedBy2` varchar(100) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `fms_creditNotes`
  ADD PRIMARY KEY (`id`);

CREATE TABLE `fms_employee` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `ecode` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `currAddr` varchar(1000) NOT NULL,
  `permAddr` varchar(1000) NOT NULL,
  `panNo` varchar(100) NOT NULL,
  `aadharNo` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `doj` date NOT NULL,
  `photoLink` varchar(100) NOT NULL,
  `prevOrg` varchar(100) NOT NULL DEFAULT 'NA',
  `contactNo` varchar(100) NOT NULL,
  `emergencyNo` varchar(100) NOT NULL,
  `martialStatus` varchar(100) NOT NULL,
  `spouseName` varchar(100) NOT NULL DEFAULT 'NA',
  `spouseContactNo` varchar(100) DEFAULT NULL,
  `childQty` int(100) DEFAULT NULL,
  `health` varchar(1000) NOT NULL,
  `criminal` varchar(1000) NOT NULL,
  `latestSalary` varchar(1000) NOT NULL,
  `prevSalary` varchar(1000) NOT NULL DEFAULT 'NA',
  `joinSalary` varchar(1000) NOT NULL,
  `leaveRem` int(100) NOT NULL,
  `quatAppraisal` varchar(100) NOT NULL DEFAULT 'NA',
  `quatAppBy` varchar(100) NOT NULL DEFAULT 'NA',
  `yearAppraisal` varchar(100) NOT NULL DEFAULT 'NA',
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `fms_employee`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `fms_employee`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

CREATE TABLE `fms_clients` (
  `id` int(11) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `ccode` varchar(100) NOT NULL,
  `emails` varchar(100) NOT NULL,
  `billing_address` varchar(1000) NOT NULL,
  `PAN` varchar(100) NOT NULL,
  `GST` varchar(100) NOT NULL,
  `SAC` varchar(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `added_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `fms_clients`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `fms_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

CREATE TABLE `fms_debitNotes` (
  `id` int(100) NOT NULL,
  `debitNoteNo` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `netValue` varchar(100) NOT NULL,
  `tax` varchar(100) NOT NULL,
  `totalValue` varchar(100) NOT NULL,
  `voucherCount` int(100) NOT NULL,
  `paymentDate` date NOT NULL,
  `status` varchar(100) NOT NULL COMMENT 'cancelled/active',
  `addedBy` varchar(100) NOT NULL,
  `approvedBy1` varchar(100) NOT NULL,
  `approvedBy2` varchar(100) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `fms_debitNotes`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `fms_debitNotes`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

CREATE TABLE `fms_user` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `activated` int(2) NOT NULL DEFAULT '0',
  `active` int(2) NOT NULL DEFAULT '0',
  `created_datetime` datetime NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `ip` varchar(100) NOT NULL,
  `hash` varchar(1000) NOT NULL,
  `is_admin` varchar(10) NOT NULL DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE `fms_user`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `fms_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


//////////////
1)
sudo vim /etc/apache2/mods-available/mime.conf
AddType application/x-httpd-php .php


2)
sudo a2enmod rewrite

3)
sudo a2enmod headers

4)
sudo vim /etc/apache2/apache2.conf
<Directory /var/www/ >
        Options Indexes Includes FollowSymLinks MultiViews
        AllowOverride All
        Require all granted
</Directory>


/////////////