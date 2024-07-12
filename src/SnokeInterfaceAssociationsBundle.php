<?php
namespace Snoke\InterfaceAssociations;

use Snoke\InterfaceAssociations\DependencyInjection\Compiler\ConfigurationPass;
use Snoke\InterfaceAssociations\DependencyInjection\Compiler\UninstallPass;
use Snoke\InterfaceAssociations\DependencyInjection\SnokeInterfaceAssociationsExtension;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
class InterfaceAssociations extends Bundle
{

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
        parent::build($container);
        $container->addCompilerPass(new ConfigurationPass());
        $container->addCompilerPass(new UninstallPass(), PassConfig::TYPE_BEFORE_REMOVING);
    }
}