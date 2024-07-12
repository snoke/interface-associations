<?php
namespace Snoke\InterfaceAssociations\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
class ConfigurationPass implements CompilerPassInterface
{

    private function createPackageFile($container): void
    {
        $configFile = $container->getParameter('kernel.project_dir') . '/config/packages/snoke_interface_associations.yaml';

        $bundleConfigFile = __DIR__ . '/../../Resources/config/snoke_interface_associations.yaml';

        if (!file_exists($configFile)) {
            $defaultConfig = file_get_contents($bundleConfigFile);
            file_put_contents($configFile, $defaultConfig);
        }
    }

    public function process(ContainerBuilder $container)
    {
        $this->createPackageFile($container);
    }
}
