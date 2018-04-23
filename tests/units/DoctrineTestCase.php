<?php

/*
 * Copyright 2018 Andreas Prucha, Abexto - Helicon Software Development.
 */

namespace abexto\amylian\yii\dbal\tests\units;

/**
 * Description of Doctrine
 *
 * @author Andreas Prucha, Abexto - Helicon Software Development
 */
class DoctrineTestCase extends \abexto\amylian\yii\phpunit\AbstractYiiTestCase
{

    public function testdoctrineComponentExists()
    {
        static::mockYiiConsoleApplication(['components' => [
                'cache' => ['class' => \yii\caching\ArrayCache::class],
                'dc' => [
                    'class' => \abexto\amylian\yii\doctrine\dbal\Doctrine::class
                ]
        ]]);
        $this->assertInstanceOf(\abexto\amylian\yii\doctrine\dbal\Doctrine::class, \Yii::$app->dc);
    }

    public function testGetEventManager()
    {
        static::mockYiiConsoleApplication(['components' => [
                'cache' => ['class' => \yii\caching\ArrayCache::class],
                'dc' => [
                    'class'      => \abexto\amylian\yii\doctrine\dbal\Doctrine::class,
                    'components' => [
                        'testConnection' => [
                            'class' => \abexto\amylian\yii\doctrine\dbal\Connection::class
                        ]
                    ]
                ]
        ]]);
        $this->assertInstanceOf(\abexto\amylian\yii\doctrine\common\EventManager::class, \Yii::$app->dc->get('eventManager'));
    }

    public function testGetConnection()
    {
        static::mockYiiConsoleApplication(['components' => [
                'cache' => ['class' => \yii\caching\ArrayCache::class],
                'dc' => [
                    'class'      => \abexto\amylian\yii\doctrine\dbal\Doctrine::class,
                    'components' => [
                        'testConnection' => [
                            'class' => \abexto\amylian\yii\doctrine\dbal\Connection::class
                        ]
                    ]
                ]
        ]]);
        $this->assertInstanceOf(\abexto\amylian\yii\doctrine\dbal\Connection::class, \Yii::$app->dc->getConnection('testConnection'));
    }

    public function testGetConnectionInst()
    {
        static::mockYiiConsoleApplication(['components' => [
                'cache' => ['class' => \yii\caching\ArrayCache::class],
                'dc' => [
                    'class'      => \abexto\amylian\yii\doctrine\dbal\Doctrine::class,
                    'components' => [
                        'testConnection' => [
                            'class'            => \abexto\amylian\yii\doctrine\dbal\Connection::class,
                            'connectionParams' => [
                                'dbname'   => $_ENV['db_name'],
                                'user'     => $_ENV['db_username'],
                                'password' => $_ENV['db_password'],
                                'host'     => $_ENV['db_host'],
                                'driver'   => 'pdo_'.$_ENV['db_type']
                            ]
                        ]
                    ]
                ]
        ]]);
        $this->assertInstanceOf(\Doctrine\DBAL\Connection::class, \Yii::$app->dc->getConnection('testConnection')->inst);
        \Yii::$app->dc->getConnection('testConnection')->inst->connect();
        $this->assertTrue(\Yii::$app->dc->getConnection('testConnection')->inst->isConnected());
    }
    
    public function testGetConnectionYiiDbPdoResulse()
    {
        static::mockYiiConsoleApplication(['components' => [
                'cache' => ['class' => \yii\caching\ArrayCache::class],
                'db' => [
                    'class' => \yii\db\Connection::class,
                    'dsn' => $_ENV['db_type'].':host='.$_ENV['db_host'].';dbname='.$_ENV['db_name'],
                    'username' => $_ENV['db_username'],
                    'password' => $_ENV['db_password']
                ],
                'dc' => [
                    'class'      => \abexto\amylian\yii\doctrine\dbal\Doctrine::class,
                    'components' => [
                        'testConnection' => [
                            'class'            => \abexto\amylian\yii\doctrine\dbal\Connection::class,
                            'pdo' => 'db'
                        ]
                    ]
                ]
        ]]);
        $this->assertInstanceOf(\Doctrine\DBAL\Connection::class, \Yii::$app->dc->getConnection('testConnection')->inst);
        $this->assertTrue(\Yii::$app->dc->getConnection('testConnection')->inst->isConnected());
    }
    

}
