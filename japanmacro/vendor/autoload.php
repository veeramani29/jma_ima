<?php
// autoload.php @generated by Composer
define("MailGunAPI", Config::read('MailGunConfig.'.Config::read('environment').'.MailGunAPI'));
define("MailGunDomain", Config::read('MailGunConfig.'.Config::read('environment').'.MailGunDomain'));
define("FromInfoMail", Config::read('MailGunConfig.'.Config::read('environment').'.FromInfoMail'));
define("JmaDevTeam", Config::read('MailGunConfig.'.Config::read('environment').'.JmaDevTeam'));
define("MailGunListAddress", Config::read('MailGunConfig.'.Config::read('environment').'.MailGunListAddress'));

require_once __DIR__ . '/composer' . '/autoload_real.php';

return ComposerAutoloaderInit98ec2f098cb44c387bd7848f6b063241::getLoader();
