# Utiliser l'image PHP avec Apache
FROM php:8.2-apache

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Copier tout le contenu de ton dossier actuel dans le dossier /var/www/html du conteneur
COPY . /var/www/html/

# Exposer le port 80
EXPOSE 80
