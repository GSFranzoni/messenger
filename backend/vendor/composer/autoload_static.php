<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb3bbd66a85089f2f3661c4df6615ef37
{
    public static $files = array (
        '7b11c4dc42b3b3023073cb14e519683c' => __DIR__ . '/..' . '/ralouphie/getallheaders/src/getallheaders.php',
        '253c157292f75eb38082b5acb06f3f01' => __DIR__ . '/..' . '/nikic/fast-route/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Workerman\\' => 10,
        ),
        'T' => 
        array (
            'Tuupola\\Middleware\\' => 19,
            'Tuupola\\Http\\Factory\\' => 21,
        ),
        'S' => 
        array (
            'Slim\\Tests\\' => 11,
            'Slim\\Psr7\\' => 10,
            'Slim\\' => 5,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Http\\Server\\' => 16,
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Container\\' => 14,
            'PHPSocketIO\\' => 12,
        ),
        'N' => 
        array (
            'Neomerx\\Cors\\' => 13,
        ),
        'F' => 
        array (
            'Fig\\Http\\Message\\' => 17,
            'FastRoute\\' => 10,
        ),
        'E' => 
        array (
            'ElephantIO\\' => 11,
        ),
        'C' => 
        array (
            'Channel\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Workerman\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/workerman',
        ),
        'Tuupola\\Middleware\\' => 
        array (
            0 => __DIR__ . '/..' . '/tuupola/callable-handler/src',
            1 => __DIR__ . '/..' . '/tuupola/cors-middleware/src',
        ),
        'Tuupola\\Http\\Factory\\' => 
        array (
            0 => __DIR__ . '/..' . '/tuupola/http-factory/src',
        ),
        'Slim\\Tests\\' => 
        array (
            0 => __DIR__ . '/..' . '/slim/slim/tests',
        ),
        'Slim\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/slim/psr7/src',
        ),
        'Slim\\' => 
        array (
            0 => __DIR__ . '/..' . '/slim/slim/Slim',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Http\\Server\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-server-handler/src',
            1 => __DIR__ . '/..' . '/psr/http-server-middleware/src',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-factory/src',
            1 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'PHPSocketIO\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/phpsocket.io/src',
        ),
        'Neomerx\\Cors\\' => 
        array (
            0 => __DIR__ . '/..' . '/neomerx/cors-psr7/src',
        ),
        'Fig\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/fig/http-message-util/src',
        ),
        'FastRoute\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/fast-route/src',
        ),
        'ElephantIO\\' => 
        array (
            0 => __DIR__ . '/..' . '/wisembly/elephant.io/src',
            1 => __DIR__ . '/..' . '/wisembly/elephant.io/test',
        ),
        'Channel\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/channel/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb3bbd66a85089f2f3661c4df6615ef37::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb3bbd66a85089f2f3661c4df6615ef37::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
