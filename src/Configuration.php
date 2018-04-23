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
{

    /**
     *
     * @var string Class of the instance to wrap
     */
    public $instClass = \Doctrine\DBAL\Configuration::class;
    
    public $resultCache = 'cache';

    public function init()
    {
        parent::init();
    }

    protected function getInstPropertyMappings()
    {
        return array_merge(parent::getInstPropertyMappings(), [
            'resultCache' => 'resultCacheImpl'
        ]);
    }
    
    protected function setInstProperites($inst, $mappings)
    {
        $this->resultCache = $this->resolveReference($this->resultCache);
        parent::setInstProperites($inst, $mappings);
    }

}
