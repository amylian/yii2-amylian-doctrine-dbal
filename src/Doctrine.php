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
class Doctrine extends \abexto\amylian\yii2\doctrine\base\Doctrine
{

    public function init()
    {
        parent::init();
        if (!$this->has('eventManager', false)) {
            $this->set('eventManager', ['class' => \abexto\amylian\yii\doctrine\common\EventManager::class]);
        }
        if (!$this->has('configuration', false)) {
            $this->set('configuration', ['class' => \abexto\amylian\yii\doctrine\dbal\Configuration::class]);
        }
        if (!$this->has('connection', false)) {
            $this->set('connection', ['class' => \abexto\amylian\yii\doctrine\dbal\Configuration::class]);
        }
    }

}
