<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit55178bbf22fddd9fda1946bc0519036e
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PhpOffice\\PhpWord\\' => 18,
        ),
        'L' => 
        array (
            'Laminas\\Escaper\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PhpOffice\\PhpWord\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoffice/phpword/src/PhpWord',
        ),
        'Laminas\\Escaper\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-escaper/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit55178bbf22fddd9fda1946bc0519036e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit55178bbf22fddd9fda1946bc0519036e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit55178bbf22fddd9fda1946bc0519036e::$classMap;

        }, null, ClassLoader::class);
    }
}
