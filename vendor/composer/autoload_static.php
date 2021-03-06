<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit69bc54e31ea0d253b17de71b465ca0f5
{
    public static $prefixLengthsPsr4 = array (
        'm' => 
        array (
            'models\\' => 7,
        ),
        'l' => 
        array (
            'lib\\' => 4,
        ),
        'h' => 
        array (
            'hooks\\' => 6,
        ),
        'c' => 
        array (
            'core\\' => 5,
            'controllers\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/models',
        ),
        'lib\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/lib',
        ),
        'hooks\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/hooks',
        ),
        'core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/core',
        ),
        'controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/controllers',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit69bc54e31ea0d253b17de71b465ca0f5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit69bc54e31ea0d253b17de71b465ca0f5::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
