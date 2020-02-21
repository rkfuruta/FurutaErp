<?php
$installer = $this;
$installer->startSetup();
$sql = "
    DROP TABLE IF EXISTS {$this->getTable('furutaerp/log')};
    CREATE TABLE {$this->getTable('furutaerp/log')} (
        `log_id`            int(11) unsigned NOT NULL auto_increment,
        `order_id`          int(11) unsigned NOT NULL,
        `status`            boolean default 0,
        `created_at`        datetime NULL,
        `updated_at`        datetime NULL,
        PRIMARY KEY (`log_id`)    
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

$installer->run($sql);
$installer->endSetup();