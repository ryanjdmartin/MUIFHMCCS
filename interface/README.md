MUIFHMCCS
=========

All Laravel files go in the "laravel" folder. Set up your apache document root to point to the "laravel" folder and you should have a working, version controlled website (you'll have to migrate the database, see [this guide](http://laravelbook.com/laravel-migrations-managing-databases/)).

All other non laravel stuff can go here in this folder, such as documentation.

Starting the database?
    -See laravel/app/config/dbatabase.php for the database name, user and password. 
    -Create a database with that name, create a mysql user, and give him read/write permissions on that database. You only need to do this once
    -Change into laravel directory
    -Make sure you can run `php artisan`
    -Run `php artisan migrate` to build the database
    -Run `php artisan db:seed` to get default user and sample data

Updating the database: just run `php artisan migrate` to get the latest changes. No need to seed, unless you want to wipe all data.
