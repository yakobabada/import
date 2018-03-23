#CSV Import

##Introduction

- The application was created from scratch and structured using command and frontController design pattern.
- program should run once per minute using a system crontab . When run, it should
  discover any CSV files in the “uploaded” directory, parse the rows in the file, insert their contents
  into a MySQL database, and then move each CSV file to the “processed” directory.

## Requirement:

PHP 7, mysql 5.7

##Download and Installation

- using github to projects directory
  - `git clone https://github.com/yakobabada/import.git`
  - `cd import/`

- create database `infinity` and update connection parameters in `config/database.php` file.
- import into your database using `infinity.sql`.

##Start import CSVs

- Run the command in the directory 
  - `php index.php importFile`