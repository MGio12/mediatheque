# 🔒 Documentation Sécurité - E-Library

Ce document détaille les mesures de sécurité implémentées, les vulnérabilités identifiées, et les recommandations pour sécuriser l'application.

## 📊 État de la sécurité

### ✅ Mesures implémentées

| Vulnérabilité | Protection | Statut | Implémentation |
|---------------|------------|--------|----------------|
| SQL Injection | PDO + Prepared Statements | ✅ Complet | Tous les modèles |
| XSS | htmlspecialchars() | ✅ Complet | Toutes les vues |
| Password Storage | Bcrypt (password_hash) | ✅ Complet | AuthController |
| Session Management | PHP Sessions | ✅ Basique | Auth helper |
| Input Validation | Validation serveur | ✅ Partiel | Contrôleurs |
| Authorization | Role-based access | ✅ Complet | Auth helper |

### ⚠️ Vulnérabilités à corriger

| Vulnérabilité | Risque | Priorité | Temps estimé |
|---------------|--------|----------|--------------|
| CSRF | Haut | 🔴 Critique | 3-4h |
| Session Fixation | Moyen | 🟠 Haute | 30min |
| Credentials en dur | Haut | 🔴 Critique | 1h |
| Rate Limiting | Moyen | 🟠 Haute | 2-3h |
| HTTPS non forcé | Moyen | 🟠 Haute | 30min |
| Secure Cookies | Faible | 🟡 Moyenne | 15min |
| Password Policy | Faible | 🟡 Moyenne | 1h |

---

## 🛡️ Protections implémentées

### 1. Protection SQL Injection

**Vulnérabilité :** Injection de code SQL via les entrées utilisateur.

**Protection :**
- Utilisation exclusive de PDO avec prepared statements
- Paramètres bindés (jamais de concaténation)
- Toutes les requêtes utilisent `prepare()` + `execute()`

**Exemple :**

```php
// ✅ BON - Sécurisé
$stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE email = :email");
$stmt->execute(['email' => $email]);

// ❌ MAUVAIS - Vulnérable
$query = "SELECT * FROM utilisateur WHERE email = '$email'";
$result = $this->pdo->query($query);
```

**Vérification :**
```bash
# Rechercher des requêtes potentiellement vulnérables
grep -r "query.*\$" app/models/
# Résultat : Aucune trouvée ✅
```

**Statut :** ✅ **100% sécurisé**

---

### 2. Protection XSS (Cross-Site Scripting)

**Vulnérabilité :** Injection de JavaScript malveillant via les données utilisateur.

**Protection :**
- `htmlspecialchars()` sur toutes les sorties
- Flags : `ENT_QUOTES` + `UTF-8`
- Aucune variable non échappée dans les vues

**Exemple :**

```php
// ✅ BON - Échappé
<?= htmlspecialchars($ressource['titre'], ENT_QUOTES, 'UTF-8') ?>

// ❌ MAUVAIS - Vulnérable
<?= $ressource['titre'] ?>
```

**Convention du projet :** TOUJOURS utiliser `<?= htmlspecialchars(...) ?>`

**Statut :** ✅ **100% sécurisé**

---

### 3. Hachage des mots de passe

**Vulnérabilité :** Mots de passe stockés en clair ou avec un hash faible.

**Protection :**
- `password_hash()` avec `PASSWORD_DEFAULT` (bcrypt)
- `password_verify()` pour la vérification
- Jamais de mots de passe en clair

**Implémentation :**

```php
// Lors de l'inscription
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt->execute([
    'mot_de_passe' => $hash
]);

// Lors de la connexion
if (password_verify($inputPassword, $storedHash)) {
    // Authentification réussie
}
```

**Caractéristiques :**
- Algorithme : bcrypt
- Cost factor : 10 (par défaut)
- Salt : Généré automatiquement
- Résistant aux rainbow tables

**Statut :** ✅ **Sécurisé**

---

### 4. Contrôle d'accès (Authorization)

**Implémentation :** Classe `Auth` centralisée

**Méthodes :**

```php
// Vérifier si connecté
Auth::check() : bool

// Obtenir l'utilisateur
Auth::user() : array|null

// Vérifier un rôle
Auth::hasRole('administrateur') : bool

// Forcer l'authentification (redirige sinon)
Auth::requireAuth()

// Forcer un rôle spécifique
Auth::requireRole('administrateur')

// Forcer admin ou bibliothécaire
Auth::requireStaff()
```

**Utilisation dans les contrôleurs :**

```php
// Contrôleur admin
class LivreController extends Controller {
    public function __construct() {
        Auth::requireStaff(); // Bloque si pas admin/biblio
    }
}

// Action spécifique
public function delete($id) {
    Auth::requireRole('administrateur'); // Admins uniquement
    // ...
}
```

**Rôles disponibles :**
- `utilisateur` : Utilisateur standard
- `bibliothecaire` : Gestion des ressources
- `administrateur` : Tous les droits

**Statut :** ✅ **Implémenté correctement**

---

## 🚨 Vulnérabilités à corriger

### 🔴 CRITIQUE 1 : CSRF (Cross-Site Request Forgery)

**Risque :** Un attaquant peut soumettre des formulaires à la place de l'utilisateur connecté.

**Exemple d'attaque :**

```html
<!-- Site malveillant evil.com -->
<form action="https://mediatheque.com/livre/delete/5" method="POST">
    <input type="hidden" name="id" value="5">
</form>
<script>document.forms[0].submit();</script>
```

Si l'utilisateur est connecté à la médiathèque, le livre sera supprimé à son insu.

**Impact :**
- Suppression de ressources
- Modification de données
- Création de comptes admin
- Toute action POST/PUT/DELETE

**Solution recommandée :**

#### Étape 1 : Créer un helper CSRF

Créer `core/Csrf.php` :

```php
<?php
class Csrf {
    /**
     * Génère un token CSRF et le stocke en session
     */
    public static function generateToken(): string {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Vérifie le token CSRF
     */
    public static function validateToken(string $token): bool {
        return isset($_SESSION['csrf_token']) &&
               hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Génère un champ input caché avec le token
     */
    public static function field(): string {
        $token = self::generateToken();
        return '<input type="hidden" name="csrf_token" value="' .
               htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
}
```

#### Étape 2 : Ajouter le token dans les formulaires

Dans toutes les vues avec formulaire :

```php
<form method="POST" action="/livre/store">
    <?= Csrf::field() ?>

    <input type="text" name="titre" required>
    <!-- ... -->
    <button type="submit">Créer</button>
</form>
```

#### Étape 3 : Valider le token dans les contrôleurs

Dans chaque méthode POST :

```php
public function store() {
    // Vérifier le token CSRF
    if (!Csrf::validateToken($_POST['csrf_token'] ?? '')) {
        $this->setFlash('error', 'Token de sécurité invalide');
        $this->redirect('/');
        return;
    }

    // Suite du traitement...
}
```

#### Étape 4 : Middleware global (optionnel)

Dans `index.php`, avant le routing :

```php
// Vérifier CSRF pour toutes les requêtes POST/PUT/DELETE
if ($_SERVER['REQUEST_METHOD'] !== 'GET' &&
    $_SERVER['REQUEST_METHOD'] !== 'HEAD') {

    if (!Csrf::validateToken($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        die('CSRF token validation failed');
    }
}
```

**Temps d'implémentation :** 3-4 heures

**Priorité :** 🔴 **CRITIQUE**

---

### 🔴 CRITIQUE 2 : Credentials en dur

**Risque :** Mot de passe MySQL visible dans le code source.

**Fichier concerné :** `config/config.php`

```php
// ❌ MAUVAIS - Credentials en dur
define('DB_PASS', 'gm401942');
```

**Impact :**
- Accès à la base de données si le code fuite
- Impossible d'avoir des credentials différents par environnement
- Violation des bonnes pratiques

**Solution recommandée :**

#### Étape 1 : Créer un fichier .env

Créer `.env` à la racine (ne pas commiter) :

```bash
# Base de données
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=gm401942_elibrary2
DB_USER=gm401942
DB_PASS=mot_de_passe_secret

# Environnement
ENVIRONMENT=development
DEBUG=true

# URL
BASE_URL=http://localhost:8000
```

#### Étape 2 : Modifier config.php

```php
<?php
// Charger les variables d'environnement
function loadEnv($path) {
    if (!file_exists($path)) {
        die('.env file not found');
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '#') === 0) continue;

        list($key, $value) = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        putenv("$key=$value");
        $_ENV[$key] = $value;
    }
}

loadEnv(__DIR__ . '/../.env');

// Utiliser les variables
define('DB_HOST', getenv('DB_HOST'));
define('DB_PORT', getenv('DB_PORT'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('ENVIRONMENT', getenv('ENVIRONMENT'));
```

#### Étape 3 : Ajouter .env au .gitignore

```bash
# .gitignore
.env
```

#### Étape 4 : Créer .env.example

Créer `.env.example` (committé) :

```bash
# Base de données
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=nom_base
DB_USER=utilisateur
DB_PASS=mot_de_passe

# Environnement
ENVIRONMENT=development
DEBUG=true

# URL
BASE_URL=http://localhost:8000
```

**Temps d'implémentation :** 1 heure

**Priorité :** 🔴 **CRITIQUE**

---

### 🟠 HAUTE 1 : Session Fixation

**Risque :** Un attaquant peut fixer l'ID de session d'une victime.

**Attaque :**
1. Attaquant obtient un ID de session valide
2. Force la victime à utiliser cet ID (via URL ou cookie)
3. Victime se connecte avec cet ID
4. Attaquant utilise le même ID pour accéder au compte

**Solution :**

Dans `AuthController::login()`, après authentification réussie :

```php
public function login() {
    // ... validation email/password ...

    if (password_verify($password, $userData['mot_de_passe'])) {
        // Régénérer l'ID de session (protection session fixation)
        session_regenerate_id(true);

        // Créer la session
        $_SESSION['user'] = $userData;

        $this->setFlash('success', 'Connexion réussie');
        $this->redirect('/');
    }
}
```

**Temps d'implémentation :** 30 minutes

**Priorité :** 🟠 **HAUTE**

---

### 🟠 HAUTE 2 : Rate Limiting

**Risque :** Attaque par force brute sur le login.

**Attaque :** Essayer des milliers de mots de passe jusqu'à trouver le bon.

**Solution :**

Créer `core/RateLimit.php` :

```php
<?php
class RateLimit {
    private const MAX_ATTEMPTS = 5;
    private const LOCKOUT_TIME = 900; // 15 minutes

    /**
     * Vérifie si l'IP est rate-limitée
     */
    public static function check(string $action): bool {
        $ip = $_SERVER['REMOTE_ADDR'];
        $key = "ratelimit_{$action}_{$ip}";

        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = [
                'attempts' => 0,
                'first_attempt' => time()
            ];
        }

        $data = &$_SESSION[$key];

        // Reset si le temps est écoulé
        if (time() - $data['first_attempt'] > self::LOCKOUT_TIME) {
            $data['attempts'] = 0;
            $data['first_attempt'] = time();
        }

        // Vérifier le nombre de tentatives
        if ($data['attempts'] >= self::MAX_ATTEMPTS) {
            return false; // Rate limited
        }

        return true; // OK
    }

    /**
     * Enregistre une tentative échouée
     */
    public static function increment(string $action): void {
        $ip = $_SERVER['REMOTE_ADDR'];
        $key = "ratelimit_{$action}_{$ip}";

        if (!isset($_SESSION[$key])) {
            $_SESSION[$key] = [
                'attempts' => 0,
                'first_attempt' => time()
            ];
        }

        $_SESSION[$key]['attempts']++;
    }

    /**
     * Reset le compteur
     */
    public static function reset(string $action): void {
        $ip = $_SERVER['REMOTE_ADDR'];
        $key = "ratelimit_{$action}_{$ip}";
        unset($_SESSION[$key]);
    }
}
```

Dans `AuthController::login()` :

```php
public function login() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Vérifier rate limit
        if (!RateLimit::check('login')) {
            $this->setFlash('error', 'Trop de tentatives. Réessayez dans 15 minutes.');
            $this->renderView('auth/login');
            return;
        }

        // ... validation email/password ...

        if (!password_verify($password, $userData['mot_de_passe'])) {
            // Incrémenter le compteur
            RateLimit::increment('login');

            $this->setFlash('error', 'Email ou mot de passe incorrect');
            $this->renderView('auth/login');
            return;
        }

        // Reset le compteur si connexion réussie
        RateLimit::reset('login');

        // ... créer session ...
    }
}
```

**Temps d'implémentation :** 2-3 heures

**Priorité :** 🟠 **HAUTE**

---

### 🟠 HAUTE 3 : Forcer HTTPS

**Risque :** Man-in-the-Middle, interception de cookies de session.

**Solution :**

Créer `.htaccess` à la racine :

```apache
# Forcer HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Sécurité supplémentaire
Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
Header always set X-Content-Type-Options "nosniff"
Header always set X-Frame-Options "SAMEORIGIN"
Header always set X-XSS-Protection "1; mode=block"
```

**Temps d'implémentation :** 30 minutes

**Priorité :** 🟠 **HAUTE** (en production)

---

### 🟡 MOYENNE 1 : Secure Cookies

**Risque :** Cookies interceptés ou volés.

**Solution :**

Dans `config/config.php` :

```php
// Configuration des sessions sécurisées
ini_set('session.cookie_httponly', '1'); // Pas d'accès JS
ini_set('session.cookie_samesite', 'Strict'); // CSRF protection
ini_set('session.use_strict_mode', '1'); // Sessions strictes

if (ENVIRONMENT === 'production') {
    ini_set('session.cookie_secure', '1'); // HTTPS uniquement
}
```

**Temps d'implémentation :** 15 minutes

**Priorité :** 🟡 **MOYENNE**

---

### 🟡 MOYENNE 2 : Password Policy

**Risque :** Mots de passe faibles (8 caractères minimum actuellement).

**Solution actuelle :**

```php
// AuthController::register()
if (strlen($password) < 8) {
    $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
}
```

**Amélioration recommandée :**

```php
function validatePassword($password): array {
    $errors = [];

    if (strlen($password) < 12) {
        $errors[] = "Minimum 12 caractères";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Au moins une majuscule";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Au moins une minuscule";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Au moins un chiffre";
    }
    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        $errors[] = "Au moins un caractère spécial";
    }

    return $errors;
}
```

**Temps d'implémentation :** 1 heure

**Priorité :** 🟡 **MOYENNE**

---

## 📝 Checklist de sécurité

### Avant mise en production

- [ ] ✅ SQL Injection protégé (PDO)
- [ ] ✅ XSS protégé (htmlspecialchars)
- [ ] ✅ Mots de passe hashés (bcrypt)
- [ ] ⚠️ CSRF protection implémentée
- [ ] ⚠️ Credentials dans .env
- [ ] ⚠️ Session regenerate après login
- [ ] ⚠️ Rate limiting sur login
- [ ] ⚠️ HTTPS forcé
- [ ] ⚠️ Secure cookies configurés
- [ ] ⚠️ Password policy renforcée
- [ ] ⚠️ Logs de sécurité activés
- [ ] ⚠️ Backup automatique configuré
- [ ] ⚠️ Permissions fichiers correctes (644/755)
- [ ] ⚠️ .git/.env inaccessibles via web

---

## 🔍 Audit de sécurité

### Outils recommandés

**Scan de vulnérabilités :**
```bash
# OWASP ZAP
docker run -t owasp/zap2docker-stable zap-baseline.py -t http://localhost:8000

# Nikto
nikto -h http://localhost:8000
```

**Analyse de code :**
```bash
# PHPStan (analyse statique)
composer require --dev phpstan/phpstan
vendor/bin/phpstan analyse app/

# PHP_CodeSniffer (standards)
composer require --dev squizlabs/php_codesniffer
vendor/bin/phpcs app/
```

---

## 📞 Signalement de vulnérabilités

Si vous découvrez une faille de sécurité :

1. **NE PAS** créer d'issue publique
2. Contacter : thanh-phuong.nguyen@univcotedazur.fr
3. Fournir : Description, impact, steps to reproduce

---

## 📚 Ressources

- [OWASP Top 10](https://owasp.org/www-project-top-ten/)
- [PHP Security Cheatsheet](https://cheatsheetseries.owasp.org/cheatsheets/PHP_Configuration_Cheat_Sheet.html)
- [OWASP CSRF Prevention](https://cheatsheetseries.owasp.org/cheatsheets/Cross-Site_Request_Forgery_Prevention_Cheat_Sheet.html)

---

**Dernière révision :** 2025-11-22
**Prochain audit :** À planifier
