<?php

namespace WPUM\Composer\Installers;

class AttogramInstaller extends BaseInstaller
{
    protected $locations = array('module' => 'modules/{$name}/');
}
