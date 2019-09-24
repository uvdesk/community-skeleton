#!/usr/bin/env bash

if [ ! -f box.phar ]; then
    wget https://github.com/humbug/box/releases/download/3.1.0/box.phar -O box.phar
fi
