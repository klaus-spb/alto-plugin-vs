<?php

class PluginVs_HookVs extends Hook
{

    /*
     * Регистрация событий на хуки
     */
    public function RegisterHook()
    {
        $this->AddHook('template_admin_menu_content', 'hook_admin_menu');
    }

    public function hook_admin_menu()
    {
        return $this->Viewer_Fetch(Plugin::GetTemplateDir(__CLASS__) . 'tpls/admin_menu.tpl');
    }
}

// EOF
