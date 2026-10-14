# Firebase OAuth Setup - README

## Status Implementasi
✅ Migration firebase_uid → DONE
✅ FirebaseAuthController → DONE
✅ Route callback → DONE
✅ Login page + tombol Google → DONE
✅ Firebase SDK installed → DONE

## Yang Perlu Dilakukan Manual

### 1. Setup Firebase Console
Buka https://console.firebase.google.com

**Bikin Project:**
1. Klik "Add project"
2. Nama project: `perpustakaan-digital` (atau terserah)
3. Disable Google Analytics (optional)
4. Klik "Create project"

### 2. Download Service Account JSON
1. Klik ⚙️ (Settings) → "Project settings"
2. Tab "Service accounts"
3. Klik "Generate new private key"
4. Download file JSON
5. Rename jadi `firebase-credentials.json`
6. Copy ke folder: `storage/app/firebase/firebase-credentials.json`

### 3. Get Firebase Web Config
1. Masih di "Project settings"
2. Scroll ke bawah ke "Your apps"
3. Klik icon Web `</>`
4. Nama app: `perpustakaan-web`
5. Copy semua nilai dari `firebaseConfig` object

### 4. Update File Config
**File: `.env`**
Tambah di baris paling bawah:
```env
FIREBASE_CREDENTIALS=firebase/firebase-credentials.json
```

**File: `resources/views/layouts/guest.blade.php`**
Ganti line 37-44 (yang ada `YOUR-API-KEY`, dll) dengan nilai dari Firebase Console:
```javascript
const firebaseConfig = {
    apiKey: "AIzaSyXXXXXXXXXXXXXXXXXXXXXXXXXX",
    authDomain: "perpustakaan-digital.firebaseapp.com",
    projectId: "perpustakaan-digital",
    storageBucket: "perpustakaan-digital.appspot.com",
    messagingSenderId: "123456789012",
    appId: "1:123456789012:web:xxxxxxxxxxxxx"
};
```

### 5. Enable Google Sign-In
1. Di Firebase Console sidebar, klik "Authentication"
2. Tab "Sign-in method"
3. Klik "Google"
4. Toggle "Enable"
5. Support email: pilih email kamu
6. Klik "Save"

### 6. Test
1. Buka http://localhost:8000/login
2. Klik tombol "Login dengan Google"
3. Pilih akun Google
4. Harusnya redirect ke dashboard
5. Cek database tabel `users` → kolom `firebase_uid` terisi

## Troubleshooting

**Error: "auth/unauthorized-domain"**
- Firebase Console → Authentication → Settings → Authorized domains
- Tambah `localhost` dan domain produksi

**Error: "Failed to fetch"**
- Cek file `firebase-credentials.json` sudah ada di `storage/app/firebase/`
- Cek `.env` → `FIREBASE_CREDENTIALS` path benar

**Error: Token verification failed**
- Cek service account JSON valid
- Cek project ID sama antara web config & service account

## File yang Dimodifikasi
- `database/migrations/2026_10_12_151702_add_firebase_uid_to_users_table.php`
- `app/Http/Controllers/FirebaseAuthController.php`
- `routes/web.php`
- `resources/views/layouts/guest.blade.php`
- `resources/views/auth/login.blade.php`

## Flow Login Firebase
1. User klik tombol "Login dengan Google"
2. Popup Google OAuth muncul
3. User pilih akun → Firebase kasih ID token
4. JS kirim token ke `/auth/firebase/callback`
5. Laravel verifikasi token via Firebase Admin SDK
6. Cari/bikin user di database
7. Login via Laravel session
8. Redirect ke dashboard
