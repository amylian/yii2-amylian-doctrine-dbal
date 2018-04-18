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
class Configuration extends \abexto\amylian\yii2\doctrine\base\AbstractDoctrineInstWrapperComponent
{

    /**
     *
     * @var string Class of the instance to wrap
     */
    public $instClass = \Doctrine\DBAL\Configuration::class;

}
