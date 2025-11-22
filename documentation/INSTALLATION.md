# 📥 Guide d'Installation - E-Library

Ce guide détaille l'installation complète de l'application E-Library sur différents environnements.

## 📋 Table des matières

1. [Prérequis](#prérequis)
2. [Installation Locale (Développement)](#installation-locale-développement)
3. [Installation MAMP/XAMPP](#installation-mampxampp)
4. [Installation Serveur Linux (Production)](#installation-serveur-linux-production)
5. [Configuration](#configuration)
6. [Vérification](#vérification)
7. [Dépannage](#dépannage)

---

## Prérequis

### Logiciels requis

- **PHP** >= 8.0
  - Extensions : `pdo`, `pdo_mysql`, `mbstring`, `json`
- **MySQL** >= 8.0 ou **MariaDB** >= 10.5
- **Serveur web** : Apache 2.4+ ou Nginx 1.18+
- **Git** (pour cloner le projet)

### Vérifier les versions

```bash
# Version PHP
php -v

# Version MySQL
mysql --version

# Extensions PHP
php -m | grep -E 'pdo|mysql|mbstring|json'

# Version Git
git --version
```

---

## Installation Locale (Développement)

### Méthode 1 : PHP Built-in Server (rapide)

Cette méthode est la plus simple pour le développement.

#### 1. Cloner le projet

```bash
cd ~/Documents
git clone https://github.com/votre-equipe/mediatheque.git
cd mediatheque
```

#### 2. Créer la base de données

```bash
mysql -u root -p
```

```sql
CREATE DATABASE gm401942_elibrary2
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Créer un utilisateur dédié (recommandé)
CREATE USER 'elibrary_user'@'localhost' IDENTIFIED BY 'mot_de_passe_fort';
GRANT ALL PRIVILEGES ON gm401942_elibrary2.* TO 'elibrary_user'@'localhost';
FLUSH PRIVILEGES;

EXIT;
```

#### 3. Importer le schéma

```bash
mysql -u root -p gm401942_elibrary2 < sql/schema.sql
```

#### 4. Importer les données de test

**Option A : Via SQL**
```bash
mysql -u root -p gm401942_elibrary2 < sql/data.sql
```

**Option B : Via script PHP** (recommandé)
```bash
php seed.php
```

Le script `seed.php` :
- Vide les tables existantes
- Crée 3 utilisateurs de test
- Insère 5 livres et 5 films
- Crée les genres et thèmes
- Associe les ressources aux genres/thèmes

#### 5. Configurer les credentials

Éditer `config/config.php` :

```php
<?php
// Mode développement
define('ENVIRONMENT', 'development');

// Base de données
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'gm401942_elibrary2');
define('DB_USER', 'elibrary_user');  // Votre utilisateur
define('DB_PASS', 'mot_de_passe_fort');  // Votre mot de passe

// Affichage des erreurs (dev uniquement)
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}
```

#### 6. Démarrer le serveur

```bash
php -S localhost:8000
```

#### 7. Accéder à l'application

Ouvrir votre navigateur : **http://localhost:8000**

---

## Installation MAMP/XAMPP

### MAMP (macOS/Windows)

#### 1. Installer MAMP

Télécharger depuis https://www.mamp.info/

#### 2. Configurer MAMP

- Démarrer MAMP
- Preferences → Ports :
  - Apache : 8888
  - MySQL : 8889 (ou 3306)
- Preferences → Web Server :
  - Document Root : `/Applications/MAMP/htdocs`

#### 3. Placer le projet

```bash
cd /Applications/MAMP/htdocs
git clone https://github.com/votre-equipe/mediatheque.git
```

#### 4. Créer la base de données

Via phpMyAdmin : http://localhost:8888/phpMyAdmin

- Créer la base `gm401942_elibrary2`
- Onglet "Importer" → Choisir `sql/schema.sql`
- Répéter pour `sql/data.sql`

Ou via ligne de commande :

```bash
/Applications/MAMP/Library/bin/mysql -u root -p < sql/schema.sql
```

#### 5. Configurer le port dans config.php

Si MySQL sur port 8889 (MAMP par défaut) :

```php
define('DB_PORT', '8889');
```

#### 6. Accéder à l'application

**http://localhost:8888/mediatheque/**

### XAMPP (Windows/Linux)

Similaire à MAMP :

1. Installer XAMPP depuis https://www.apachefriends.org/
2. Placer le projet dans `C:\xampp\htdocs\mediatheque`
3. Démarrer Apache et MySQL depuis le Control Panel
4. phpMyAdmin : http://localhost/phpmyadmin
5. Importer les SQL
6. Accéder : http://localhost/mediatheque/

---

## Installation Serveur Linux (Production)

### Prérequis serveur

```bash
# Ubuntu/Debian
sudo apt update
sudo apt install -y apache2 mysql-server php php-mysql php-mbstring php-json git

# CentOS/RHEL
sudo yum install -y httpd mariadb-server php php-mysqlnd php-mbstring php-json git
```

### 1. Cloner le projet

```bash
cd /var/www/html
sudo git clone https://github.com/votre-equipe/mediatheque.git
sudo chown -R www-data:www-data mediatheque
```

### 2. Configurer Apache

Créer un VirtualHost : `/etc/apache2/sites-available/mediatheque.conf`

```apache
<VirtualHost *:80>
    ServerName mediatheque.example.com
    ServerAlias www.mediatheque.example.com

    DocumentRoot /var/www/html/mediatheque

    <Directory /var/www/html/mediatheque>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted

        # Empêcher l'accès aux fichiers sensibles
        <FilesMatch "^(\.env|\.git|config\.php)">
            Require all denied
        </FilesMatch>
    </Directory>

    # Logs
    ErrorLog ${APACHE_LOG_DIR}/mediatheque-error.log
    CustomLog ${APACHE_LOG_DIR}/mediatheque-access.log combined

    # Compression
    <IfModule mod_deflate.c>
        AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
    </IfModule>
</VirtualHost>
```

Activer le site :

```bash
sudo a2ensite mediatheque
sudo a2enmod rewrite
sudo systemctl reload apache2
```

### 3. Configurer MySQL

```bash
sudo mysql

CREATE DATABASE gm401942_elibrary2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'elibrary_prod'@'localhost' IDENTIFIED BY 'MOT_DE_PASSE_COMPLEXE';
GRANT ALL PRIVILEGES ON gm401942_elibrary2.* TO 'elibrary_prod'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Importer le schéma
sudo mysql gm401942_elibrary2 < /var/www/html/mediatheque/sql/schema.sql
```

### 4. Sécuriser la configuration

**Utiliser des variables d'environnement** :

Créer `/var/www/html/mediatheque/.env` :

```bash
DB_HOST=localhost
DB_PORT=3306
DB_NAME=gm401942_elibrary2
DB_USER=elibrary_prod
DB_PASS=MOT_DE_PASSE_COMPLEXE
ENVIRONMENT=production
```

Modifier `config/config.php` pour lire `.env` :

```php
<?php
// Charger .env
if (file_exists(__DIR__ . '/../.env')) {
    $env = parse_ini_file(__DIR__ . '/../.env');
    foreach ($env as $key => $value) {
        define($key, $value);
    }
}

// Mode production
if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'production');
}

// ...
```

Protéger `.env` :

```bash
sudo chmod 600 /var/www/html/mediatheque/.env
sudo chown www-data:www-data /var/www/html/mediatheque/.env
```

### 5. Forcer HTTPS

Créer `/var/www/html/mediatheque/.htaccess` :

```apache
# Forcer HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Sécurité supplémentaire
<Files .env>
    Require all denied
</Files>
```

Obtenir un certificat SSL (Let's Encrypt) :

```bash
sudo apt install certbot python3-certbot-apache
sudo certbot --apache -d mediatheque.example.com
```

### 6. Permissions fichiers

```bash
sudo chown -R www-data:www-data /var/www/html/mediatheque
sudo find /var/www/html/mediatheque -type d -exec chmod 755 {} \;
sudo find /var/www/html/mediatheque -type f -exec chmod 644 {} \;
```

---

## Configuration

### config/config.php

**Paramètres principaux :**

```php
<?php
// Environnement
define('ENVIRONMENT', 'development'); // ou 'production'

// Base de données
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'gm401942_elibrary2');
define('DB_USER', 'votre_user');
define('DB_PASS', 'votre_password');

// URL de base (pour les redirections)
define('BASE_URL', 'http://localhost:8000');

// Gestion des erreurs
if (ENVIRONMENT === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    define('DEBUG', true);
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
    define('DEBUG', false);
}

// Timezone
date_default_timezone_set('Europe/Paris');

// Session
ini_set('session.cookie_httponly', '1');
if (ENVIRONMENT === 'production') {
    ini_set('session.cookie_secure', '1'); // HTTPS uniquement
}
```

---

## Vérification

### Checklist post-installation

- [ ] PHP >= 8.0 installé
- [ ] MySQL fonctionne
- [ ] Base de données créée et importée
- [ ] `config/config.php` configuré
- [ ] Page d'accueil accessible
- [ ] Login avec comptes de test fonctionne
- [ ] Catalogue s'affiche
- [ ] Détails d'une ressource accessible
- [ ] Admin accessible (biblio/admin)
- [ ] Création de ressource fonctionne

### Tester les comptes

Après avoir importé les données (`data.sql` ou `seed.php`) :

| Rôle | Email | Password |
|------|-------|----------|
| Admin | admin@mediatheque.com | password |
| Bibliothécaire | biblio@mediatheque.com | password |
| Utilisateur | user@mediatheque.com | password |

### URLs de test

- **Accueil** : http://localhost:8000/
- **Catalogue** : http://localhost:8000/catalogue
- **Login** : http://localhost:8000/auth/login
- **Admin** : http://localhost:8000/admin
- **Ressource** : http://localhost:8000/ressource/show/1

---

## Dépannage

### Erreur de connexion à la base de données

**Symptôme :** "Connection refused" ou "Access denied"

**Solutions :**

1. Vérifier que MySQL est démarré
   ```bash
   # Linux
   sudo systemctl status mysql

   # macOS (MAMP)
   ps aux | grep mysql
   ```

2. Vérifier les credentials dans `config/config.php`

3. Vérifier le port (3306 ou 8889)

4. Tester la connexion manuellement :
   ```bash
   mysql -h 127.0.0.1 -P 3306 -u elibrary_user -p
   ```

### Erreur 404 sur toutes les pages

**Cause :** Problème de routing

**Solutions :**

1. Vérifier que le serveur est démarré

2. Vérifier le `.htaccess` (Apache)

3. Pour Nginx, ajouter la configuration :
   ```nginx
   location / {
       try_files $uri $uri/ /index.php?$query_string;
   }
   ```

### Page blanche (White Screen of Death)

**Cause :** Erreur PHP non affichée

**Solutions :**

1. Activer l'affichage des erreurs :
   ```php
   ini_set('display_errors', '1');
   error_reporting(E_ALL);
   ```

2. Vérifier les logs :
   ```bash
   # Apache
   tail -f /var/log/apache2/error.log

   # Nginx
   tail -f /var/log/nginx/error.log

   # PHP
   tail -f /var/log/php-fpm/error.log
   ```

### Les images ne s'affichent pas

**Cause :** Permissions ou chemins incorrects

**Solutions :**

1. Vérifier les permissions :
   ```bash
   sudo chmod -R 755 public/img
   ```

2. Vérifier que les images existent :
   ```bash
   ls -la public/img/livres/
   ls -la public/img/films/
   ```

3. Le placeholder par défaut devrait toujours fonctionner :
   ```
   public/img/placeholders/cover-default.jpg
   ```

### Sessions ne fonctionnent pas

**Cause :** Dossier session inaccessible

**Solutions :**

```bash
# Vérifier le dossier de session
php -i | grep session.save_path

# Créer/corriger les permissions
sudo mkdir -p /var/lib/php/sessions
sudo chown -R www-data:www-data /var/lib/php/sessions
sudo chmod -R 700 /var/lib/php/sessions
```

### Erreurs d'import SQL

**Symptôme :** "Table doesn't exist" ou "Syntax error"

**Solutions :**

1. Importer dans le bon ordre :
   ```bash
   # D'abord le schéma
   mysql -u root -p gm401942_elibrary2 < sql/schema.sql

   # Puis les données
   mysql -u root -p gm401942_elibrary2 < sql/data.sql
   ```

2. Vérifier la version de MySQL :
   ```bash
   mysql --version
   # Doit être >= 8.0 ou MariaDB >= 10.5
   ```

3. Utiliser le script PHP à la place :
   ```bash
   php seed.php
   ```

---

## Mise à jour

Pour mettre à jour le projet :

```bash
git pull origin main
php migrate_add_fields.php  # Si nouvelles colonnes
```

---

## Sauvegarde

### Base de données

```bash
# Exporter
mysqldump -u root -p gm401942_elibrary2 > backup_$(date +%Y%m%d).sql

# Restaurer
mysql -u root -p gm401942_elibrary2 < backup_20250122.sql
```

### Fichiers uploadés

```bash
# Sauvegarder les images
tar -czf images_backup.tar.gz public/img/livres public/img/films
```

---

## Support

Pour toute question :
- **Documentation** : Voir [README.md](../README.md)
- **Issues** : https://github.com/votre-equipe/mediatheque/issues
- **Contact** : thanh-phuong.nguyen@univcotedazur.fr

---

**Dernière mise à jour :** 2025-11-22
