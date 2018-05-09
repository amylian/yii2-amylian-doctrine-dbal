<?php

/*
 * Copyright 2018 Andreas Prucha, Abexto - Helicon Software Development.
 */

namespace abexto\amylian\yii\doctrine\dbal;

/**
 * Description of Configuration
 *
 * @author Andreas Prucha, Abexto - Helicon Software Development
 */
class BaseConfiguration extends \abexto\amylian\yii\doctrine\common\BaseConfiguration
{
    const DEFAULT_REF = Consts::DEFAULT_CONFIGURATION_REF;
    const DEFAULT_CLASS = Consts::DEFAULT_CONFIGURATION_CLASS;
    /**
     *
     * @var string Class of the instance to wrap
     */
    public $instClass = \Doctrine\DBAL\Configuration::class;
    /**
     * Used Cache Interface
     * @var string|\abexto\amylian\yii\doctrine\cache\CacheInterface|\abexto\amylian\yii\doctrine\cache\BaseCache
     */
    public $resultCache = \abexto\amylian\yii\doctrine\cache\BaseCacheInterface::class;

    public function init()
    {
        parent::init();
        $this->resultCache = \abexto\amylian\yii\doctrine\cache\BaseCache::ensure($this->resultCache);
    }

    protected function getInstPropertyMappings()
    {
        return array_merge(parent::getInstPropertyMappings(), [
            'resultCache' => true
        ]);
    }

    public function setInstPropertyResultCache($value, $inst = null)
    {
        $inst->setResultCacheImpl($value->inst);
    }

}
