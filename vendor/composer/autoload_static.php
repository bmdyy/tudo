<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitcb10d081ed2a87e441496d59e96ca6f9
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Config_File' => __DIR__ . '/..' . '/smarty/smarty/libs/Config_File.class.php',
        'Smarty' => __DIR__ . '/..' . '/smarty/smarty/libs/Smarty.class.php',
        'Smarty_Compiler' => __DIR__ . '/..' . '/smarty/smarty/libs/Smarty_Compiler.class.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitcb10d081ed2a87e441496d59e96ca6f9::$classMap;

        }, null, ClassLoader::class);
    }
}
