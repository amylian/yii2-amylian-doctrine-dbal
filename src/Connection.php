<?php

/*
 * Copyright 2018 Andreas Prucha, Abexto - Helicon Software Development.
 */

namespace abexto\amylian\yii\doctrine\dbal;

/**
 * Description of AbstractConnection
 *
 * @author Andreas Prucha, Abexto - Helicon Software Development
 * 
 * @property \Doctrine\DBAL\Connection $inst 
 */
class Connection extends \abexto\amylian\yii\doctrine\base\AbstractDoctrineInstWrapperComponent
{
    
    /**
     * @var string Class of the instance to wrap
     */
    public $instClass = null;

    /**
     * @var string|\abexto\amylian\yii\doctrine\common\EventManager
     */
    public $eventManager = Doctrine::DEFAULT_EVENTMANAGER_ID;

    /**
     *
     * @var string|Configuration
     */
    public $configuration = Doctrine::DEFAULT_CONFIGURATION_ID;
    
    public $connectionParams = [];
    
    /**
     * Reference to an pdo connection to share
     * 
     * if null, a new connection will be created
     * 
     * @var string|\yii\db\Connection|
     */
    private $_pdo = null;

    public function init()
    {
        parent::init();
        $this->eventManager = $this->resolveReference($this->eventManager);
        $this->configuration = $this->resolveReference($this->configuration);
    }
    
    public function getPdo($ensure = true) {
        if ($ensure && $this->_pdo !== null) {
            return $this->_pdo = \yii\di\Instance::ensure($this->_pdo);
        }
        else {
            return $this->_pdo;
        }
    }
    
    public function setPdo($value) {
        $this->_pdo = $value;
    }
    
    public function getPdoReference()
    {
        $pdo = $this->getPdo();
        if ($pdo instanceof \PDO) {
            return $pdo;
        } elseif ($pdo instanceof \yii\db\Connection) {
            $pdo->open(); // make sure, the conneciton is open
            return $pdo->pdo;
        } else {
            return null;
        }
    }
    
    protected function createNewInst()
    {
        //
        // As we completely rely on Doctrines DriverManager in this case, parent is not called
        // and the method is reintroduced
        // 
        
        if (!isset($this->connectionParams['wrapperClass']) && $this->instClass) {
            $this->connectionParams['wrapperClass'] = $this->instClass;
        }
        
        if ($this->pdo && !isset($this->connectionParams['pdo'])) {
            if (!$this->pdo instanceof \PDO) {
                $this->connectionParams['pdo'] = $this->getPdoReference();
            }
        }
        
        $result = \Doctrine\DBAL\DriverManager::getConnection($this->connectionParams, $this->configuration->inst, $this->eventManager->inst);
        
        //
        // Use automatic property setter
        //
        
        $this->setInstProperites($result);
        
        //
        // RETURN the new Instance and ===> EXIT
        //

        return $result;
    }

}
