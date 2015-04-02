<?php

/**
 * Запрещаем напрямую через браузер обращение к этому файлу.
 */
if (!class_exists('Plugin')) {
    die('Hacking attemp!');
}

class PluginVs extends Plugin
{

    // Объявление делегирований (нужны для того, чтобы назначить свои экшны и шаблоны)
    public $aDelegates = array(/**
     * 'action' => array('ActionIndex'=>'_ActionSomepage'),
     * Замена экшна ActionIndex на ActionSomepage из папки плагина
     *
     * 'template' => array('index.tpl'=>'_my_plugin_index.tpl'),
     * Замена index.tpl из корня скина файлом /common/plugins/abcplugin/templates/skin/default/my_plugin_index.tpl
     *
     * 'template'=>array('actions/ActionIndex/index.tpl'=>'_actions/ActionTest/index.tpl'),
     * Замена index.tpl из скина из папки actions/ActionIndex/ файлом /common/plugins/abcplugin/templates/skin/default/actions/ActionTest/index.tpl
     */


    );

    // Объявление переопределений (модули, мапперы и сущности)
    protected $aInherits
        = array(
            'action' => array(
                'ActionAdmin' => 'PluginVs_ActionAdmin',
            ),
        );

    // Активация плагина
    public function Activate()
    {

        if (!$this->isTableExists('prefix_tablename')) {
            $this->ExportSQL(dirname(__FILE__) . '/install/db/install.sql'); // Если нам надо изменить БД, делаем это здесь.
        }

        return true;
    }

    // Деактивация плагина
    public function Deactivate()
    {
        /*
        $this->ExportSQL(dirname(__FILE__).'/install/db/deinstall.sql'); // Выполнить деактивационный sql, если надо.
        */
        return true;
    }


    // Инициализация плагина
    public function Init()
    {
        E::ModuleViewer()->AppendStyle(Plugin::GetTemplateDir(__CLASS__) . "assets/css/vs.css"); // Добавление своего CSS
        E::ModuleViewer()->AppendScript(Plugin::GetTemplateDir(__CLASS__) . "assets/js/vs.js"); // Добавление своего JS

        //E::ModuleViewer()->AddMenu('blog',Plugin::GetTemplateDir(__CLASS__).'menu.blog.tpl'); // например, задаем свой вид меню
    }
}

?>
