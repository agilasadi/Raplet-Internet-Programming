# Raplet-Internet-Programming
Raplet dictionary

Once you clone the project you can run the following command to install all the neccesary packages:

```
composer update

```
Make sure you have composer is installed on your machine.

After that please copy and paste `.env.example` file and rename it as '.env'

Then run the following command to generate app_key

```
php artisan key:generate

```

To set up the database and predefined data, run the following command:

```
php artisan migrate --seed
```

you are all set :)
