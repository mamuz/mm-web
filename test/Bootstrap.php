<?php

namespace OverallTest;

use Zend\Loader\AutoloaderFactory;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ArrayUtils;

define('APPLICATION_ENV', 'testing');
error_reporting(E_ALL | E_STRICT);
chdir(__DIR__);

/**
 * Test bootstrap, for setting up autoloading
 */
class Bootstrap
{
    protected static $serviceManager;

    public static function init()
    {
        $config = include __DIR__ . '/../config/application.config.php';

        $zf2ModulePaths = array();

        if (isset($config['module_listener_options']['module_paths'])) {
            $modulePaths = $config['module_listener_options']['module_paths'];
            foreach ($modulePaths as $modulePath) {
                if (($path = static::findParentPath($modulePath))) {
                    $zf2ModulePaths[] = $path;
                }
            }
        }

        static::initAutoloader();

        $baseConfig = array(
            'module_listener_options' => array(
                'module_paths' => $zf2ModulePaths,
            ),
        );

        $config = ArrayUtils::merge($baseConfig, $config);

        $serviceManager = new ServiceManager(new ServiceManagerConfig());
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get('ModuleManager')->loadModules();
        static::$serviceManager = $serviceManager;
    }

    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    protected static function initAutoloader()
    {
        include __DIR__ . '/../init_autoloader.php';

        AutoloaderFactory::factory(
            array(
                'Zend\Loader\StandardAutoloader' => array(
                    'autoregister_zf' => true,
                    'namespaces'      => array(
                        'BaseTest'    => __DIR__ . '/../module/Base/test/BaseTest',
                        'TweakTest'   => __DIR__ . '/../module/W3c/test/W3cTest',
                        'TweakTest'   => __DIR__ . '/../module/Tweak/test/TweakTest',
                        'AnalyzeTest' => __DIR__ . '/../module/Analyze/test/AnalyzeTest',
                    ),
                ),
            )
        );
    }

    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }
        return $dir . '/' . $path;
    }
}

Bootstrap::init();