<?php

namespace App\Http\Controllers\ServiceCard;

use App\Models\ServiceCard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceCardActionController extends Controller
{
    public function pending(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->status === 'draft') {
            $ServiceCard->status = 'pending';
            $ServiceCard->status_updated_at = now();
            $ServiceCard->status_updated_by = auth_user()->id;
            
            $this->addRemark($ServiceCard, 'Under Review', 'Service card is now under review', auth_user());

            if ($ServiceCard->save()) {
                return response()->json(['success' => 'Service Card has been rejected.']);
            }
        }
        return response()->json(['error' => 'Service Card can\'t be rejected.']);
    }

    public function verify(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->status !== 'active') {
            $ServiceCard->status = 'active';
            $ServiceCard->status_updated_at = now();
            $ServiceCard->status_updated_by = auth_user()->id;
            
            if (!$ServiceCard->issued_at) {
                $ServiceCard->issued_at = now();
            }
            if (!$ServiceCard->expired_at) {
                $ServiceCard->expired_at = now()->addYears(3);
            }

            $this->addRemark($ServiceCard, 'Verification', 'Service card verified successfully', auth_user());
            
            if ($ServiceCard->save()) {
                return response()->json(['success' => 'Service Card has been verified successfully.']);
            }
        }
        return response()->json(['error' => 'Service Card can\'t be verified.']);
    }

    public function reject(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->status === 'draft' || $ServiceCard->status === 'pending') {
            $this->addRemark($ServiceCard, 'Rejection', $request->remarks, auth_user());
            
            $ServiceCard->status = 'rejected';
            $ServiceCard->status_updated_at = now();
            $ServiceCard->status_updated_by = auth_user()->id;
            
            if ($ServiceCard->save()) {
                return response()->json(['success' => 'Service Card has been rejected.']);
            }
        }
        
        return response()->json(['error' => 'Service Card can\'t be rejected.']);
    }

    public function restore(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->status === 'rejected') {
            $this->addRemark($ServiceCard, 'Restoration', $request->remarks, auth_user());
            
            $ServiceCard->status = 'pending'; 
            $ServiceCard->status_updated_at = now();
            $ServiceCard->status_updated_by = auth_user()->id;
            
            if ($ServiceCard->save()) {
                return response()->json(['success' => 'Service Card has been restored successfully.']);
            }
        }
        
        return response()->json(['error' => 'Service Card can\'t be restored.']);
    }

    public function markPrinted(Request $request, ServiceCard $ServiceCard)
    {
        if (in_array($ServiceCard->status, ['lost', 'expired'])) {
            return response()->json(['error' => 'These cards cannot be mark as printed, please']);
        }

        if (!in_array($ServiceCard->status, ['active', 'duplicate'])) {
            return response()->json(['error' => 'Only verified cards can be marked as printed']);
        }

        if ($ServiceCard->printed_at !== null) {
            return response()->json(['error' => 'This card is already Printed. Please check the printed tab']);
        }

        $ServiceCard->printed_at = now();
        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        
        $this->addRemark($ServiceCard, 'Printing', 'Card is printed, Please collect your card from C&W IT Cell, please', auth_user());
        
        if ($ServiceCard->save()) {
            return response()->json(['success' => 'Service Card has been marked as printed']);
        }
        
        return response()->json(['error' => 'Card cannot be printed'], 500);
    }

    public function renew(Request $request, ServiceCard $ServiceCard)
    {
        if (!$ServiceCard->isExpired()) {
            return response()->json(['error' => 'Service Card cannot be renewed as it is not expired yet.']);
        }

        if (!$ServiceCard->canBeRenewed()) {
            return response()->json(['error' => 'Service Card cannot be renewed at this time.']);
        }

        $this->addRemark($ServiceCard, 'Renewal', 'Service card renewal initiated', auth_user());

        $ServiceCard->status = 'expired';
        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        $ServiceCard->save();

        $newCard = ServiceCard::create([
            'uuid' => Str::uuid(),
            'user_id' => $ServiceCard->user_id,
            'posting_id' => auth_user()->currentPosting->id,
            'status' => 'active',
            'issued_at' => now(),
            'expired_at' => now()->addYears(3),
            'status_updated_at' => now(),
            'status_updated_by' => auth_user()->id,
            'remarks' => $this->formatRemark('Creation', 'Renewed from card #' . $ServiceCard->id, auth_user(), true),
        ]);
        
        return response()->json(['success' => 'Service Card has been renewed successfully. Card #: ' . $newCard->id]);
    }

    public function markLost(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->status !== 'active') {
            return response()->json(['error' => 'Only active cards can be marked as lost']);
        }

        $this->addRemark($ServiceCard, 'Status Update', 'Card marked as lost', auth_user());

        $ServiceCard->status = 'lost';
        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        
        $existingRemarks = $ServiceCard->remarks ? $ServiceCard->remarks . "\n" : '';
        $ServiceCard->remarks = $existingRemarks . "[" . now()->format('Y-m-d H:i') . "] Marked as lost";
        
        if ($ServiceCard->save()) {
            return response()->json(['success' => 'Service Card has been marked as lost']);
        }
        
        return response()->json(['error' => 'Failed to mark card as lost']);
    }

    public function duplicate(Request $request, ServiceCard $ServiceCard)
    {
        if ($ServiceCard->status !== 'lost') {
            return response()->json(['error' => 'Only lost cards can be reprinted']);
        }

        $newCard = ServiceCard::create([
            'uuid' => Str::uuid(),
            'user_id' => $ServiceCard->user_id,
            'posting_id' => auth_user()->currentPosting->id,
            'status' => 'duplicate',
            'issued_at' => now(),
            'expired_at' => $ServiceCard->expired_at,
            'status_updated_at' => now(),
            'status_updated_by' => auth_user()->id,
            'remarks' => $this->formatRemark('Creation', 'Replacement (Duplicate) for lost card #' . $ServiceCard->id, auth_user(), true),
        ]);

        $this->addRemark($ServiceCard, 'Duplication', 'Reprinted as card #' . $newCard->id, auth_user());

        $ServiceCard->status_updated_at = now();
        $ServiceCard->status_updated_by = auth_user()->id;
        $ServiceCard->save();

        return response()->json(['success' => 'Duplicate Service Card has been generated. Card #: ' . $newCard->id]);
    }

    private function addRemark(ServiceCard $serviceCard, $type, $remarks, $user = null)
    {
        $existingRemarks = $serviceCard->remarks ?? '';
        $newRemark = $this->formatRemark($type, $remarks, $user);
        
        if (!empty($existingRemarks)) {
            $serviceCard->remarks = $existingRemarks . "\n" . $this->getNextRemarkNumber($existingRemarks) . ". " . $newRemark;
        } else {
            $serviceCard->remarks = "1. " . $newRemark;
        }
    }

    private function getNextRemarkNumber($existingRemarks)
    {
        $lines = explode("\n", $existingRemarks);
        $maxNumber = 0;
        
        foreach ($lines as $line) {
            if (preg_match('/^(\d+)\./', trim($line), $matches)) {
                $maxNumber = max($maxNumber, (int)$matches[1]);
            }
        }
        
        return $maxNumber + 1;
    }

    private function formatRemark($type, $remarks, $user = null, $isFirstRemark = false)
    {
        $timestamp = now()->format('j, F Y') . ' at ' . now()->format('h:i A');
        $userInfo = $user ? " by {$user->name}" : "";
        
        $formatted = "{$type} Remarks: <strong>{$remarks}</strong> - <span style='color: #aaa; font-size: 12px'>{$timestamp}{$userInfo}</span>";
        
        if ($isFirstRemark) {
            return "1. " . $formatted;
        }
        
        return $formatted;
    }
}