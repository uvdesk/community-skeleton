# Doctrine ORM Documentation

## How to Generate:
Using Ubuntu 14.04 LTS:

1. Run ./bin/install-dependencies.sh
2. Run ./bin/generate-docs.sh

It will generate the documentation into the build directory of the checkout.


## Theme issues

If you get a "Theme error", check if the `en/_theme` subdirectory is empty,
in which case you will need to run:

1. git submodule init
2. git submodule update
