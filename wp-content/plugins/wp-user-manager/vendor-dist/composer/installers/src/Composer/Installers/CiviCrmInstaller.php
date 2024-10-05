<?php

namespace WPUM\Composer\Installers;

class CiviCrmInstaller extends BaseInstaller
{
    protected $locations = array('ext' => 'ext/{$name}/');
}
