<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace amylian\yii\doctrine\dbal;

/**
 *
 * @author andreas
 */
interface ConnectionInterface extends \Doctrine\DBAL\Driver\Connection
{ 
    public function getWrappedConnection(): \Doctrine\DBAL\Connection;
}
