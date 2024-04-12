# KosovaEstate
KosovaEstate is a real estate website where you can buy, sell and rent properties in Kosovo. It's super easy to use, and it's owned by the KosovaEstate company. Whether you're looking for a new place to live or want to sell your property, KosovaEstate has got you covered!
## ORM Implementation Documentation

This document provides guidance on implementing Object-Relational Mapping (ORM) using Eloquent in Laravel for database modeling and migrations.

### Technical Details

- **Technology Stack**: Laravel
- **ORM Framework**: Eloquent - Laravel's built-in ORM that simplifies database interactions with intuitive PHP syntax and seamless relationship management
- **Database Management System**: MySQL

### Tables
  - Users
  - Properties
  - Property Addresses
  - Applications
  - Appointments
  - Reviews
  - FAQs
  
### Development Process Overview

Run the following commands in the terminal to generate models and migrations:
##### Create Models
   `php artisan make:model model_name`
   
   This will create a model in the *server/app/Models* directory.
   
##### Create Migrations   
   `php artisan make:migration migration_name`
   
This will create a migration in the *server/database/migrations* directory
 
 ##### Database Migrations
  After creating your model and migration files and filling them with the neccesary code that corresponds to your table columns, execute the migrations to create the tables in the database:
  
 `php artisan migrate`
 
 ##### Install
If you encounter any errors during model and migration creation, install Laravel Sanctum by running this command, and then repeat the above process.

 `composer require laravel/sanctum`
 
 ##### Make sure the tables have been created 
 Open MySQL Workbench to make sure that your table has been created successfully
 
`USE database server;`

`SELECT * FROM your_table_name;`

## Contributors
- [Anjeza Gashi](https://github.com/anjezagashi)
- [Besmira Berisha](https://github.com/Besmira75)
- [Blerta Azemi](https://github.com/bl3rt4)
- [Dafina Balaj](https://github.com/dafinabalaj)
- [Dafina Sadiku](https://github.com/dafiinaa)
- [Deshira Randobrava](https://github.com/d3shira)
