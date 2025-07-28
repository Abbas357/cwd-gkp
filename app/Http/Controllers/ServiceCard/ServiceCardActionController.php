<?php

namespace App\Http\Controllers\ServiceCard;

use App\Models\ServiceCard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceCardActionController extends Controller
{
    public function verify(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->approval_status !== 'verified') {
            $ServiceCard->approval_status = 'verified';
            $ServiceCard->status_updated_at = now();
            $ServiceCard->status_updated_by = auth_user()->id;
            
            if (!$ServiceCard->issued_at) {
                $ServiceCard->issued_at = now();
            }
            if (!$ServiceCard->expired_at) {
                $ServiceCard->expired_at = now()->addYears(3);
            }
            
            if ($ServiceCard->save()) {
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

    public function markPrinted(Request $request, ServiceCard $ServiceCard)
    {
        if (in_array($ServiceCard->card_status, ['lost', 'expired'])) {
            return response()->json(['error' => 'These cards cannot be mark as printed, please']);
        }

        if ($ServiceCard->approval_status !== 'verified') {
            return response()->json(['error' => 'Only verified cards can be marked as printed']);
        }

        if ($ServiceCard->printed_at !== null) {
            return response()->json(['error' => 'This card is already Printed. Please check the printed tab']);
        }

        $ServiceCard->printed_at = now();
        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        
        // Add remarks
        $existingRemarks = $ServiceCard->remarks ? $ServiceCard->remarks . "\n" : '';
        $ServiceCard->remarks = $existingRemarks . "[" . now()->format('Y-m-d H:i') . "] Card printed by " . auth_user()->name;
        
        if ($ServiceCard->save()) {
            return response()->json(['success' => 'Service Card has been marked as printed']);
        }
        
        return response()->json(['error' => 'Card cannot be printed'], 500);
    }

    public function renew(Request $request, ServiceCard $ServiceCard)
    {
        // Check if card is not expired yet
        if (!$ServiceCard->isExpired()) {
            return response()->json(['error' => 'Service Card cannot be renewed as it is not expired yet.']);
        }

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
            'expired_at' => now()->addYears(3), // Changed from 1 year to 3 years
            'status_updated_at' => now(),
            'status_updated_by' => auth_user()->id,
            'remarks' => 'Renewed from card #' . $ServiceCard->id,
        ]);
        
        return response()->json(['success' => 'Service Card has been renewed successfully. Card #: ' . $newCard->id]);
    }

    public function markLost(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->approval_status !== 'verified' || $ServiceCard->card_status !== 'active') {
            return response()->json(['error' => 'Only active verified cards can be marked as lost']);
        }

        $ServiceCard->card_status = 'lost';
        $ServiceCard->printed_at = null;
        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        
        $existingRemarks = $ServiceCard->remarks ? $ServiceCard->remarks . "\n" : '';
        $ServiceCard->remarks = $existingRemarks . "[" . now()->format('Y-m-d H:i') . "] Marked as lost";
        
        if ($ServiceCard->save()) {
            return response()->json(['success' => 'Service Card has been marked as lost']);
        }
        
        return response()->json(['error' => 'Failed to mark card as lost']);
    }

    public function reprint(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->approval_status !== 'verified' || $ServiceCard->card_status !== 'lost') {
            return response()->json(['error' => 'Only lost cards can be reprinted']);
        }

        $newCard = ServiceCard::create([
            'uuid' => Str::uuid(),
            'user_id' => $ServiceCard->user_id,
            'approval_status' => 'verified',
            'card_status' => 'duplicate',
            'issued_at' => now(),
            'expired_at' => $ServiceCard->expired_at, // Keep same expiry
            'status_updated_at' => now(),
            'status_updated_by' => auth_user()->id,
            'is_duplicate' => true,
            'remarks' => 'Reprinted replacement for lost card #' . $ServiceCard->id,
        ]);

        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        $ServiceCard->remarks = sprintf(
            "%s[%s] Reprinted as card #%d",
            $ServiceCard->remarks ? "$ServiceCard->remarks\n" : '',
            now()->format('Y-m-d H:i'),
            $newCard->id
        );
        $ServiceCard->save();

        return response()->json(['success' => 'Duplicate Service Card has been generated. Card #: ' . $newCard->id]);
    }
}