#!/bin/bash
###############################################################################
# Script de test automatisé - Médiathèque sur linserv-info-01.unice.fr
# SAE R307 - Projet PHP MVC
###############################################################################

# Couleurs pour affichage
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# URL de base (à adapter selon votre username)
BASE_URL="https://linserv-info-01.unice.fr/~gm401942/mediatheque"

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}   TESTS AUTHENTIFICATION LINSERV${NC}"
echo -e "${BLUE}========================================${NC}\n"

###############################################################################
# TEST 1 : GET sur loginPost (doit rediriger, pas de 500)
###############################################################################
echo -e "${YELLOW}[TEST 1]${NC} Accès GET sur loginPost (doit rediriger)"
echo -e "URL: ${BASE_URL}/index.php?controller=auth&action=loginPost"

RESPONSE_CODE=$(curl -s -o /dev/null -w "%{http_code}" -k \
  "${BASE_URL}/index.php?controller=auth&action=loginPost")

if [ "$RESPONSE_CODE" == "302" ] || [ "$RESPONSE_CODE" == "301" ]; then
    echo -e "${GREEN}✓ SUCCÈS${NC} - Code HTTP: $RESPONSE_CODE (Redirection OK)"
elif [ "$RESPONSE_CODE" == "200" ]; then
    echo -e "${YELLOW}⚠ ATTENTION${NC} - Code HTTP: 200 (Devrait rediriger en 302)"
else
    echo -e "${RED}✗ ÉCHEC${NC} - Code HTTP: $RESPONSE_CODE (Attendu: 302)"
fi
echo ""

###############################################################################
# TEST 2 : POST connexion valide
###############################################################################
echo -e "${YELLOW}[TEST 2]${NC} POST connexion avec identifiants valides"
echo -e "Email: admin@mediatheque.fr | Password: password123"

# Effectuer le POST et capturer les headers
RESPONSE=$(curl -s -D - -k -X POST \
  "${BASE_URL}/index.php?controller=auth&action=loginPost" \
  -d "email=admin@mediatheque.fr" \
  -d "password=password123")

# Extraire le code HTTP
RESPONSE_CODE=$(echo "$RESPONSE" | grep -i "^HTTP" | tail -1 | awk '{print $2}')

# Vérifier présence du cookie de session
SESSION_COOKIE=$(echo "$RESPONSE" | grep -i "Set-Cookie: PHPSESSID")

if [ "$RESPONSE_CODE" == "302" ] || [ "$RESPONSE_CODE" == "301" ]; then
    echo -e "${GREEN}✓ SUCCÈS${NC} - Code HTTP: $RESPONSE_CODE (Redirection OK)"

    if [ -n "$SESSION_COOKIE" ]; then
        echo -e "${GREEN}✓ SUCCÈS${NC} - Cookie de session créé"
    else
        echo -e "${YELLOW}⚠ ATTENTION${NC} - Pas de cookie PHPSESSID détecté"
    fi
else
    echo -e "${RED}✗ ÉCHEC${NC} - Code HTTP: $RESPONSE_CODE (Attendu: 302)"
    echo -e "${RED}Réponse complète:${NC}"
    echo "$RESPONSE" | head -20
fi
echo ""

###############################################################################
# TEST 3 : POST connexion invalide
###############################################################################
echo -e "${YELLOW}[TEST 3]${NC} POST connexion avec identifiants invalides"
echo -e "Email: wrong@test.com | Password: wrongpass"

RESPONSE_CODE=$(curl -s -o /dev/null -w "%{http_code}" -k -X POST \
  "${BASE_URL}/index.php?controller=auth&action=loginPost" \
  -d "email=wrong@test.com" \
  -d "password=wrongpass")

if [ "$RESPONSE_CODE" == "200" ]; then
    echo -e "${GREEN}✓ SUCCÈS${NC} - Code HTTP: 200 (Formulaire réaffiché avec erreur)"
elif [ "$RESPONSE_CODE" == "500" ]; then
    echo -e "${RED}✗ ÉCHEC${NC} - Code HTTP: 500 (Erreur serveur)"
else
    echo -e "${YELLOW}⚠ ATTENTION${NC} - Code HTTP: $RESPONSE_CODE (Attendu: 200)"
fi
echo ""

###############################################################################
# TEST 4 : debug.php (connexion BDD)
###############################################################################
echo -e "${YELLOW}[TEST 4]${NC} Vérification debug.php (connexion BDD)"
echo -e "URL: ${BASE_URL}/debug.php"

DEBUG_RESPONSE=$(curl -s -k "${BASE_URL}/debug.php")

if echo "$DEBUG_RESPONSE" | grep -q "Connexion BDD réussie"; then
    echo -e "${GREEN}✓ SUCCÈS${NC} - Connexion BDD fonctionnelle"

    # Afficher environnement détecté
    ENV=$(echo "$DEBUG_RESPONSE" | grep "Environnement détecté" | sed 's/<[^>]*>//g')
    echo -e "  $ENV"

    PORT=$(echo "$DEBUG_RESPONSE" | grep "Port MySQL" | sed 's/<[^>]*>//g')
    echo -e "  $PORT"

elif echo "$DEBUG_RESPONSE" | grep -qi "erreur"; then
    echo -e "${RED}✗ ÉCHEC${NC} - Erreur de connexion BDD"
    echo -e "${RED}Extrait:${NC}"
    echo "$DEBUG_RESPONSE" | grep -i "erreur" | head -5
else
    echo -e "${YELLOW}⚠ ATTENTION${NC} - Réponse inattendue"
fi
echo ""

###############################################################################
# TEST 5 : Page d'accueil
###############################################################################
echo -e "${YELLOW}[TEST 5]${NC} Accès page d'accueil"
echo -e "URL: ${BASE_URL}/index.php"

RESPONSE_CODE=$(curl -s -o /dev/null -w "%{http_code}" -k "${BASE_URL}/index.php")

if [ "$RESPONSE_CODE" == "200" ]; then
    echo -e "${GREEN}✓ SUCCÈS${NC} - Code HTTP: 200 (Page accessible)"
else
    echo -e "${RED}✗ ÉCHEC${NC} - Code HTTP: $RESPONSE_CODE (Attendu: 200)"
fi
echo ""

###############################################################################
# RÉSUMÉ
###############################################################################
echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}           RÉSUMÉ DES TESTS${NC}"
echo -e "${BLUE}========================================${NC}"
echo -e "✓ = Test réussi"
echo -e "⚠ = Test partiellement réussi (vérification manuelle recommandée)"
echo -e "✗ = Test échoué (correction nécessaire)"
echo ""
echo -e "${BLUE}Pour plus de détails :${NC}"
echo -e "  - Logs PHP : ~/public_html/mediatheque/php_errors.log"
echo -e "  - Debug : ${BASE_URL}/debug.php"
echo ""
