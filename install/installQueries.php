<?php
	$installQueries = array(
		"CREATE TABLE IF NOT EXISTS application (
			PNID int(5) NOT NULL UNIQUE AUTO_INCREMENT,
			Version varchar(5) NOT NULL,
			Primary Key(PNID)
		)",

		"INSERT INTO application (Version)
			VALUES ('2.0')",

		"CREATE TABLE IF NOT EXISTS birthdays (
			BirthdayID int(255) NOT NULL UNIQUE AUTO_INCREMENT,
			PersonName varchar(80) NOT NULL,
			Day int(2) NOT NULL,
			Month int(2) NOT NULL,
			Year int(4) NOT NULL,
			LastUpdated timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			Primary Key(BirthDayID)
		)",

		"CREATE TABLE IF NOT EXISTS reminders (
			ReminderID int(255) NOT NULL UNIQUE AUTO_INCREMENT,
			Comment varchar(255) NOT NULL,
			Day int(2) NOT NULL,
			Month int(2) NOT NULL,
			Year int(4) NOT NULL,
			Occurrence int(2) NOT NULL,
			Times int(3) NOT NULL,
			LastUpdated timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			Primary Key(ReminderID)
		)",

		"CREATE TABLE IF NOT EXISTS paymentCategories (
			PaymentCategoryID int(255) NOT NULL UNIQUE AUTO_INCREMENT,
			Name varchar(80) NOT NULL,
			LastUpdated timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			Primary Key(PaymentCategoryID)
		)",

		"CREATE TABLE IF NOT EXISTS payments (
			PaymentID int(255) NOT NULL UNIQUE AUTO_INCREMENT,
			Day int(2) NOT NULL,
			Month int(2) NOT NULL,
			Year int(4) NOT NULL,
			Amount decimal(8,2) NOT NULL,
			Type int(1) NOT NULL,
			Category int(255) NOT NULL,
			LastUpdated timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			Primary Key(PaymentID),
			Foreign Key(Category) REFERENCES paymentCategories(PaymentCategoryID)
		)",

		"CREATE TABLE IF NOT EXISTS companies (
			CompanyID int(255) NOT NULL UNIQUE AUTO_INCREMENT,
			CompanyName varchar(80) NOT NULL,
			LastUpdated timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			Primary Key(CompanyID)
		)",

		"CREATE TABLE IF NOT EXISTS workDone (
			WorkdoneID int(255) NOT NULL UNIQUE AUTO_INCREMENT,
			Day int(2) NOT NULL,
			Month int(2) NOT NULL,
			Year int(4) NOT NULL,
			CompanyID int(255) NOT NULL,
			Hours int(2) NOT NULL,
			Minutes int(2) NOT NULL,
			Wage decimal(8,2) NOT NULL,
			OvertimeHours int(2) NOT NULL,
			OvertimeMinutes int(2) NOT NULL,
			OvertimeWage decimal(8,2) NOT NULL,
			LastUpdated timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			Primary Key(WorkdoneID),
			Foreign Key(CompanyID) REFERENCES companies(CompanyID)
		)"
	);
?>
