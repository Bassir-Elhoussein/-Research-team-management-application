<?php

namespace WPUM\Composer\Installers;

class PuppetInstaller extends BaseInstaller
{
    protected $locations = array('module' => 'modules/{$name}/');
}
