<?php

declare(strict_types=1);

if (!file_exists(__DIR__.'/vendor/autoload.php')) {
    throw new Exception(sprintf(
        'Could not find composer autoload file %s. Did you run `composer update` in %s?',
        __DIR__.'/vendor/autoload.php',
        __DIR__
    ));
}

require_once __DIR__.'/vendor/autoload.php';

use pointybeard\Symphony\Extended;

// This file is included automatically in the composer autoloader, however,
// Symphony might try to include it again which would cause a fatal error.
// Check if the class already exists before declaring it again.
if (!class_exists('\\Extension_OrderID_Field')) {
    class Extension_Unique_Order_Identifier_Field extends Extended\AbstractExtension
    {
        public function uninstall(): bool
        {
            Symphony::Database()->query('DROP TABLE `tbl_fields_uniqueorderidentifier`');
        }

        public function install(): bool
        {
            return Symphony::Database()->query(
            "CREATE TABLE `tbl_fields_uniqueorderidentifier` (
                `id` int(11) unsigned NOT NULL auto_increment,
                `field_id` int(11) unsigned NOT NULL,
                `prefix` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
                `sequence_length` int(1) unsigned NOT NULL,,
                `enable_rand` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
                `enable_checksum` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
                PRIMARY KEY  (`id`),
                UNIQUE KEY `field_id` (`field_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
        );
        }
    }
}
