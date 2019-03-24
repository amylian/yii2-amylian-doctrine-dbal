<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\doctrine\dbal;

/**
 * Description of ConnectionProvider
 *
 * @author andreas
 */
class ConnectionProvider implements ConnectionProviderInterface
{
    use \Amylian\Utils\ṔropertyTrait;
    
    /**
     * @var ConfigurationInterface 
     */
    protected $configuraiton = null;
    
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $actualConnection = null;
    
    /**
     * @var array connection parameters passed to 
     * {@see \Doctrine\DBAL\DriverManager::getConnection()}
     */
    protected $connectionParams = [];
    
    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }
    
    /**
     * Returns the configured connection parameters
     * @return array
     */
    public function getConnectionParams(): array
    {
        return $this->connectionParams;
    }
    
    /**
     * Sets the connection parameters
     * @return array
     */
    public function setConnectionParams(Array $params)
    {
        $this->connectionParams = $params;
    }
    
    /**
     * Creates the actual connection
     * 
     * This function is called by {@seel getActualConnection()} if the
     * connection has not been created yet andreturns the new connection 
     * 
     * @return \Doctrine\DBAL\Connection
     */
    protected function createActualConnection(): \Doctrine\DBAL\Connection
    {
        return \Doctrine\DBAL\DriverManager::getConnection($this->getConnectionParams(), 
                $this->getConfiguration, $eventManager);
    }
    
    public function getActualConnection(): \Doctrine\DBAL\Connection
    {
        if (!$this->$actualConnection) {
            $this->$actualConnection = $this->createActualConnection();
        }
    }
    
    public function getConfiguration(): ConfigurationInterface
    {
        return $this->configuraiton;
    }
    
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }

}
