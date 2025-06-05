# Artihub - Back-End

Ce projet constitue la partie **back-end** du site Artihub, développé en **PHP natif** sans framework, avec une architecture modulaire.

## ✅ Pré-requis

- PHP ≥ 8.0
- Serveur local type **MAMP**, **XAMPP** ou `php -S`
- MySQL ≥ 5.7
- Logiciel de test d’API : [Postman](https://www.postman.com/) recommandé

---

## 🚀 Démarrage du serveur

Dans le terminal, placez-vous dans le dossier `back-end/` et lancez :

```bash
php -S https://artihubback-end-production.up.railway.app
```

> Le serveur tourne ensuite sur : [http://https://artihubback-end-production.up.railway.app](http://https://artihubback-end-production.up.railway.app)

---

## ⚙️ Configuration base de données

Le fichier `config/database.php` contient les identifiants de connexion :

```php
$host = 'localhost';
$db   = 'artihub';
$user = 'root';
$pass = 'root'; // ou '' selon votre configuration MAMP
```

Créez la base de données avec le script SQL si besoin (`artihub.sql`).

---

## 📂 Structure du projet

```bash
back-end/
├── auth/             # Login & Register
├── config/           # Connexion MySQL (PDO)
├── controllers/      # Logique des entités
├── middleware/       # auth_required.php (authentification session)
├── models/           # Modèles SQL
├── routes/           # Endpoints accessibles
└── README.md         # Ce fichier
```

---

## 🔐 Authentification (Sessions PHP)

### Inscription (register)

`POST /auth/register.php`

```json
{
  "username": "kevin",
  "password": "securepass",
  "email": "kevin@mail.com",
  "role": "artisan"
}
```

### Connexion (login)

`POST /auth/login.php`

```json
{
  "username": "kevin",
  "password": "securepass"
}
```

Une fois connecté, une **session PHP est active** (cookie).

---

## 🔒 Routes protégées

Toutes les routes dans `/routes/*.php` sont sécurisées via `middleware/auth_required.php`.

Exemple :

```bash
GET /routes/project.php
POST /routes/evaluation.php
```

---

## 📤 Exemple de requêtes Postman

### ➕ Ajouter une évaluation

`POST /routes/evaluation.php`

```json
{
  "evaluator_id": 1,
  "evaluated_id": 2,
  "rating": 5,
  "comment": "Super boulot !"
}
```

### 🔁 S’abonner à un plan

`POST /routes/subscription.php`

```json
{
  "user_id": 3,
  "plan_id": 2,
  "start_date": "2025-06-01",
  "end_date": "2025-12-01"
}
```

---

## 📌 Entités disponibles

- ✅ Users
- ✅ Projects
- ✅ ServiceRequests
- ✅ Evaluations
- ✅ Favorites
- ✅ Notifications
- ✅ LabelProjects
- ✅ UserCertificates
- ✅ Plans
- ✅ Subscriptions
- ✅ Payments
- ✅ BlacklistSystem
- ⏳ Messages (à venir)

---

## 🧪 Tests et conseils

- Utilisez **Postman** ou **Insomnia** pour tester vos routes
- Activez les cookies dans Postman pour conserver la session
- Si vous voyez `"Database connection failed"` : vérifiez vos identifiants MySQL
- Consultez les logs dans le terminal pour tout `500 Internal Server Error`
- 
