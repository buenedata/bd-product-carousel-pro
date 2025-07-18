# GitHub Setup Guide for Automatic Updates

## Trinn 1: Forberede Pluginen

✅ **Fullført**: Pluginen er nå klar med automatisk oppdateringsfunksjonalitet

## Trinn 2: GitHub Repository Setup

### 2.1 Opprett Repository
1. Gå til GitHub.com og opprett et nytt repository
2. Navn: `product-carousel-pro`
3. Velg Public eller Private (avhengig av dine behov)

### 2.2 Oppdater Plugin Headers
I `product-carousel-pro.php`, erstatt følgende:
- `your-username` → ditt faktiske GitHub brukernavn
- `https://github.com/your-username/product-carousel-pro` → din faktiske repository URL

### 2.3 For Private Repositories
Hvis repositoryet er privat, må du:
1. Opprett en GitHub Personal Access Token
2. Oppdater plugin-initialiseringen med token:
```php
new BD_Product_Carousel_GitHub_Updater(__FILE__, 'ditt-brukernavn', 'product-carousel-pro', 'ditt-github-token');
```

## Trinn 3: Upload til GitHub

```bash
cd "d:\Programmering\PRO versjoner klare til GitHub\BD Product Carousel PRO\product-carousel-pro"
git init
git add .
git commit -m "Initial commit with GitHub updater"
git branch -M main
git remote add origin https://github.com/ditt-brukernavn/product-carousel-pro.git
git push -u origin main
```

## Trinn 4: Opprett Din Første Release

### Manuell metode:
1. Gå til din GitHub repository
2. Klikk på "Releases" → "Create a new release"
3. Tag version: `v2.0.0`
4. Release title: `Version 2.0.0`
5. Beskriv endringene i release notes
6. Klikk "Publish release"

### Automatisk metode (med GitHub Actions):
```bash
git tag v2.0.0
git push origin v2.0.0
```

## Trinn 5: Test Automatic Updates

1. Installer pluginen på en WordPress-side
2. Opprett en ny release på GitHub (f.eks. v2.0.1)
3. Gå til WordPress Admin → Dashboard → Updates
4. Du skal se din plugin i listen over tilgjengelige oppdateringer

## Fremtidige Releases

### For hver ny versjon:
1. Oppdater versjonsnummeret i `product-carousel-pro.php`
2. Oppdater `CHANGELOG.md` med endringene
3. Commit endringene til GitHub
4. Opprett en ny release med samme versjonsnummer

### Eksempel release-prosess:
```bash
# Endre versjon i product-carousel-pro.php til "2.1.0"
# Oppdater CHANGELOG.md

git add .
git commit -m "Version 2.1.0 - Add new features"
git push origin main
git tag v2.1.0
git push origin v2.1.0
```

## Viktige Notater

- **Versjonsnumre**: Bruk semantisk versjonering (major.minor.patch)
- **Tag format**: Bruk `v` prefix (v2.0.0, v2.1.0, etc.)
- **Testing**: Test alltid oppdateringer på en staging-side først
- **Backup**: Brukere bør ta backup før oppdatering
- **Compatibility**: Sørg for WordPress-kompatibilitet før release

## Feilsøking

### Oppdateringer vises ikke:
1. Sjekk at GitHub repository URL er korrekt
2. Verifiser at release er publisert (ikke draft)
3. Kontroller at versjonsnummeret er høyere enn installert versjon

### Private repository problemer:
1. Sørg for at GitHub token har riktige tillatelser
2. Token må ha 'repo' scope for private repositories

### Cache-problemer:
WordPress cacher oppdateringsinformasjon. For å tvinge en sjekk:
1. Gå til Plugins-siden i admin
2. Refresh siden
3. Eller vent 12 timer for automatisk sjekk
