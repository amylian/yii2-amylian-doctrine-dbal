<?php

/*
 * BSD 3-Clause License
 * 
 * Copyright (c) 2018, Abexto - Helicon Software Development / Amylian Project
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 
 * * Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 * 
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 * 
 * * Neither the name of the copyright holder nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 */

namespace abexto\amylian\yii\dbal\tests\units;

/**
 * Description of ConnectionTestCase
 *
 * @author Andreas Prucha, Abexto - Helicon Software Development
 */
class ConnectionTest extends \abexto\amylian\yii\phpunit\AbstractYiiTestCase
{

    public function testGetConnectionInst()
    {
        static::mockYiiConsoleApplication([
            'bootstrap'  => [
                [
                    'class' => \abexto\amylian\yii\doctrine\common\PackageBootstrap::class
                ],
                [
                    'class' => \abexto\amylian\yii\doctrine\cache\PackageBootstrap::class
                ],
                [
                    'class' => \abexto\amylian\yii\doctrine\dbal\PackageBootstrap::class
                ],
            ],
            'components' => [
                'cache' => ['class' => \yii\caching\ArrayCache::class]
            ],
            'container'  => [
                'singletons' => [
                    \abexto\amylian\yii\doctrine\dbal\ConnectionInterface::class => [
                        'class'            => \abexto\amylian\yii\doctrine\dbal\Connection::class,
                        'connectionParams' => [
                            'dbname'   => $_ENV['db_name'],
                            'user'     => $_ENV['db_username'],
                            'password' => $_ENV['db_password'],
                            'host'     => $_ENV['db_host'],
                            'driver'   => 'pdo_' . $_ENV['db_type']
                        ]
                    ]
                ]
            ]
        ]);

        $connection = \abexto\amylian\yii\doctrine\base\InstanceManager::ensure(\abexto\amylian\yii\doctrine\dbal\ConnectionInterface::class);
        $this->assertInstanceOf(\Doctrine\DBAL\Connection::class, $connection->inst);
        $connection->inst->connect();
        $this->assertTrue($connection->inst->isConnected());
    }

    public function testGetConnectionYiiDbPdoResulse()
    {
        static::mockYiiConsoleApplication(['components' => [
                'cache' => ['class' => \yii\caching\ArrayCache::class],
                'db'    => [
                    'class'    => \yii\db\Connection::class,
                    'dsn'      => $_ENV['db_type'] . ':host=' . $_ENV['db_host'] . ';dbname=' . $_ENV['db_name'],
                    'username' => $_ENV['db_username'],
                    'password' => $_ENV['db_password']
                ],
            ],
            'container'  => [
                'singletons' => [
                    \abexto\amylian\yii\doctrine\dbal\ConnectionInterface::class => [
                        'class' => \abexto\amylian\yii\doctrine\dbal\Connection::class,
                        'pdo'   => 'db',
                    ]
                ]
            ]
        ]);
        $connection = \abexto\amylian\yii\doctrine\dbal\Connection::ensure([]);
        $this->assertInstanceOf(\Doctrine\DBAL\Connection::class, $connection->inst);
        $connection->inst->connect();
        $this->assertTrue($connection->inst->isConnected());
    }

    public function testDIInjection()
    {
        static::mockYiiConsoleApplication(['components' => [
                'cache' => ['class' => \yii\caching\ArrayCache::class],
                'db'    => [
                    'class'    => \yii\db\Connection::class,
                    'dsn'      => $_ENV['db_type'] . ':host=' . $_ENV['db_host'] . ';dbname=' . $_ENV['db_name'],
                    'username' => $_ENV['db_username'],
                    'password' => $_ENV['db_password']
                ],
            ],
            'container'  => [
                'singletons' => [
                    \abexto\amylian\yii\doctrine\dbal\ConnectionInterface::class => [
                        'class' => \abexto\amylian\yii\doctrine\dbal\Connection::class,
                        'pdo'   => 'db',
                    ]
                ]
            ]
        ]);
        
        $diTester = \Yii::createObject(\abexto\amylian\yii\doctrine\dbal\tests\classes\TestDIInjection::class);
        $this->assertSame(\yii\di\Instance::ensure(\abexto\amylian\yii\doctrine\dbal\ConnectionInterface::class), $diTester->gotConnection);
    }

}
