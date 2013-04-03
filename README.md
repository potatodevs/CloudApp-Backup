# CloudApp Backup

Simple app written in PHP which allows you to download all your data from [*CloudApp*](http://getcloudapp.com) in one `.zip` file.

## How to Install

1. Deploy all files and folders to webserver
2. Make folders `log`, `generated` and `temp` writable
3. Set up cron task to `/cron.php` (approx. every hour)

## Libraries
- [Nette PHP Framework](http://nette.org)
- [CloudApp API PHP wrapper](https://github.com/matthiasplappert/CloudApp-API-PHP-wrapper)

## Extra Information
- Folder `generated` folder is used for generated .zip user files.
- Folder `log` is used for automatic logging of all errors.
- Folder `temp` is used as a cache for templating system.

## Minimal Requirements
- *PHP >= 5.3* (see more at [http://doc.nette.org/en/requirements](http://doc.nette.org/en/requirements))

## License
See `LICENSE.md`.