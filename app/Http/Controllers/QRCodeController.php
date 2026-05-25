<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employe;
use App\Models\Presence;
use App\Models\QrToken;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use Illuminate\Support\Str;

class QRCodeController extends Controller
{
    /**
     * Afficher les QR codes du jour
     */
    public function index()
    {
        $today = Carbon::today();
        
        // Token pour l'arrivée - valable toute la journée
        $arriveeToken = QrToken::firstOrCreate(
            [
                'type' => 'arrivee',
                'date_validite' => $today
            ],
            [
                'token' => $this->generateUniqueToken(),
                'expires_at' => Carbon::today()->endOfDay(),
                'is_used' => false
            ]
        );
        
        // Token pour le départ - valable toute la journée
        $departToken = QrToken::firstOrCreate(
            [
                'type' => 'depart',
                'date_validite' => $today
            ],
            [
                'token' => $this->generateUniqueToken(),
                'expires_at' => Carbon::today()->endOfDay(),
                'is_used' => false
            ]
        );
        
        // URLs
        $arriveeUrl = url("/qr/scan/{$arriveeToken->token}");
        $departUrl = url("/qr/scan/{$departToken->token}");
        
        return view('qr.index', compact('arriveeUrl', 'departUrl', 'arriveeToken', 'departToken'));
    }
    
    /**
     * Formulaire après scan QR
     */
    /**
 * Formulaire après scan QR
 */
public function scanForm($token)
{
    $qrToken = QrToken::where('token', $token)
        ->where('date_validite', Carbon::today())
        ->first();
    
    if (!$qrToken) {
        return view('qr.error', ['message' => 'QR code invalide']);
    }
    
    if ($qrToken->isExpired()) {
        return view('qr.error', ['message' => 'Ce QR code a expiré']);
    }
    
    // Vérification que la variable 'type' est bien passée
    return view('qr.scan-form', [
        'token' => $token,
        'type' => $qrToken->type  // ← Cette ligne est essentielle
    ]);
}
    
    /**
     * Traiter le pointage par QR code
     */
    public function pointage(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'matricule' => 'required|string|exists:employes,matricule'
        ]);
        
        $employe = Employe::where('matricule', $request->matricule)->first();
        $qrToken = QrToken::where('token', $request->token)
            ->where('date_validite', Carbon::today())
            ->first();
        
        if (!$qrToken) {
            return response()->json(['success' => false, 'message' => 'QR code invalide']);
        }
        
        if ($qrToken->isExpired()) {
            return response()->json(['success' => false, 'message' => 'QR code expiré']);
        }
        
        $today = Carbon::today();
        $presence = Presence::firstOrNew([
            'employe_id' => $employe->id,
            'date_presence' => $today
        ]);
        
        if ($qrToken->type === 'arrivee') {
            if ($presence->heure_arrivee) {
                return response()->json(['success' => false, 'message' => 'Vous avez déjà pointé votre arrivée aujourd\'hui']);
            }
            $now = Carbon::now('Africa/Kinshasa');
            $presence->heure_arrivee = $now->format('H:i:s');
            $presence->statut = 'Present';
            $presence->remarque = 'Arrivée par QR code';
            $presence->save();
            
            return response()->json([
                'success' => true,
                'message' => '✅ Arrivée pointée à ' . $now->format('H:i:s')
            ]);
            
        } else { // depart
            if (!$presence->heure_arrivee) {
                return response()->json(['success' => false, 'message' => 'Vous devez d\'abord pointer votre arrivée']);
            }
            
            if ($presence->heure_depart) {
                return response()->json(['success' => false, 'message' => 'Vous avez déjà pointé votre départ aujourd\'hui']);
            }
            $now = Carbon::now('Africa/Kinshasa');
            $presence->heure_depart = $now->format('H:i:s');
            $presence->save();
            
            return response()->json([
                'success' => true,
                'message' => '✅ Départ pointé à ' . $now->format('H:i:s')
            ]);
        }
    }
    
    /**
     * Pointage manuel sans QR code (pour la réception)
     */
    public function pointageManuel(Request $request)
    {
        try {
            $request->validate([
                'matricule' => 'required|string|exists:employes,matricule',
                'type' => 'required|in:arrivee,depart'
            ]);
            
            $employe = Employe::where('matricule', $request->matricule)->first();
            
            if (!$employe) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employé non trouvé'
                ], 404);
            }
            
            $today = Carbon::today();
            $presence = Presence::firstOrNew([
                'employe_id' => $employe->id,
                'date_presence' => $today
            ]);
            
            $now = Carbon::now('Africa/Kinshasa');
            
            if ($request->type === 'arrivee') {
                if ($presence->heure_arrivee) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Vous avez déjà pointé votre arrivée aujourd\'hui'
                    ]);
                }
                
                $presence->heure_arrivee = $now->format('H:i:s');
                $presence->statut = 'Present';
                $presence->remarque = 'Arrivée par pointage manuel (réception)';
                $presence->save();
                
                return response()->json([
                    'success' => true,
                    'message' => '✅ Arrivée pointée à ' . $now->format('H:i:s')
                ]);
                
            } else { // depart
                if (!$presence->heure_arrivee) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Vous devez d\'abord pointer votre arrivée'
                    ]);
                }
                
                if ($presence->heure_depart) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Vous avez déjà pointé votre départ aujourd\'hui'
                    ]);
                }
                
                $presence->heure_depart = $now->format('H:i:s');
                $presence->save();
                
                return response()->json([
                    'success' => true,
                    'message' => '✅ Départ pointé à ' . $now->format('H:i:s')
                ]);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du pointage: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Générer un token unique
     */
    private function generateUniqueToken()
    {
        do {
            $token = Str::random(32);
        } while (QrToken::where('token', $token)->exists());
        
        return $token;
    }
    
    /**
     * Régénérer les QR codes
     */
    public function regenerate()
    {
        QrToken::where('date_validite', Carbon::today())->delete();
        return redirect()->route('qr.index')->with('success', 'QR codes régénérés');
    }

        /**
 * Vérifier les informations de l'employé
 */
public function verifierEmploye(Request $request)
{
    $request->validate([
        'matricule' => 'required|string|exists:employes,matricule'
    ]);
    
    $employe = Employe::where('matricule', $request->matricule)->first();
    
    if (!$employe) {
        return response()->json([
            'success' => false,
            'message' => 'Employé non trouvé'
        ], 404);
    }
    
    if ($employe->statut !== 'Actif') {
        return response()->json([
            'success' => false,
            'message' => 'Ce compte employé est inactif'
        ], 403);
    }
    
    return response()->json([
        'success' => true,
        'employe' => [
            'id' => $employe->id,
            'matricule' => $employe->matricule,
            'nom_complet' => $employe->nom_complet,
            'departement' => $employe->departement ? $employe->departement->nom : null,
            'poste' => $employe->poste ? $employe->poste->nom : null,
            'email' => $employe->email,
            'telephone' => $employe->telephone,
            'photo' => $employe->photo
        ]
    ]);
}
}