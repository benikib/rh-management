<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\Employe;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $documents = [
            [
                'matricule' => 'EMP-001',
                'nom_document' => 'Contrat de travail',
                'fichier' => 'documents/contrat-emp-001.pdf',
                'type_document' => 'Contrat',
            ],
            [
                'matricule' => 'EMP-001',
                'nom_document' => 'Carte d\'identité',
                'fichier' => 'documents/cni-emp-001.pdf',
                'type_document' => 'Pièce d\'identité',
            ],
            [
                'matricule' => 'EMP-003',
                'nom_document' => 'Certificat Laravel',
                'fichier' => 'documents/certificat-emp-003.pdf',
                'type_document' => 'Formation',
            ],
            [
                'matricule' => 'EMP-005',
                'nom_document' => 'Attestation de travail',
                'fichier' => 'documents/attestation-emp-005.pdf',
                'type_document' => 'Attestation',
            ],
            [
                'matricule' => 'EMP-007',
                'nom_document' => 'Permis de conduire',
                'fichier' => 'documents/permis-emp-007.pdf',
                'type_document' => 'Permis',
            ],
        ];

        foreach ($documents as $doc) {
            $employe = Employe::where('matricule', $doc['matricule'])->first();

            if (! $employe) {
                continue;
            }

            Document::firstOrCreate(
                [
                    'employe_id' => $employe->id,
                    'nom_document' => $doc['nom_document'],
                ],
                [
                    'fichier' => $doc['fichier'],
                    'type_document' => $doc['type_document'],
                ]
            );
        }
    }
}
