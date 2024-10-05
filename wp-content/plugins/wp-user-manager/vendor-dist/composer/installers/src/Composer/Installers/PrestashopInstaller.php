<?php

namespace WPUM\Composer\Installers;

class PrestashopInstaller extends BaseInstaller
{
    protected $locations = array('module' => 'modules/{$name}/', 'theme' => 'themes/{$name}/');
}
