<?php

namespace WPUM\Composer\Installers;

class ReIndexInstaller extends BaseInstaller
{
    protected $locations = array('theme' => 'themes/{$name}/', 'plugin' => 'plugins/{$name}/');
}
