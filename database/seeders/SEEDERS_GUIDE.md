# Seeders - Guide d'Utilisation

## Vue d'ensemble

Les seeders dans ce projet remplissent la base de données avec des données de test et de configuration. Ils sont organisés par fonction.

---

## Seeders Disponibles

### 1. **EmployeeStructureSeeder** (Principal)
Crée la structure de base pour la gestion des employés:
- **Statuts employé** (Actif, Mis à pied, Retraité, etc.)
- **Types de contrats** (CDI, CDD, Stagiaire, Temporaire)
- **États civils** (Célibataire, Marié, Divorcé, Veuf)
- **Contrats employé** - Pour les 5 premiers employés
- **Informations familiales** - État civil et nombre d'enfants
- **Personnes à charge** - Enfants/dépendants
- **Notations mensuelles** - Évaluations des 3 derniers mois
- **Historique des postes** - Poste actuel
- **Logs historiques** - Événements d'embauche
- **Tâches du personnel** - Tâches assignées

**Appelé automatiquement** lors de `php artisan db:seed`

---

### 2. **EmployeeStatisticsSeeder**
Génère des données statistiques et historiques:
- **Événements historiques** - Promotions, formations, congés
- **Notations mensuelles** - Données pour les 12 derniers mois
- **Observations** - Annotations pour chaque mois

**Appelé automatiquement** lors de `php artisan db:seed`

---

### 3. **EmployeeCareerSeeder** (Optionnel)
Génère des informations détaillées de carrière:
- **Historique des postes antérieurs** - Mutations et progressions
- **Durées de postes** - Informations de période
- **Superviseurs** - Noms des responsables précédents
- **Événements de transfert** - Logs des mutations

**Utilisation:** Exécuter séparément pour ajouter des données de carrière

---

## Commandes d'Exécution

### Seeding Complet
Exécute tous les seeders:
```bash
php artisan db:seed
```

### Seeding Spécifique
Exécuter un seeder particulier:
```bash
php artisan db:seed --class=EmployeeStructureSeeder
php artisan db:seed --class=EmployeeStatisticsSeeder
php artisan db:seed --class=EmployeeCareerSeeder
```

### Réinitialisation Complète
Recrée les migrations et seeders:
```bash
php artisan migrate:refresh --seed
```

### Réinitialisation avec Spécifique
Recrée et exécute un seeder spécifique:
```bash
php artisan migrate:refresh
php artisan db:seed --class=EmployeeStructureSeeder
```

---

## Données Générées

### Après EmployeeStructureSeeder

| Table | Enregistrements | Description |
|-------|-----------------|-------------|
| employee_statuses | 10 | Tous les statuts disponibles |
| contract_types | 4 | CDI, CDD, Stagiaire, Temporaire |
| marital_statuses | 4 | Célibataire, Marié, Divorcé, Veuf |
| employee_contracts | ~5 | 1 contrat par employé (premiers 5) |
| employee_family_info | ~5 | Infos familiales (premiers 5 employés) |
| employee_dependents | ~5-15 | Enfants basés sur nombre défini |
| employee_monthly_ratings | ~15 | 3 mois × 5 employés |
| employee_position_history | ~5 | Poste actuel |
| employee_history_logs | ~5 | Événements d'embauche |
| personnel_tasks | ~4-8 | Tâches par direction |

### Après EmployeeStatisticsSeeder

| Table | Enregistrements Ajoutés | Description |
|-------|-------------------------|-------------|
| employee_history_logs | +20-30 | Événements divers (promotions, formations, congés) |
| employee_monthly_ratings | +100-120 | Données pour 10 employés × 12 mois |

### Après EmployeeCareerSeeder

| Table | Enregistrements Ajoutés | Description |
|-------|-------------------------|-------------|
| employee_position_history | +5-10 | Postes antérieurs pour seniors |
| employee_history_logs | +5-10 | Événements de transfert |

---

## Modèle de Données Généré

### Exemple 1: Contrat CDI
```php
EmployeeContract {
    employe_id: 1,
    contract_type_id: 1, // CDI
    start_date: "2024-01-01",
    end_date: null, // CDI n'a pas de fin
    salary: 50000,
    is_active: true
}
```

### Exemple 2: Informations Familiales
```php
EmployeeFamilyInfo {
    employe_id: 1,
    marital_status_id: 1, // Marié
    spouse_name: "Conjoint(e) Dupont",
    number_of_children: 2
}
```

### Exemple 3: Notation Mensuelle
```php
EmployeeMonthlyRating {
    employe_id: 1,
    departement_id: 1,
    year: 2026,
    month: 6,
    performance_score: 8.5,
    attendance_score: 9.0,
    productivity_score: 8.0,
    observations: "Excellent travail ce mois"
}
```

### Exemple 4: Log Historique
```php
EmployeeHistoryLog {
    employe_id: 1,
    event_type: "promoted",
    event_date: "2026-01-15",
    reason: "Excellence professionnelle",
    recorded_by_id: 1
}
```

---

## Conseils et Bonnes Pratiques

### 1. **Ordre d'Exécution Recommandé**
```bash
# 1. Réinitialiser les migrations et données
php artisan migrate:refresh --seed

# 2. (Optionnel) Ajouter des données de carrière
php artisan db:seed --class=EmployeeCareerSeeder
```

### 2. **Tester les Données**
Après seeding, vérifiez les données:
```bash
php artisan tinker
> Employe::with(['contracts', 'familyInfo', 'monthlyRatings'])->first()
```

### 3. **Développement Itératif**
Pendant le développement, réinitialisez souvent:
```bash
php artisan migrate:fresh --seed
```

### 4. **Customiser les Seeders**
Modifiez les fichiers seeders pour:
- Changer les nombre d'enregistrements
- Personnaliser les valeurs par défaut
- Ajouter des données spécifiques

---

## Troubleshooting

### Erreur: "Table not found"
**Solution:** Exécutez les migrations d'abord:
```bash
php artisan migrate
```

### Erreur: "Foreign key constraint failed"
**Solution:** Vérifiez que toutes les tables parent existent:
```bash
php artisan migrate:fresh --seed
```

### Données en doublon après seeding
**Solution:** Les seeders utilisent `firstOrCreate` pour éviter les doublons. Réinitialisez si nécessaire:
```bash
php artisan migrate:refresh --seed
```

---

## Statistiques Supportées par les Données

Avec les seeders, vous pouvez analyser:

1. **Employés Actifs** - Status 'actif'
2. **Employés Inactifs** - Status 'demission', 'retraite', 'deces'
3. **En Formation** - Événement historique 'formation'
4. **En Congé** - Événement 'leave_medical', 'leave_extended'
5. **Performance** - Notations mensuelles (monthly_ratings)
6. **Carrière** - Historique des postes (position_history)
7. **Tendances** - Données sur 12 mois disponibles

---

## Aide Supplémentaire

Pour plus d'informations sur les relations:
- Voir `ARCHITECTURE_RH.md`
- Consulter les modèles dans `app/Models/`
- Vérifier les migrations dans `database/migrations/`

---
