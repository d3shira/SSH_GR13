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
  - Applications
  - Appointments
  - Reviews
  - FAQs
  - Properties_type
  - Abilities
  - Addresses
  - Contract_type
  - Contract
  - Features
  - Images
  - Messages
  - Owners
  - Rating
  - Role
  - Role_ability
  - Sales_Agents
  
  
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

## Installation and Usage
### Requirements
- Vue 
- Laravel

#### Dependencies
##### Client Side
Open your terminal and run the following commands to install the necessary client-side dependencies:
  
  `npm install vue-router@4`
  
  `npm install primevue`
  
  `npm install primeicons`
  
  `npm install primeflex`

  `npm install chart.js`
  
##### Server Side

Open your terminal and run the following commands to install the necessary server-side dependencies:
 
  `composer require tymon/jwt-auth`
  
  `php artisan jwt:secret`
  
  `composer require laravel/tinker`
  
  `npm install axios --save`
  
  `composer require laravel/sanctum`
  
 
 ### Steps
1. Clone this repository
2. Make sure you install the dependencies listed above

### Usage
   
#### Client Side

Navigate to the client folder: 

`cd client`

Start the client: 

`npm run dev`

#### Server Side

Navigate to the server folder:

`cd server`

Seed the database:

`php artisan db:seed`

Start the server:

`php artisan serve`

## Additional Notes

- Ensure you have the correct versions of Node.js and Composer installed.
- The `php artisan jwt:secret` command generates a secret key for JWT authentication, which is crucial for security.
- Make sure your .env file is properly configured for your database and other settings.
- Run `php artisan migrate` before `php artisan db:seed` if your database needs migrations.

## Contributors
- [Anjeza Gashi](https://github.com/anjezagashi)
- [Besmira Berisha](https://github.com/Besmira75)
- [Blerta Azemi](https://github.com/bl3rt4)
- [Dafina Balaj](https://github.com/dafinabalaj)
- [Dafina Sadiku](https://github.com/dafiinaa)
- [Deshira Randobrava](https://github.com/d3shira)
