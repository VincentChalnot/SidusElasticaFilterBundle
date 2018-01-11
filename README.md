SidusElasticaFilterBundle
=========================

This bundle is an extension for sidus/filter-bundle that enables Elastic Search index search in query handlers.

## Installation

[Follow FOS/ElasticaBundle's installation guide](https://github.com/FriendsOfSymfony/FOSElasticaBundle/blob/master/README.md)

## Configuration

Configure your indexes corresponding to the data you want to search for.

In your filter configuration, set the provider to ```sidus.elastica``` and in the options, set the ```reference```
option to ```fos_elastica.finder.{{name_of_your_index}}.{{name_of_your_type}}```

### Example

Example with a Doctrine ORM entity:

```yml
fos_elastica:
    indexes:
        my_index:
            types:
                my_type:
                    properties:
                        id:
                            type: integer
                        label:
                            type: keyword
                    persistence:
                        driver: orm
                        model: MyBundle\Entity\MyEntity
```

Filter configuration:

```yml
sidus_filter:
    configurations:
        my_entity:
            provider: sidus.elastica
            options:
                reference: fos_elastica.finder.my_index.my_type
            sortable:
                - id
                - label
            filters:
                label: ~
```

## Supported filters

@todo

### Choice

### Date range

### Text
