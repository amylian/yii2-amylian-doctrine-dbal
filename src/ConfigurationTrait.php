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
trait ConfigurationTrait
{

    public function getDefaultConfigurationArray(): array
    {
        return [
            'resultCacheImpl' => \yii\di\Instance::of(Consts::DEFAULT_CACHE)
        ];
    }

}
