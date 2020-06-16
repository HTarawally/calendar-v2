# Calendar V2

<p align="center">
  <img src="../media/app_screenshot.png?raw=true" width="500" />
</p>

## About

A simple organiser system used to track birthdays, reminders, income &
expenditure, and work hours & expected pay, all wrapped up in a simple
calendar format.

## Requirements

PHP version 5.0.0+, compiled with support for the MySQLi extension will be
needed to run the project. MySQL version 4.1.13 or newer is also needed.

As for front-end requirements, any modern browser with JavaScript enabled
will do, including Internet Explore 11+.

## Installation

Clone this repository and upload the contents of the calendar-v2 folder to your
web root.

Open the includes/config.php file with a text editor of your choice.

<p>
  <img src="../media/config_php_screenshot.png?raw=true" width="500" />
</p>

Search for `Config::$DB_NAME` and edit this line to change the database name to
be used for installation. Edit the three lines that follow to complete the
database details setup. Make sure that these details are correct and the
database has already been created in MySQL before proceeding.

Open a web browser and visit the url you uploaded the project to and you will
be redirected to the installation process.

<p>
  <img src="../media/installation_start_screenshot.png?raw=true" width="500" />
</p>

Click the "Start Installation" button to proceed. Once installation is
complete, delete the "install" directory from the project and you are
ready to go.

<p>
  <img src="../media/installation_end_screenshot.png?raw=true" width="500" />
</p>

## Usage

Visiting the home route of the project brings you into the calendar view of
the current year.

From here, clicking on the arrow buttons on the top banner will navigate through
the years of the calendar. Clicking on the year will bring you back to the
calendar view of the current year.

For the real fun, click on month or day value on the calendar to be brought to
a view of that month or day. From there, you can begin to add content to the
calendar.

The simplest content to add is a birthday reminder. Click on the "Birthday"
button to add a birthday. You are then able to enter the person's name and
their date of birth.

The next simplest to add would be a generic reminder. Click on the "Reminder"
button to add a generic reminder. You are then able to enter the reminder comment,
the date of the reminder, how often this reminder should occur and optionally
how many times this reminder should be repeated (-1 being not repeated).

Adding payments and work done is a little bit more involved. First a payment
category or company needs to be created to be able to add payments and work
done respectively. This can be done by clicking the "Payment Category" or
"Company buttons" and entering name of the category or company.

Now you will be able to add a payment by clicking on the "Payment" button and
entering the date of the payment, the amount, whether it was spent or received,
and the category this payment belongs to.

Adding work done is similar. Click on the "Work Done" button to enter the
date, the company, the number of hours worked and pay per hour, and optionally
any overtime work and wage.
