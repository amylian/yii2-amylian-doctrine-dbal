<?php

/*
 * Copyright 2018 Andreas Prucha, Abexto - Helicon Software Development.
 */

namespace abexto\amylian\yii\doctrine\dbal;

/**
 * Description of Connection
 *
 * @author Andreas Prucha, Abexto - Helicon Software Development
 */
class Connection extends AbstractConnection
{
    /**
     *
     * @var string|\abexto\amylian\yii\doctrine\common\EventManager 
     */
    protected $_eventManager = 'eventManager';
    
    /**
     *
     * @var string|\abexto\amylian\yii\doctrine\dbal\Configuration
     */
    protected $_configuration = 'configuration';
}
