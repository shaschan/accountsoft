--use database with the name "fms"
--table : fms_clients
    
CREATE TABLE `fms_clients` (
  `id` int(11) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `emails` varchar(100) NOT NULL,
  `billing_address` varchar(1000) NOT NULL,
  `CIN` varchar(100) NOT NULL,
  `PAN` varchar(100) NOT NULL,
  `GST` varchar(100) NOT NULL,
  `SAC` varchar(100) NOT NULL,
  `added_date` date NOT NULL,
  `modified_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `fms_clients`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `fms_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--table : fms_company

CREATE TABLE `fms_company` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `CIN` varchar(100) NOT NULL,
  `PAN` varchar(100) NOT NULL,
  `GST` varchar(100) NOT NULL,
  `SAC` varchar(100) NOT NULL,
  `billing_address` varchar(1000) NOT NULL,
  `user_id` int(100) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `fms_company`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `fms_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--table : fms_user

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
  `hash` varchar(1000) NOT NULL
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