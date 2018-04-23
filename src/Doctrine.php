<?php

/*
 * Copyright 2018 Andreas Prucha, Abexto - Helicon Software Development.
 */

namespace abexto\amylian\yii\doctrine\dbal;

/**
 * Description of Doctrine
 *
 * @author Andreas Prucha, Abexto - Helicon Software Development
 */
class Doctrine extends \abexto\amylian\yii\doctrine\base\Doctrine
{
    
    const DEFAULT_QUERYCACHE_ID = 'queryCache';
    const DEFAULT_CONFIGURATION_ID = 'configuration';
    const DEFAULT_CONNECTION_ID = 'connection';
    const DEFAULT_EVENTMANAGER_ID = 'eventManager';

    public function init()
    {
        parent::init();
        if (!$this->has(self::DEFAULT_QUERYCACHE_ID, false)) {
            $this->set(self::DEFAULT_QUERYCACHE_ID, ['class' => \abexto\amylian\yii\doctrine\cache\YiiCache::class]);
        }
        if (!$this->has(self::DEFAULT_EVENTMANAGER_ID, false)) {
            $this->set(self::DEFAULT_EVENTMANAGER_ID, ['class' => \abexto\amylian\yii\doctrine\common\EventManager::class]);
        }
        if (!$this->has(self::DEFAULT_CONFIGURATION_ID, false)) {
            $this->set(self::DEFAULT_CONFIGURATION_ID, ['class' => \abexto\amylian\yii\doctrine\dbal\Configuration::class]);
        }
        if (!$this->has(self::DEFAULT_CONNECTION_ID, false)) {
            $this->set(self::DEFAULT_CONNECTION_ID, ['class' => \abexto\amylian\yii\doctrine\dbal\Configuration::class]);
        }
    }

    /**
     * 
     * @param string $connectionId
     * @return \abexto\amylian\yii\doctrine\dbal\Connection
     */
    public function getConnection($connectionId = 'connection'): Connection
    {
        return $this->resolveReference($connectionId);
    }

}
