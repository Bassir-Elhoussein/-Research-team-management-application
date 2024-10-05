<?php

namespace WPUM\Composer\Installers;

class DecibelInstaller extends BaseInstaller
{
    /** @var array */
    protected $locations = array('app' => 'app/{$name}/');
}
