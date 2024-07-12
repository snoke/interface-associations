# Interface Associations
Bundle for Symfony7 with Doctrine ORM

The Interface Associations Bundle provides a way to replace ORM relations with interfaces and map them to concrete classes only at runtime. This enables the development of abstract components.
# installation
run ```composer req snoke/interface-associations```

## Functionality

The bundle allows configuring remappings. You can specify which classes or interfaces should be replaced by other classes or interfaces, either globally or specifically for certain classes and properties.

## configuration

edit ```config/packages/snoke_interface_associations.yaml``` as follows:
```yaml
snoke_interface_associations:
    remap:
        - source: 'App\Interface\EntityInterface'
          target: 'App\Entity\User'
          class: 'App\Entity\AuthToken'
          property: 'user'
```

- source: The source class or interface to be remapped.


- target: The target class to remap to.


- class (optional): The class where the remapping should be applied. If not specified, the remapping is global.


- property (optional): The property within the class where the remapping should be applied. If not specified, the remapping applies to all properties of the class.
