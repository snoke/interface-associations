<?php
namespace Snoke\InterfaceAssociations;

use Snoke\InterfaceAssociations\DependencyInjection\Compiler\ConfigurationPass;
use Snoke\InterfaceAssociations\DependencyInjection\Compiler\UninstallPass;
use Snoke\InterfaceAssociations\DependencyInjection\SnokeInterfaceAssociationsExtension;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
class SnokeInterfaceAssociationsBundle extends Bundle
{
    private function createPackageFile($container): void
    {
        $configFile = $container->getParameter('kernel.project_dir') . '/config/packages/snoke_interface_associations.yaml';

        $bundleConfigFile = __DIR__ . '/Resources/config/snoke_interface_associations.yaml';

        if (!file_exists($configFile)) {
            $defaultConfig = file_get_contents($bundleConfigFile);
            file_put_contents($configFile, $defaultConfig);
        }
    }
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new DependencyInjection\SnokeInterfaceAssociationsExtension();
        }

        return $this->extension;
    }
    public function build(ContainerBuilder $container): void
    {
        $this->createPackageFile($container);
        parent::build($container);

    }
}