<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc13fcf194f1a754bc414f99850c871fd
{
    public static $files = array (
        'b0f9086f37950ee3e9e1e3db11f150ed' => __DIR__ . '/../..' . '/inc/template-hooks.php',
        '93d32fb9b6ae2d1c74e70bd1d0bca607' => __DIR__ . '/../..' . '/inc/template-functions.php',
        'cc571befa6401a4e9fdb9d852b3944ed' => __DIR__ . '/../..' . '/inc/helper-functions.php',
        '0b76e9233c78e28061f00e6599863f2b' => __DIR__ . '/../..' . '/inc/template-categories.php',
        '43fb782ccfe47ae859c7efca19e8d6c9' => __DIR__ . '/../..' . '/inc/template-tags.php',
        'a86ce7059eec0063356624bf624dee73' => __DIR__ . '/../..' . '/inc/themeOptionHelper.php',
        'f312129e76be1577e23238688a61993e' => __DIR__ . '/../..' . '/inc/themeCustomFunctions.php',
        '66eaadefff4dd25bfa4676841aa62d94' => __DIR__ . '/../..' . '/inc/breadcrumb.php',
    );

    public static $classMap = array (
        'Framework\\App\\Admin' => __DIR__ . '/../..' . '/app/Admin.php',
        'Framework\\App\\Cartsy' => __DIR__ . '/../..' . '/app/Cartsy.php',
        'Framework\\App\\CartsyCustomNavMenuWalker' => __DIR__ . '/../..' . '/app/MenuWalker.php',
        'Framework\\App\\CartsyCutomPageWalker' => __DIR__ . '/../..' . '/app/PageWalker.php',
        'Framework\\App\\CartsyMobileNavWalker' => __DIR__ . '/../..' . '/app/MobileMenuWalker.php',
        'Framework\\App\\Customizer' => __DIR__ . '/../..' . '/app/Customizer.php',
        'Framework\\App\\Importer' => __DIR__ . '/../..' . '/app/Importer.php',
        'Framework\\App\\Jetpack' => __DIR__ . '/../..' . '/app/Jetpack.php',
        'Framework\\App\\Plugin' => __DIR__ . '/../..' . '/app/Plugin.php',
        'Framework\\App\\ProductAdjacent' => __DIR__ . '/../..' . '/app/ProductAdjacent.php',
        'Framework\\App\\RecentlyViewedProduct' => __DIR__ . '/../..' . '/app/RecentlyViewedProduct.php',
        'Framework\\App\\Script' => __DIR__ . '/../..' . '/app/Script.php',
        'Framework\\App\\Sidebar' => __DIR__ . '/../..' . '/app/Sidebar.php',
        'Framework\\App\\WooCommerceLoad' => __DIR__ . '/../..' . '/app/WooCommerceLoad.php',
        'Framework\\App\\WooCommerceSingleLoad' => __DIR__ . '/../..' . '/app/WooCommerceSingleLoad.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitc13fcf194f1a754bc414f99850c871fd::$classMap;

        }, null, ClassLoader::class);
    }
}
