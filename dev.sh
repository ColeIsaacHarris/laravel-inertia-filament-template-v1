#!/bin/bash

DESTROY=${DESTROY:-false}

cleanup() {
    trap '' EXIT SIGTERM SIGINT SIGHUP

    echo ""
    if [ "$DESTROY" = "true" ]; then
        echo "Stopping and removing containers..."
        ./vendor/bin/sail down
    else
        echo "Stopping containers..."
        ./vendor/bin/sail stop
    fi
}

trap cleanup EXIT SIGTERM SIGINT SIGHUP

echo "Starting Sail..."
./vendor/bin/sail up -d

echo "Waiting for Sail to be ready..."
until ./vendor/bin/sail artisan --version > /dev/null 2>&1; do
    sleep 1
done

echo "Sail is ready. Starting queue and logs..."
npx concurrently -k -c "#c4b5fd,#d4d4d8" \
    "./vendor/bin/sail artisan queue:listen --tries=1" \
    "./vendor/bin/sail artisan pail" \
    --names=queue,logs
