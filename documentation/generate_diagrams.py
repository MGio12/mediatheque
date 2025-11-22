#!/usr/bin/env python3
"""
Génère des PNG à partir des fichiers PlantUML via le serveur en ligne
Pas besoin d'installer Java !
"""

import os
import sys
import base64
import zlib
from pathlib import Path

def plantuml_encode(plantuml_text):
    """Encode le texte PlantUML pour l'URL"""
    zlibbed_str = zlib.compress(plantuml_text.encode('utf-8'))
    compressed_string = zlibbed_str[2:-4]
    return base64.b64encode(compressed_string).decode('utf-8').translate(
        str.maketrans('+/=', '-_~')
    )

def generate_url(puml_file):
    """Génère l'URL PlantUML pour un fichier"""
    with open(puml_file, 'r', encoding='utf-8') as f:
        content = f.read()

    encoded = plantuml_encode(content)
    return f"https://www.plantuml.com/plantuml/png/{encoded}"

def download_png(url, output_file):
    """Télécharge le PNG depuis l'URL"""
    try:
        import urllib.request
        urllib.request.urlretrieve(url, output_file)
        return True
    except Exception as e:
        print(f"Erreur: {e}")
        return False

def main():
    script_dir = Path(__file__).parent
    diagrammes_dir = script_dir / "diagrammes"

    if not diagrammes_dir.exists():
        print(f"❌ Dossier {diagrammes_dir} introuvable")
        return

    puml_files = list(diagrammes_dir.glob("*.puml"))

    if not puml_files:
        print("❌ Aucun fichier .puml trouvé")
        return

    print(f"🔍 {len(puml_files)} fichiers PlantUML trouvés\n")

    success = 0
    failed = 0

    for puml_file in sorted(puml_files):
        png_file = puml_file.with_suffix('.png')
        print(f"📊 Génération de {puml_file.name}...", end=" ")

        try:
            url = generate_url(puml_file)

            if download_png(url, png_file):
                print(f"✅ → {png_file.name}")
                success += 1
            else:
                print(f"❌ Échec")
                failed += 1

        except Exception as e:
            print(f"❌ Erreur: {e}")
            failed += 1

    print(f"\n{'='*50}")
    print(f"✅ Réussis: {success}")
    print(f"❌ Échecs: {failed}")
    print(f"📁 PNG générés dans: {diagrammes_dir}")

    if success > 0:
        print("\n💡 Vous pouvez maintenant ouvrir les .png avec n'importe quel visualiseur d'images")
        print("   ou les insérer dans votre document Word/PDF pour la SAE")

if __name__ == "__main__":
    main()
