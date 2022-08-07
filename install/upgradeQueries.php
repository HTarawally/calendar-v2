<?php
	$upgradeQueries = array(
		// alters to do with birthdays table
		"ALTER TABLE birthdays Change BirthDayID BirthdayID int(255)",

		"ALTER TABLE birthdays MODIFY PersonName varchar(80)",

		"ALTER TABLE birthdays ADD Year int(4) NOT NULL",

		"ALTER TABLE birthdays RENAME COLUMN lastUpdated to LastUpdated",

		"ALTER TABLE birthdays MODIFY LastUpdated timestamp",

		// alters to do with companies table
		"ALTER TABLE company RENAME TO companies",

		"ALTER TABLE companies MODIFY CompanyName varchar(80)",

		"ALTER TABLE companies RENAME COLUMN lastUpdated to LastUpdated",

		"ALTER TABLE companies MODIFY LastUpdated timestamp",

		// alters to do with the paymentCategories table
		"ALTER TABLE paymentCategories MODIFY Name varchar(80)",

		"ALTER TABLE paymentCategories RENAME COLUMN lastUpdated to LastUpdated",

		"ALTER TABLE paymentCategories MODIFY LastUpdated timestamp",

		// alters to do with the payments table
		"ALTER TABLE payments MODIFY Amount decimal(8,2)",

		"ALTER TABLE payments ADD Foreign Key(Category) REFERENCES paymentCategories(PaymentCategoryID)",

		"ALTER TABLE payments RENAME COLUMN lastUpdated to LastUpdated",

		"ALTER TABLE payments MODIFY LastUpdated timestamp",

		// alters to do with the reminders table
		"ALTER TABLE reminders MODIFY Occurrence int(2)",

		"ALTER TABLE reminders MODIFY Times int(3)",

		"ALTER TABLE reminders RENAME COLUMN lastUpdated to LastUpdated",

		"ALTER TABLE reminders MODIFY LastUpdated timestamp",

		// alters to do with the workdone table
		"ALTER TABLE workdone Change WorkID WorkdoneID int(255)",

		"ALTER TABLE workdone MODIFY Wage decimal(8,2)",

		"ALTER TABLE workdone MODIFY OvertimeWage decimal(8,2)",

		"ALTER TABLE workdone ADD Foreign Key(CompanyID) REFERENCES companies(CompanyID)",

		"ALTER TABLE workdone RENAME COLUMN lastUpdated to LastUpdated",

		"ALTER TABLE workdone MODIFY LastUpdated timestamp",

		// drop tables no longer needed
		"DROP TABLE hourstarget",

		"DROP TABLE wagetarget"
	);
?>
