<?php

namespace WPUM\Composer\Installers;

class SyliusInstaller extends BaseInstaller
{
    protected $locations = array('theme' => 'themes/{$name}/');
}
