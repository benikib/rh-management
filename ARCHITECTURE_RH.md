# Architecture Structurelle du Système RH

## Vue d'ensemble

Le système RH Management a été structuré pour supporter les exigences complètes de gestion des ressources humaines en incluant les statuts employé, les contrats, les allocations familiales, la carrière, et l'historisation.

---

## 1. Gestion des Statuts Employé

### Table: `employee_statuses`
Définit les différents statuts possibles d'un employé.

**Statuts disponibles:**
- `actif` - Employé actif
- `mis_a_pied` - Mis à pied disciplinaire
- `disponibilite` - Mis en disponibilité
- `suspension` - Suspension
- `revocation` - Révocation
- `deces` - Décédé
- `retraite` - Retraité
- `formation` - En formation
- `maladie` - Arrêt maladie
- `demission` - Démission

**Relation:** `Employe` -> `EmployeeStatus` (many-to-one)

---

## 2. Gestion des Contrats

### Tables:
- `contract_types` - Types de contrats (CDI, CDD, Stagiaire, Temporaire)
- `employee_contracts` - Contrats spécifiques pour chaque employé

### Types de Contrats:
- **CDI** - Contrat à durée indéterminée (pas de date de fin)
- **CDD** - Contrat à durée déterminée (avec date de fin)
- **Stagiaire** - Contrat de stage (avec date de fin)
- **Temporaire** - Période d'essai (avec date de fin)

### Modèles:
- `ContractType` - Définit les types disponibles
- `EmployeeContract` - Contrat d'un employé

**Relations:**
```
Employe -> EmployeeContract (1-to-many)
EmployeeContract -> ContractType (many-to-1)
```

**Accesseurs utiles:**
```php
$contract->contract_duration_days  // Nombre de jours du contrat
$contract->remaining_days          // Jours restants avant expiration
```

---

## 3. Allocations Familiales

### Tables:
- `marital_statuses` - États civils (Célibataire, Marié, Divorcé, Veuf)
- `employee_family_info` - Informations familiales de l'employé
- `employee_dependents` - Enfants/personnes à charge

### États civils:
- `single` - Célibataire
- `married` - Marié
- `divorced` - Divorcé
- `widowed` - Veuf(ve)

### Modèles:
- `MaritalStatus` - État civil
- `EmployeeFamilyInfo` - Informations du couple
- `EmployeeDependent` - Enfants et autres dépendants

**Relations:**
```
Employe -> EmployeeFamilyInfo (1-to-1)
EmployeeFamilyInfo -> MaritalStatus (many-to-1)
Employe -> EmployeeDependent (1-to-many)
```

**Champs importants:**
- Acte de mariage (`marriage_certificate_path`)
- Attestation de scolarité (`school_certificate_path`)
- Document de composition familiale (`family_composition_document`)

---

## 4. Carrière et Évaluations

### Tables:
- `employee_monthly_ratings` - Notations mensuelles
- `employee_position_history` - Historique des postes

### Modèles:
- `EmployeeMonthlyRating` - Note mensuelle avec paramètres
- `EmployeePositionHistory` - Historique des mutations/promotions

**Paramètres de notation:**
- `performance_score` - Score de performance
- `attendance_score` - Score de présence
- `productivity_score` - Score de productivité
- `observations` - Notes libres

**Relations:**
```
Employe -> EmployeeMonthlyRating (1-to-many)
Employe -> EmployeePositionHistory (1-to-many)
```

---

## 5. Tâches du Personnel

### Table: `personnel_tasks`
Gestion des tâches assignées par les directeurs au personnel.

### Modèle: `PersonnelTask`

**Relations:**
```
Direction -> PersonnelTask (1-to-many)
Departement -> PersonnelTask (1-to-many)
User -> PersonnelTask (assigned_by)
Employe -> PersonnelTask (assigned_to)
```

**États de tâche:**
- `pending` - En attente
- `in_progress` - En cours
- `completed` - Complétée
- `cancelled` - Annulée

**Priorités:**
- `low` - Basse
- `medium` - Moyenne
- `high` - Haute
- `urgent` - Urgente

---

## 6. Historisation des Employés

### Table: `employee_history_logs`
Enregistrement de tous les événements concernant un employé.

### Modèle: `EmployeeHistoryLog`

**Types d'événements:**
- `hired` - Embauche
- `promoted` - Promotion
- `transferred` - Mutation
- `demoted` - Rétrogradation
- `formation` - Formation
- `leave_medical` - Arrêt maladie
- `leave_extended` - Absence prolongée
- `deceased` - Décédé
- `retired` - Retraité
- `dismissed` - Renvoyé
- `resigned` - Démissionné
- `disciplinary` - Sanction disciplinaire
- `reactivated` - Réactivé

**Relations:**
```
Employe -> EmployeeHistoryLog (1-to-many)
EmployeeStatus -> EmployeeHistoryLog (1-to-many)
User -> EmployeeHistoryLog (recorded_by)
```

---

## 7. Statistiques Supportées

Le système permet de générer des statistiques pour les périodes suivantes:
- Jour
- Semaine
- Mois
- Trimestre
- Semestre
- Année

### Catégories:
1. **Employés actifs** - Ceux présents dans le système
2. **Employés inactifs:**
   - Ayant quitté par démission
   - En arrêt maladie
   - Décédés
   - À la retraite
   - Ayant été renvoyés
3. **Employés actifs avec situations spéciales:**
   - En formation
   - En absence prolongée pour maladie

---

## 8. Diagramme des Relations

```
User
 ├── PersonnelTask (assigned_by)
 └── EmployeeHistoryLog (recorded_by)

Direction
 └── PersonnelTask (1-to-many)

Departement
 ├── EmployeeMonthlyRating (1-to-many)
 └── PersonnelTask (1-to-many)

Employe
 ├── EmployeeStatus
 ├── EmployeeContract -> ContractType
 ├── EmployeeFamilyInfo -> MaritalStatus
 ├── EmployeeDependent
 ├── EmployeeMonthlyRating
 ├── EmployeePositionHistory -> Poste
 ├── PersonnelTask
 └── EmployeeHistoryLog -> EmployeeStatus

```

---

## 9. Utilisation dans le Code

### Créer un contrat:
```php
$contract = EmployeeContract::create([
    'employe_id' => $employe->id,
    'contract_type_id' => 1, // CDI
    'start_date' => '2026-01-01',
    'salary' => 50000,
    'is_active' => true,
]);
```

### Enregistrer un événement:
```php
EmployeeHistoryLog::create([
    'employe_id' => $employe->id,
    'event_type' => 'promoted',
    'event_date' => now(),
    'status_id' => $employe->status_id,
    'reason' => 'Excellence au travail',
    'recorded_by_id' => auth()->id(),
]);
```

### Assigner une tâche:
```php
PersonnelTask::create([
    'direction_id' => $direction->id,
    'departement_id' => $departement->id,
    'assigned_by_id' => auth()->id(),
    'assigned_to_id' => $employe->id,
    'title' => 'Rapport mensuel',
    'description' => 'Préparer le rapport mensuel du département',
    'priority' => 'high',
    'due_date' => now()->addDays(5),
]);
```

### Évaluer un employé:
```php
EmployeeMonthlyRating::create([
    'employe_id' => $employe->id,
    'departement_id' => $departement->id,
    'year' => 2026,
    'month' => 6,
    'performance_score' => 8.5,
    'attendance_score' => 9.0,
    'productivity_score' => 8.0,
    'observations' => 'Excellent travail ce mois-ci',
]);
```

---

## 10. Notes de Migration

Exécutez toutes les migrations dans cet ordre:
```bash
php artisan migrate
```

Les migrations incluent:
1. Statuts employé
2. Types de contrats
3. Contrats employé
4. États civils
5. Informations familiales
6. Personnes à charge
7. Notes mensuelles
8. Historique des postes
9. Tâches du personnel
10. Historique des employés
11. Colonne status_id dans employes

---

## 11. Points d'Amélioration Futurs

- [ ] Authentification multi-rôles pour directeurs
- [ ] Dashboard de visualisation des statistiques
- [ ] Export de rapports en PDF/Excel
- [ ] Notifications automatiques pour tâches
- [ ] Workflow d'approbation pour mutations
- [ ] Archivage automatique des anciens logs
- [ ] API REST pour intégrations tierces
