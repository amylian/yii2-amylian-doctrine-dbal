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
    use Property
    
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $actualConnection = null;
    
    /**
     * @var array connection parameters passed to 
     * {@see \Doctrine\DBAL\DriverManager::getConnection()}
     */
    protected $connectionParams = [];
    
    public function getConnectionParams(): array;
    {
        return $this->connectionParams;
    }
    
    public function setConnectionParams(Array $params)
    {
        $this->connectionParams = $params;
    }
    
    public function getActualConnection(): \Doctrine\DBAL\Connection
    {
        if (!$this->$actualConnection) {
            
        }
    }

}
