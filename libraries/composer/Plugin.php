<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace dee\composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;


/**
 * Plugin is the composer plugin that registers the Yii composer installer.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Plugin implements PluginInterface
{
    /**
     * @inheritdoc
     */
    public function activate(Composer $composer, IOInterface $io)
    {
//        $installer = new Installer($io, $composer);
//        $composer->getInstallationManager()->addInstaller($installer);
//        $file = rtrim($composer->getConfig()->get('vendor-dir'), '/') . '/yiisoft/extensions.php';
//        if (!is_file($file)) {
//            @mkdir(dirname($file), 0777, true);
//            file_put_contents($file, "<?php\n\nreturn [];\n");
//        }
        $composer->getEventDispatcher()->addSubscriber(new Subscriber());
    }
}
