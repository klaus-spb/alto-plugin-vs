<?php
/**
 * Конфиг
 */

$config = array();

// Переопределить имеющуюся переменную в конфиге:
// Переопределение роутера на наш новый Action - добавляем свой урл  http://domain.com/vs
// Config::Set('router.page.vs', 'PluginVs_ActionVs');

// Добавить новую переменную:
// $config['per_page'] = 15;
// Эта переменная будет доступна в плагине как Config::Get('plugin.vs.per_page')

$config['tables_can_be_configured'] = array('tournament', 'player_card', 'tournament_stat', 'player_stat');

$config['super_admins'] = array(1);

$config['field_types'] = array(
    'tinyint' => 'tinyint(1)',
    'int' => 'int(11)',
    'float' => 'float(7,3)',
    'varchar' => 'int(255)',
    'date' => 'date',
    'datetime' => 'datetime',
);

$config['tournament_logo'] = array(
    '$extends$' => '___module.uploader.images.default___',
    'size' => array('large' => '200x200crop', 'medium' => '64x64crop', 'small' => '32x32crop', 'very_small' => '20x20crop'),
    'transform' => array(
        'max_width' => 250,
        'max_height' => 250,
        'aspect_ratio' => '1',
        'watermark' => array(
            'enable' => false,
        ),
        '@mime(gif)' => array(
            'animation' => true,
        ),
    ),
);

return $config;
