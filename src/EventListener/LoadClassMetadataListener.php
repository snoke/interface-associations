<?php
namespace Snoke\InterfaceAssociations\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\AssociationMapping;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
#[AsDoctrineListener(event: Events::loadClassMetadata, priority: 500, connection: 'default')]
class LoadClassMetadataListener
{
    private array $parameters;
    public function __construct(private readonly EntityManagerInterface $em, ParameterBagInterface $parameterBag)
    {
        $this->parameters = $parameterBag->get('snoke_interface_associations');

    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args): void
    {
        $metadata = $args->getClassMetadata();
        foreach ($metadata->associationMappings as $field => $mapping) {
            $mappings = array_filter($this->parameters['remap'], function ($newMapping) use ($mapping,$metadata) {
                return ($newMapping['class'] === $metadata->name || $newMapping['class'] === null) && ($newMapping['field'] === $mapping['fieldName'] || $newMapping['field'] === null);
            });
            if (count($mappings) !== 0) {
                foreach($mappings as $mapping) {
                    $this->remapAssociation($metadata, $metadata->associationMappings[$field],$mapping['target']);
                }
            }
        }
    }

    private function remapAssociation(ClassMetadata $classMetadata, AssociationMapping $mapping, string $target): void
    {
        $newMapping = $mapping->toArray();
        $newMapping['targetEntity'] = $target;
        $newMapping['fieldName'] = $mapping->fieldName;

        // Remove the old mapping
        unset($classMetadata->associationMappings[$mapping->fieldName]);

        // Re-map the association based on its type
        switch ($mapping['type']) {
            case ClassMetadata::MANY_TO_MANY:
                $classMetadata->mapManyToMany($newMapping);
                break;
            case ClassMetadata::MANY_TO_ONE:
                $classMetadata->mapManyToOne($newMapping);
                break;
            case ClassMetadata::ONE_TO_MANY:
                $classMetadata->mapOneToMany($newMapping);
                break;
            case ClassMetadata::ONE_TO_ONE:
                $classMetadata->mapOneToOne($newMapping);
                break;
        }
    }
}
