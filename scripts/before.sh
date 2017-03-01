#!/usr/bin/env bash
if [ ! -d /var/www/onyx-core ]
then
    mkdir /var/www/onyx-core
fi
cp -R "$HERMES_ROOT"/onyx/* /var/www/onyx-core