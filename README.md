# cloudapp-exporter

## Install instructions

~ Copy all files and folders to FTP
~ Make folders "log" and "generated" writable (chmod 777)
~ Set up cron task to /cron.php (aprox. every hour)
~ In file "index.php" on line 84 update url to root folder of the app

## Some extra info

/generated folder is used for generated .zip user files.

/log folder is used for for any errors that we may come across.