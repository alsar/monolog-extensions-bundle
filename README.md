Monolog Extensions bundle
==============================

TODO


Sample configuration
--------------------


``` yaml
# app/config/config_prod.yml

alsar_monolog_extensions:
    processors:
        request:
            enabled: true
            handler: buffered
        user:
            enabled: true
            handler: buffered
        browscap:
            enabled: true
            cache_dir: "%kernel.root_dir%/../var/"
            handler: buffered
```