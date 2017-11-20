<?php
//DATABASE CONNECTION VARIABLES
$host = "localhost"; // Host name
$username = "root"; // Mysql username
$password = "root"; // Mysql password
$db_name = "fms"; // Database name

//DO NOT CHANGE BELOW THIS LINE UNLESS YOU CHANGE THE NAMES OF THE MEMBERS AND LOGINATTEMPTS TABLES

$tbl_prefix = "fms_"; //***PLANNED FEATURE, LEAVE VALUE BLANK FOR NOW*** Prefix for all database tables
$tbl_user = $tbl_prefix."user";
$tbl_company = $tbl_prefix."company";
$tbl_client = $tbl_prefix."clients";
$tbl_quote = $tbl_prefix."quote";
$tbl_employee = $tbl_prefix."employee";
$tbl_invoice = $tbl_prefix."invoice";
$tbl_creditNotes = $tbl_prefix."creditNotes";
$tbl_debitNotes = $tbl_prefix."debitNotes";
