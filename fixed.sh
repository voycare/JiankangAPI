#!/usr/bin/env bash

git add .

if [ "$1" != "" ]; then
    git commit -am "$1"
else
    git commit -am "Fixed"
fi

git push origin staging
