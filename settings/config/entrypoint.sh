#!/bin/bash
set -e

#Ajout de configurations si besoin
# Exemple : activation de modules Apache
echo "Activation du module rewrite d'Apache..."
a2enmod rewrite

echo "Lancement du conteneur avec Apache..."
exec "$@"