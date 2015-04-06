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

return $config;
