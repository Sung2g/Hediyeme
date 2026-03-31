# GitFlow

Bu projede aşağıdaki branch yapisi kullanilir:

- `main`: production branch. Sadece deploy edilebilir kod bulunur.
- `develop`: gelistirme branch'i. Tum feature branch'ler buraya merge edilir.
- `feature/*`: yeni ozellik gelistirmeleri.
- `release/*`: release hazirligi (son test ve duzeltmeler).
- `hotfix/*`: production acil duzeltmeleri.

## Akis

1. Yeni ozellik icin `develop` uzerinden `feature/<isim>` olustur.
2. Feature tamamlaninca `develop` icin Pull Request ac.
3. Release zamani `develop` uzerinden `release/<versiyon>` olustur.
4. Release branch'i testten gectikten sonra hem `main` hem `develop` branch'lerine merge et.
5. Acil bugfix icin `main` uzerinden `hotfix/<isim>` olustur, sonra hem `main` hem `develop` a merge et.

## GitHub Actions

- `gitflow-ci.yml`
  - `develop`, `feature/*`, `release/*`, `hotfix/*` push'larinda calisir.
  - `develop` ve `main` hedefli PR'larda calisir.
  - Laravel test ve frontend build yapar.

- `deploy-main.yml`
  - Sadece `main` branch'ine push oldugunda calisir.
  - Build alir ve FTP ile production'a deploy eder.

## Gerekli GitHub Secrets

Repository `Settings > Secrets and variables > Actions` altinda su secret'lari ekle:

- `FTP_SERVER` = `91.241.49.28`
- `FTP_USERNAME` = `hediyeme`
- `FTP_PASSWORD` = `jsy6jyZy8P4YBkjz`
- `FTP_PORT` = `3306`
