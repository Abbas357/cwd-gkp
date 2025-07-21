<?php

namespace App\Http\Controllers\ServiceCard;

use App\Models\ServiceCard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceCard\RenewedMail;
use App\Mail\ServiceCard\VerifiedMail;

class ServiceCardActionController extends Controller
{
    public function verify(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->approval_status !== 'verified') {
            $ServiceCard->approval_status = 'verified';
            $ServiceCard->status_updated_at = now();
            $ServiceCard->status_updated_by = auth_user()->id;
            
            // Set issued and expiry dates if not already set
            if (!$ServiceCard->issued_at) {
                $ServiceCard->issued_at = now();
            }
            if (!$ServiceCard->expired_at) {
                $ServiceCard->expired_at = now()->addYear();
            }
            
            if ($ServiceCard->save()) {
                // Mail::to($ServiceCard->user->email)->queue(new VerifiedMail($ServiceCard));
                return response()->json(['success' => 'Service Card has been verified successfully.']);
            }
        }
        return response()->json(['error' => 'Service Card can\'t be verified.']);
    }

    public function restore(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->approval_status === 'rejected') {
            $ServiceCard->approval_status = 'draft';
            $ServiceCard->status_updated_at = now();
            $ServiceCard->status_updated_by = auth_user()->id;
            
            if ($ServiceCard->save()) {
                return response()->json(['success' => 'Service Card has been restored successfully.']);
            }
        }
        return response()->json(['error' => 'Service Card can\'t be restored.']);
    }

    public function reject(Request $request, ServiceCard $ServiceCard)
    {
        if (!in_array($ServiceCard->approval_status, ['verified', 'rejected'])) {
            $ServiceCard->approval_status = 'rejected';
            $ServiceCard->status_updated_at = now();
            $ServiceCard->status_updated_by = auth_user()->id;
            
            if ($ServiceCard->save()) {
                return response()->json(['success' => 'Service Card has been rejected.']);
            }
        }
        return response()->json(['error' => 'Service Card can\'t be rejected.']);
    }

    public function renew(Request $request, ServiceCard $ServiceCard)
    {
        if (!$ServiceCard->canBeRenewed()) {
            return response()->json(['error' => 'Service Card cannot be renewed at this time.']);
        }

        // Mark current card as expired
        $ServiceCard->card_status = 'expired';
        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        $ServiceCard->save();

        // Create new card
        $newCard = ServiceCard::create([
            'uuid' => Str::uuid(),
            'user_id' => $ServiceCard->user_id,
            'approval_status' => 'verified',
            'card_status' => 'active',
            'issued_at' => now(),
            'expired_at' => now()->addYear(),
            'status_updated_at' => now(),
            'status_updated_by' => auth_user()->id,
            'remarks' => 'Renewed from card #' . $ServiceCard->id,
        ]);
        
        // Mail::to($ServiceCard->user->email)->queue(new RenewedMail($newCard));

        return response()->json(['success' => 'Service Card has been renewed successfully.', 'new_card_id' => $newCard->id]);
    }

    public function revoke(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->approval_status !== 'verified' || $ServiceCard->card_status !== 'active') {
            return response()->json(['error' => 'Only active verified cards can be revoked'], 400);
        }

        $request->validate([
            'reason' => 'required|string'
        ]);

        $ServiceCard->card_status = 'revoked';
        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        
        $existingRemarks = $ServiceCard->remarks ? $ServiceCard->remarks . "\n" : '';
        $ServiceCard->remarks = $existingRemarks . "[" . now()->format('Y-m-d H:i') . "] Revoked: {$request->reason}";
        
        if ($ServiceCard->save()) {
            // Optionally send notification email
            return response()->json(['success' => 'Service Card has been revoked']);
        }
        
        return response()->json(['error' => 'Failed to revoke card'], 500);
    }

    public function markLost(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->approval_status !== 'verified' || $ServiceCard->card_status !== 'active') {
            return response()->json(['error' => 'Only active verified cards can be marked as lost'], 400);
        }

        $ServiceCard->card_status = 'lost';
        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        
        $existingRemarks = $ServiceCard->remarks ? $ServiceCard->remarks . "\n" : '';
        $ServiceCard->remarks = $existingRemarks . "[" . now()->format('Y-m-d H:i') . "] Marked as lost";
        
        if ($ServiceCard->save()) {
            return response()->json(['success' => 'Service Card has been marked as lost']);
        }
        
        return response()->json(['error' => 'Failed to mark card as lost'], 500);
    }

    public function reprint(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->approval_status !== 'verified' || $ServiceCard->card_status !== 'lost') {
            return response()->json(['error' => 'Only lost cards can be reprinted'], 400);
        }

        $newCard = ServiceCard::create([
            'uuid' => Str::uuid(),
            'user_id' => $ServiceCard->user_id,
            'approval_status' => 'verified',
            'card_status' => 'active',
            'issued_at' => now(),
            'expired_at' => $ServiceCard->expired_at, // Keep same expiry
            'status_updated_at' => now(),
            'status_updated_by' => auth_user()->id,
            'is_duplicate' => true,
            'remarks' => 'Reprinted replacement for lost card #' . $ServiceCard->id,
        ]);

        $ServiceCard->card_status = 'reprinted';
        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        $ServiceCard->remarks = sprintf(
            "%s[%s] Reprinted as card #%d",
            $ServiceCard->remarks ? "$ServiceCard->remarks\n" : '',
            now()->format('Y-m-d H:i'),
            $newCard->id
        );
        $ServiceCard->save();

        return response()->json([
            'success' => 'Service Card has been reprinted',
            'new_card_id' => $newCard->id
        ]);
    }

    public function updateStatus(Request $request, ServiceCard $ServiceCard)
    {
        $request->validate([
            'card_status' => 'required|in:active,expired,revoked,lost,reprinted',
            'remarks' => 'nullable|string'
        ]);

        $ServiceCard->card_status = $request->card_status;
        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        
        if ($request->has('remarks')) {
            $existingRemarks = $ServiceCard->remarks ? $ServiceCard->remarks . "\n" : '';
            $ServiceCard->remarks = $existingRemarks . "[" . now()->format('Y-m-d H:i') . "] Status changed to {$request->card_status}: {$request->remarks}";
        }
        
        if ($ServiceCard->save()) {
            return response()->json(['success' => 'Card status updated successfully']);
        }
        
        return response()->json(['error' => 'Failed to update card status'], 500);
    }
}
