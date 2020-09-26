#!/usr/bin/env bash

wget https://get.symfony.com/cli/installer -O - | bash
mv /root/.symfony/bin/symfony /usr/local/bin/symfony
chmod +x /usr/local/bin/symfony

mv /root/.symfony /home/php/.symfony
chown php:php -R /home/php/.symfony
