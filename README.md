To setup this project you need:

- to have a virtual host;
- to update the composer (it can be done through the terminal with “composer update”) which will create a “vendor” folder and should go inside the “www” folder;
- the database file is in “www/assets/working_files/organ_admin.sql”;
- you also need apache2 web server, php7, PDO module, and mod_rewrite module;
- you need to change the database connection in the config.php (in “www” folder);

the login to the cms: ana
the pass to the cms: 111

To see the database you can use hostname/adminer.php (easier to navigate than via phpMyAdmin).

For developing, you would need to install Gulp, npm.
