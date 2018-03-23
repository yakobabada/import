# CSV Import

## Introduction

- The application was created from scratch and structured using command and frontController design pattern.
- program should run once per minute using a system crontab . When run, it should
  discover any CSV files in the “uploaded” directory, parse the rows in the file, insert their contents
  into a MySQL database, and then move each CSV file to the “processed” directory.

## Requirement:

PHP 7, mysql 5.7

## Download and Installation

- `git clone https://github.com/yakobabada/import.git`
- `cd import/`
- Create database `infinity` and update connection parameters in `Config/database.php` file.
- Import into your database schema from `infinity.sql`.

## Start import CSVs

- Run the command in the directory 
  - `php index.php importFile`
  
## Log file

- Log file is in `log/infinity/error.log`
- preferred to move it into `/var/log`. Update the configuration in `Config/default.php`