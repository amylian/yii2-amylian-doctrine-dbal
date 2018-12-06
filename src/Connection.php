<?php

/*
 * Copyright 2018 Andreas Prucha, Abexto - Helicon Software Development.
 */

namespace amylian\yii\doctrine\dbal;

/**
 * Description of AbstractConnection
 *
 * @author Andreas Prucha, Abexto - Helicon Software Development
 * 
 * @property \Doctrine\DBAL\Connection $inst Doctrine Connection
 * @property-write bool bool $autoCommit Enable autocommit
 */
class Connection extends BaseConnection
{
    const DEFAULT_REF = Consts::DEFAULT_CONNECTION_REF;
    const DEFAULT_CLASS = Consts::DEFAULT_CONNECTION_CLASS;

    /**
     * @var string Class of the instance to wrap
     */
    public $instClass = null;

    /**
     * @var string|\amylian\yii\doctrine\common\EventManager
     */
    public $eventManager = \amylian\yii\doctrine\common\BaseEventManagerInterface::class;

    /**
     *
     * @var string|BaseConfiguration
     */
    public $configuration = \amylian\yii\doctrine\common\BaseConfigurationInterface::class;
    
    public $connectionParams = [];
    
    /**
     * @var bool Enables autoCommit
     */
    protected $_autoCommit = true;
    
    /**
     * Used Transaction Isolation Level
     * @var int One of the \Doctrine\DBAL\Connection::TRANSACTION_Xxxx constants.
     */
    protected $_transactionIsolation = \Doctrine\DBAL\Connection::TRANSACTION_READ_COMMITTED;

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
        $this->eventManager  = \amylian\yii\doctrine\common\EventManager::ensure($this->eventManager);
        $this->configuration = \amylian\yii\doctrine\dbal\BaseConfiguration::ensure($this->configuration);
    }

    public function getPdo($ensure = true)
    {
        if ($ensure && $this->_pdo !== null) {
            return $this->_pdo = \yii\di\Instance::ensure($this->_pdo);
        } else {
            return $this->_pdo;
        }
    }

    public function setPdo($value)
    {
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

    protected function getInstPropertyMappings()
    {
        return array_merge(parent::getInstPropertyMappings(),
        ['autoCommit' => true,
         'transactionIsolation' => true,
        ]);
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

        $result = \Doctrine\DBAL\DriverManager::getConnection($this->connectionParams, $this->configuration->inst,
                                                              $this->eventManager->inst);

        //
        // Use automatic property setter
        //
        
        $this->setInstProperites($result, $this->getInstPropertyMappings());

        //
        // RETURN the new Instance and ===> EXIT
        //

        return $result;
    }

    public function connect()
    {
        return $this->getInst()->connect();
    }

    public function isConnected()
    {
        return $this->hasInst() && $this->getInst()->isConnected();
    }
    /**
     * {@inheritDoc}
     * NOTE: The returned value is always an object implementing the {@link BaseConnectionInterface}
     * @return BaseConnectionInterface|BaseConnection
     */
    public static function ensure($reference = self::USE_DEFAULT_REF, $type = null, $container = null): \amylian\yii\doctrine\base\common\BaseDoctrineComponentInterface
    {
        $result = parent::ensure($reference, $type, $container);
        if (!$result instanceof BaseConnectionInterface) {
            throw new \yii\base\InvalidValueException(static::class.'::ensure() needs to return an object implementing '.
                    BaseConnectionInterface::class.
                    ' (The object of class '.get_class($result).' does not).');
        }
        return $result;
    }
    
    public function setTransactionIsolation($level)
    {
        $this->_transactionIsolation = $level;
        if ($this->hasInst()) {
            $this->inst->setTransactionIsolation($level);
        }
    }
    
    public function getTransactionIsolation()
    {
        return $this->hasInst() ? $this->inst->getTransactionIsolation() : $this->_transactionIsolation;
    }
    
    public function setAutoCommit($autoCommit)
    {
        $this->_autoCommit = $autoCommit;
        if ($this->hasInst()) {
            $this->inst->setAutoCommit($autoCommit);
        }
    }
    
    public function getAutoCommit()
    {
        return $this->_autoCommit;
    }

}
