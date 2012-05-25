# cloudapp-exporter

## Install instructions

1. Copy all files and folders to FTP
2. Make folders "log" and "generated" writable (chmod 777)
3. Set up cron task to /cron.php (aprox. every hour)
4. In file "index.php" on line 84 update url to root folder of the app

## Some extra info

/generated folder is used for generated .zip user files.

/log folder is used for for any errors that we may come across.