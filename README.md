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
