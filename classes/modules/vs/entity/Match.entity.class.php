<?php

class PluginVs_ModuleVs_EntityMatch extends EntityORM
{
    protected $aRelations = array(
        'hometeam' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeam', 'home'),
        'awayteam' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeam', 'away'),
        'hometeamtournament' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeamTournament', 'home_teamtournament'),
        'awayteamtournament' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTeamTournament', 'away_teamtournament'),
        'blog' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleBlog_EntityBlog', 'blog_id'),
        'tournament' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityTournament', 'tournament_id'),
        'awayuser' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'away_player'),
        'homeuser' => array(self::RELATION_TYPE_BELONGS_TO, 'ModuleUser_EntityUser', 'home_player'),
        'game' => array(self::RELATION_TYPE_BELONGS_TO, 'PluginVs_ModuleVs_EntityGame', 'game_id')
    );

    public function getLeftGoals()
    {
        $goals = '-';
        if ($this->getGametypeId() == 8 || $this->getGametypeId() == 9) {
            if ($this->getGoalsAway() == 2) $goals = 'W';
            if ($this->getGoalsAway() == 1) $goals = 'T';
            if ($this->getGoalsAway() == 0) $goals = 'L';
        } else {
            $goals = $this->getGoalsAway();
        }
        return $goals;
    }

    public function getRightGoals()
    {
        $goals = '-';
        if ($this->getGametypeId() == 8 || $this->getGametypeId() == 9) {
            if ($this->getGoalsHome() == 2) $goals = 'W';
            if ($this->getGoalsHome() == 1) $goals = 'T';
            if ($this->getGoalsHome() == 0) $goals = 'L';
        } else {
            $goals = $this->getGoalsHome();
        }
        return $goals;
    }

    public function getAdditionalResult()
    {
        $additional = '';

        if ($this->getSo() == 1) $additional = 'SO';
        if ($this->getOt() == 1) $additional = 'ОТ';
        if ($this->getTeh() == 1) $additional = 'тех.';
        if ($this->getKo() == 1) $additional = 'KO';
        if ($this->getTehko() == 1) $additional = 'TKO';
        if ($this->getSubmission() == 1) $additional = 'SUB';
        if ($this->getDecision() == 1) $additional = 'DEC';
        if ($this->getDisqualification() == 1) $additional = 'DSQ';

        return $additional;
    }


}

?>