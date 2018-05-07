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
class Configuration extends \abexto\amylian\yii\doctrine\base\AbstractDoctrineInstWrapperComponent
        implements \abexto\amylian\yii\doctrine\common\ConfigurationInterface
{

    /**
     *
     * @var string Class of the instance to wrap
     */
    public $instClass = \Doctrine\DBAL\Configuration::class;
    public $resultCache = \abexto\amylian\yii\doctrine\cache\AbstractCache::class;

    public function init()
    {
        parent::init();
        $this->resultCache = \abexto\amylian\yii\doctrine\cache\AbstractCache::ensure($this->resultCache);
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
