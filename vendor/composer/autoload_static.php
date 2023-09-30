<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit360f0cf16a244a7a29f56115bd088d99
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit360f0cf16a244a7a29f56115bd088d99::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit360f0cf16a244a7a29f56115bd088d99::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit360f0cf16a244a7a29f56115bd088d99::$classMap;

        }, null, ClassLoader::class);
    }
}