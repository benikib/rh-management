<?php

namespace Database\Seeders;

use App\Models\Departement;
use App\Models\Employe;
use App\Models\Poste;
use Illuminate\Database\Seeder;

class EmployeSeeder extends Seeder
{
    public function run(): void
    {
        $rh = Departement::where('nom', 'Ressources Humaines')->first();
        $it = Departement::where('nom', 'Informatique')->first();
        $finance = Departement::where('nom', 'Finance')->first();
        $commercial = Departement::where('nom', 'Commercial')->first();
        $logistique = Departement::where('nom', 'Logistique')->first();

        $directeurRh = Poste::where('titre', 'Directeur RH')->first();
        $chargeRecrutement = Poste::where('titre', 'Chargé de recrutement')->first();
        $devFullStack = Poste::where('titre', 'Développeur full-stack')->first();
        $supportIt = Poste::where('titre', 'Technicien support IT')->first();
        $comptable = Poste::where('titre', 'Comptable')->first();
        $commercialTerrain = Poste::where('titre', 'Commercial terrain')->first();
        $respLogistique = Poste::where('titre', 'Responsable logistique')->first();

        $employes = [
            [
                'matricule' => 'EMP-001',
                'departement_id' => $rh->id,
                'poste_id' => $directeurRh->id,
                'nom' => 'Ilunga',
                'postnom' => 'Mbuyi',
                'prenom' => 'Grace',
                'sexe' => 'Feminin',
                'date_naissance' => '1985-03-12',
                'telephone' => '+243 900 111 001',
                'email' => 'grace.ilunga@rh-management.com',
                'adresse' => 'Kinshasa, Gombe',
                'date_embauche' => '2018-01-15',
                'salaire_base' => 3400.00,
                'statut' => 'Actif',
            ],
            [
                'matricule' => 'EMP-002',
                'departement_id' => $rh->id,
                'poste_id' => $chargeRecrutement->id,
                'nom' => 'Tshimanga',
                'postnom' => 'Kabongo',
                'prenom' => 'Patrick',
                'sexe' => 'Masculin',
                'date_naissance' => '1990-07-22',
                'telephone' => '+243 900 111 002',
                'email' => 'patrick.tshimanga@rh-management.com',
                'adresse' => 'Kinshasa, Limete',
                'date_embauche' => '2020-06-01',
                'salaire_base' => 1750.00,
                'statut' => 'Actif',
            ],
            [
                'matricule' => 'EMP-003',
                'departement_id' => $it->id,
                'poste_id' => $devFullStack->id,
                'nom' => 'Mwamba',
                'postnom' => 'Kalala',
                'prenom' => 'David',
                'sexe' => 'Masculin',
                'date_naissance' => '1992-11-05',
                'telephone' => '+243 900 111 003',
                'email' => 'david.mwamba@rh-management.com',
                'adresse' => 'Kinshasa, Ngaliema',
                'date_embauche' => '2021-03-10',
                'salaire_base' => 2150.00,
                'statut' => 'Actif',
            ],
            [
                'matricule' => 'EMP-004',
                'departement_id' => $it->id,
                'poste_id' => $supportIt->id,
                'nom' => 'Ngoy',
                'postnom' => 'Mutombo',
                'prenom' => 'Serge',
                'sexe' => 'Masculin',
                'date_naissance' => '1995-02-18',
                'telephone' => '+243 900 111 004',
                'email' => 'serge.ngoy@rh-management.com',
                'adresse' => 'Kinshasa, Bandalungwa',
                'date_embauche' => '2022-09-01',
                'salaire_base' => 1180.00,
                'statut' => 'Actif',
            ],
            [
                'matricule' => 'EMP-005',
                'departement_id' => $finance->id,
                'poste_id' => $comptable->id,
                'nom' => 'Kasongo',
                'postnom' => 'Luboya',
                'prenom' => 'Aline',
                'sexe' => 'Feminin',
                'date_naissance' => '1988-09-30',
                'telephone' => '+243 900 111 005',
                'email' => 'aline.kasongo@rh-management.com',
                'adresse' => 'Kinshasa, Kintambo',
                'date_embauche' => '2019-04-20',
                'salaire_base' => 1580.00,
                'statut' => 'Actif',
            ],
            [
                'matricule' => 'EMP-006',
                'departement_id' => $commercial->id,
                'poste_id' => $commercialTerrain->id,
                'nom' => 'Banza',
                'postnom' => 'Mukendi',
                'prenom' => 'Eric',
                'sexe' => 'Masculin',
                'date_naissance' => '1993-12-08',
                'telephone' => '+243 900 111 006',
                'email' => 'eric.banza@rh-management.com',
                'adresse' => 'Kinshasa, Masina',
                'date_embauche' => '2023-01-09',
                'salaire_base' => 1350.00,
                'statut' => 'Actif',
            ],
            [
                'matricule' => 'EMP-007',
                'departement_id' => $logistique->id,
                'poste_id' => $respLogistique->id,
                'nom' => 'Mputu',
                'postnom' => 'Tshilombo',
                'prenom' => 'Olivier',
                'sexe' => 'Masculin',
                'date_naissance' => '1987-05-14',
                'telephone' => '+243 900 111 007',
                'email' => 'olivier.mputu@rh-management.com',
                'adresse' => 'Kinshasa, Ndjili',
                'date_embauche' => '2017-11-01',
                'salaire_base' => 1980.00,
                'statut' => 'Actif',
            ],
            [
                'matricule' => 'EMP-008',
                'departement_id' => $commercial->id,
                'poste_id' => $commercialTerrain->id,
                'nom' => 'Kabeya',
                'postnom' => 'Nsimba',
                'prenom' => 'Ruth',
                'sexe' => 'Feminin',
                'date_naissance' => '1996-08-25',
                'telephone' => '+243 900 111 008',
                'email' => 'ruth.kabeya@rh-management.com',
                'adresse' => 'Kinshasa, Lemba',
                'date_embauche' => '2024-02-14',
                'salaire_base' => 1300.00,
                'statut' => 'Inactif',
            ],
        ];

        foreach ($employes as $employe) {
            Employe::updateOrCreate(
                ['matricule' => $employe['matricule']],
                $employe
            );
        }
    }
}
