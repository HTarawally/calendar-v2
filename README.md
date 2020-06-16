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

<p>
  <img src="../media/home_screenshot.png?raw=true" width="500" />
</p>

From here, clicking on the arrow buttons on the top banner will navigate through
the years of the calendar. Clicking on the year will bring you back to the
calendar view of the current year.

### Adding content

For the real fun, click on month or day value on the calendar to be brought to
a view of that month or day. From there, you can begin to add content to the
calendar.

<p>
  <img src="../media/month_screenshot.png?raw=true" width="500" />
</p>

The simplest content to add is a birthday reminder. Click on the "Birthday"
button to add a birthday. You are then able to enter the person's name and
their date of birth.

<p>
  <img src="../media/birthday_screenshot.png?raw=true" width="500" />
</p>

The next simplest to add would be a generic reminder. Click on the "Reminder"
button to add a generic reminder. You are then able to enter the reminder comment,
the date of the reminder, how often this reminder should occur and optionally
how many times this reminder should be repeated (-1 being infinite).

<p>
  <img src="../media/reminder_screenshot.png?raw=true" width="500" />
</p>

Adding payments and work done is a little bit more involved. First a payment
category or company needs to be created to be able to add payments and work
done respectively. This can be done by clicking the "Payment Category" or
"Company" buttons and entering name of the category or company.

<p>
  <img src="../media/payment_category_screenshot.png?raw=true" width="500" />
</p>

<p>
  <img src="../media/company_screenshot.png?raw=true" width="500" />
</p>

Now you will be able to add a payment by clicking on the "Payment" button and
entering the date of the payment, the amount, whether it was spent or received,
and the category this payment belongs to.

<p>
  <img src="../media/payment_screenshot.png?raw=true" width="500" />
</p>

Adding work done is similar. Click on the "Work Done" button to enter the
date, the company, the number of hours worked and pay per hour, and optionally
any overtime work and wage.

<p>
  <img src="../media/work_done_screenshot.png?raw=true" width="500" />
</p>

### Editing and deleting content

Once added, birthdays and reminders can be easily edited or deleted by clicking
on the "Edit" or "Delete" button next to the birthday or reminder.

To edit or delete a payment, first you would need to drill into the payment
breakdowns by clicking on the "Payment Breakdown" button.

<img src="../media/show_payments_breakdown_screenshot.png?raw=true" width="500" />

A popup will open. Through this popup, a payment can edited or deleted by
clicking on the blue "Edit" or red "Delete" buttons respectively.

Editing or deleting a payment category can be done in a similar fashion. Click
on the "Payment Categories" button and a popup will open where a payment category
can be edited or deleted. Be warned, a payment category cannot be deleted if
there are any payments attached to it.

And lastly, to edit or delete work done, first you would need to drill into
the work done breakdowns by clicking on the "Work Done Breakdown" button.

A popup will open. Through this popup, work done can edited or deleted by
clicking on the blue "Edit" or red "Delete" buttons respectively.

Editing or deleting a company can be done in a similar fashion. Click
on the "Companies" button and a popup will open where a company can be edited
or deleted. Be warned, a company cannot be deleted if there are any work done
attached to it.

### Other navigation

Within the day view, clicking on the date on the top banner will take you to
the month view.

Within the month view, clicking on the month and year on the top banner will
to you to the year view for that month.
