# CloudApp-Exporter

Simple app which allows you to download all your data from CloudApp in one .zip file.

## Install Instructions

1. Copy all files and folders to FTP
2. Make folders "log", "generated" and "temp" an writable (chmod 0777)
3. Set up cron task to /cron.php (aprox. every hour)

## Extra Information

- "generated" folder is used for generated .zip user files.
- "log" folder is used for automatic logging of all errors.
- "temp" folder is as a cache for templating system.