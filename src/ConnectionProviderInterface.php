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
interface ConnectionProviderInterface
{
    /**
     * Creates the actual connection and returns it
     * 
     * @return \Doctrine\DBAL\Connection
     */
    public function getActualConnection(): \Doctrine\DBAL\Connection;
}
