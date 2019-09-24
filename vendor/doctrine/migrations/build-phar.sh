#!/usr/bin/env bash

set -euf -o pipefail

./download-box.sh

function restorePlatform {
    composer config --unset platform
    mv -f composer.lock.back composer.lock || true
}

# lock PHP to minimum allowed version
composer config platform.php 7.1.0
cp composer.lock composer.lock.back || true
composer update

php box.phar compile -vv

trap restorePlatform exit
