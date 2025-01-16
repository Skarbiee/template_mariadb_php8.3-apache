FROM php:8.3-apache

# Installer les extensions nécessaires et dos2unix
RUN apt-get update && apt-get install -y \
    dos2unix \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable pdo_mysql

# Copier le script d'entrée et définir les permissions
COPY ./settings/config/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN dos2unix /usr/local/bin/entrypoint.sh

# Copier le dossier de stockage
COPY ./src/public/assets/imgs /var/www/html/storage

# Configurer le vHost Apache
RUN chmod +x /usr/local/bin/entrypoint.sh

# Définir l'entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Purger dox2unix et nettoyer les paquets
RUN apt-get purge -y dos2unix && apt-get clean

# Commande par défault
CMD ["apache2-foreground"]