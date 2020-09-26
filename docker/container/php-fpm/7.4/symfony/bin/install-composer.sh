#!/usr/bin/env bash

cd ~

EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]
then
    >&2 echo 'ERROR: Invalid installer signature'
    rm composer-setup.php
    exit 1
fi

php composer-setup.php --quite
RESULT=$?

# copy installed phar
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

# move tmp folder to user php
mv .composer /home/php/.composer
chown php:php -R /home/php/.composer

# cleanup
rm composer-setup.php
exit $RESULT