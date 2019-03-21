<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\doctrine\dbal;

/**
 * Description of Connection
 *
 * @author andreas
 * 
 * @property \Doctrine\DBAL\Connection $wrappedConnection Wrapped Connection
 */
class Connection
        extends \yii\base\BaseObject
        implements \amylian\yii\doctrine\base\common\ConfigurableDoctrineInterface,
        ConfigurableConnectionInterface
{

    use \amylian\yii\doctrine\base\common\ConfigurableDoctrineTrait;

    /**
     * @var string DriverManager Helper Class to use for initiation
     */
    public $driverManagerClass = \Doctrine\DBAL\DriverManager::class;

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $wrappedConnection = null;

    public function __construct(array $configurationArray = [])
    {
        $configurationArray = $this->mergeDefaultConfigurationArray($configurationArray);

        $params = $configurationArray['params'] ?? [];
        unset($configurationArray['params']);

        $configuration = \yii\di\Instance::ensure($configurationArray['configuration'], \Doctrine\DBAL\Configuration::class);
        unset($configurationArray['configuration']);

        $eventManager = \yii\di\Instance::ensure($configurationArray['eventManager'], \Doctrine\Common\EventManager::class);
        unset($configurationArray['eventManager']);

        $this->wrappedConnection = $this->driverManagerClass::getConnection($params, $configuration, $eventManager);

        $this->assignConfigurationAttributesFromArray($configurationArray);
    }

    public function getDefaultConfigurationArray(): array
    {
        return
                [
                    'configuration' => Consts::DEFAULT_CONFIGURATION,
                    'eventManager' => Consts::DEFAULT_EVENT_MANAGER
        ];
    }

    public function getWrappedConnection(): \Doctrine\DBAL\Connection
    {
        return $this->wrappedConnection;
    }

    public function setWrappedConnection(\Doctrine\DBAL\Connection $wrappedConnection)
    {
        $this->wrappedConnection = $wrappedConnection;
    }

    public function beginTransaction()
    {
        return $this->wrappedConnection->beginTransaction();
    }

    public function commit()
    {
        return $this->wrappedConnection->commit();
    }

    public function errorCode()
    {
        return $this->wrappedConnection->errorCode();
    }

    public function errorInfo()
    {
        return $this->wrappedConnection->errorInfo();
    }

    public function exec($statement)
    {
        return $this->wrappedConnection->exec($statement);
    }

    public function lastInsertId($name = null): string
    {
        return $this->wrappedConnection->lastInsertId($name);
    }

    public function prepare($prepareString)
    {
        return $this->wrappedConnection->prepare($prepareString);
    }

    public function query()
    {
        return $this->wrappedConnection->query();
    }

    public function quote($input, $type = ParameterType::STRING)
    {
        return $this->wrappedConnection->quote($input, $type);
    }

    public function rollBack()
    {
        return $this->wrappedConnection->rollBack();
    }

}
