<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class LearnController extends Controller
{
    public function ePads()
    {
        $videos = collect([
            [
                'id' => 1,
                'title' => 'Tutorial for Contractor Registration',
                'url' => 'https://www.youtube.com/watch?v=Sa25f_8QZd4',
                'category' => 'general_video',
                'type' => 'video',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10)
            ],
            [
                'id' => 2,
                'title' => 'How To Create Procurement Plan',
                'url' => 'https://ppra.org.pk/EPADS/mm/PA-001 How To Create Procurement Plan.mp4',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8)
            ],
            [
                'id' => 3,
                'title' => 'How To Create Petty',
                'url' => 'https://ppra.org.pk/EPADS/mm/PA-002 How To Create Petty.mp4',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7)
            ],
            [
                'id' => 4,
                'title' => 'How to Create RFQ',
                'url' => 'https://ppra.org.pk/EPADS/mm/PA-003 How to Create RFQ.mp4',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(6),
                'updated_at' => now()->subDays(6)
            ],
            [
                'id' => 5,
                'title' => 'How To Create Committee',
                'url' => 'https://ppra.org.pk/EPADS/mm/PA004.mp4',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5)
            ],
            [
                'id' => 6,
                'title' => 'How to Create Tender through File Uploading',
                'url' => 'https://ppra.org.pk/EPADS/mm/PA-005 How to Create Tender through File Uploading.mp4',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4)
            ],
            [
                'id' => 7,
                'title' => 'How to evaluate Bids by file uploading',
                'url' => 'https://ppra.org.pk/EPADS/mm/PA-006 How to evaluate Bids by file uploading.mp4',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3)
            ],
            [
                'id' => 8,
                'title' => 'How to Create Tender (E-Submission)',
                'url' => 'https://ppra.org.pk/EPADS/mm/PA-007 How to Create Tender (E-Submission).mp4',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2)
            ],
            [
                'id' => 9,
                'title' => 'How to Evaluate Tender (E-Submission)',
                'url' => 'https://ppra.org.pk/EPADS/mm/PA-008 How to Evaluate Tender (E-Submission).mp4',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1)
            ],
            [
                'id' => 10,
                'title' => 'How to Create PQ-EOI',
                'url' => 'https://ppra.org.pk/EPADS/mm/PA-009 How to Create PQ-EOI.mp4',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 11,
                'title' => 'How to Evaluate Pre-Qualification-EOI',
                'url' => 'https://ppra.org.pk/EPADS/mm/PA-010 How to Evaluate Pre-Qualification-EOI.mp4',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 12,
                'title' => 'Supplier Registration',
                'url' => 'https://ppra.org.pk/EPADS/mm/SA 001 _ Supplier Registration.mp4',
                'category' => 'suppliers_bidders',
                'type' => 'video',
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15)
            ],
            [
                'id' => 13,
                'title' => 'Supplier Profile creation till Approval from PPRA',
                'url' => 'https://ppra.org.pk/EPADS/mm/SA 002 _ Supplier Profile creation till Approval from PPRA.mp4',
                'category' => 'suppliers_bidders',
                'type' => 'video',
                'created_at' => now()->subDays(14),
                'updated_at' => now()->subDays(14)
            ],
            [
                'id' => 14,
                'title' => 'How to quote in Petty-RFQ',
                'url' => 'https://ppra.org.pk/EPADS/mm/SA 003 _ How to quote in Petty-RFQ.mp4',
                'category' => 'suppliers_bidders',
                'type' => 'video',
                'created_at' => now()->subDays(13),
                'updated_at' => now()->subDays(13)
            ],
            [
                'id' => 15,
                'title' => 'Bidding (File-Uploading for Supplier)',
                'url' => 'https://ppra.org.pk/EPADS/mm/SA 004 _ Bidding (File-Uploading for Supplier).mp4',
                'category' => 'suppliers_bidders',
                'type' => 'video',
                'created_at' => now()->subDays(12),
                'updated_at' => now()->subDays(12)
            ],
            [
                'id' => 16,
                'title' => 'Bidding (E-Submission) for Supplier',
                'url' => 'https://ppra.org.pk/EPADS/mm/SA 005 _ Bidding (E-Submission) for Supplier.mp4',
                'category' => 'suppliers_bidders',
                'type' => 'video',
                'created_at' => now()->subDays(11),
                'updated_at' => now()->subDays(11)
            ],
            [
                'id' => 17,
                'title' => 'How to Participate in PQ-EOI',
                'url' => 'https://ppra.org.pk/EPADS/mm/SA 006 _ How to Participate in PQ-EOI.mp4',
                'category' => 'suppliers_bidders',
                'type' => 'video',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10)
            ],
            [
                'id' => 18,
                'title' => 'E-Catalogue For Supplier',
                'url' => 'https://ppra.org.pk/EPADS/mm/SA 007 _ E-Catalogue For Supplier.mp4',
                'category' => 'suppliers_bidders',
                'type' => 'video',
                'created_at' => now()->subDays(9),
                'updated_at' => now()->subDays(9)
            ],
            [
                'id' => 19,
                'title' => 'Procurement Plan UTM e-PADS',
                'url' => 'https://ppra.org.pk/EPADS/mm/plan.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(30),
                'updated_at' => now()->subDays(30)
            ],
            [
                'id' => 20,
                'title' => 'Supplier Management for PPRA Admins UTM e-PADS',
                'url' => 'https://ppra.org.pk/EPADS/mm/supplier.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(29),
                'updated_at' => now()->subDays(29)
            ],
            [
                'id' => 21,
                'title' => 'Supplier Management for Suppliers',
                'url' => 'https://ppra.org.pk/EPADS/mm/supplier2.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(28),
                'updated_at' => now()->subDays(28)
            ],
            [
                'id' => 22,
                'title' => 'User Management UTM e-PADS',
                'url' => 'https://ppra.org.pk/EPADS/mm/user.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(27),
                'updated_at' => now()->subDays(27)
            ],
            [
                'id' => 23,
                'title' => 'Pre-qualification and e-Submission, e-Evaluation',
                'url' => 'https://ppra.org.pk/EPADS/mm/esubmission.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(26),
                'updated_at' => now()->subDays(26)
            ],
            [
                'id' => 24,
                'title' => 'e-Sourcing to e-Contracting',
                'url' => 'https://ppra.org.pk/EPADS/mm/e-Sourcing to e-Contracting.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(25),
                'updated_at' => now()->subDays(25)
            ],
            [
                'id' => 25,
                'title' => 'Procurement Plan Module',
                'url' => 'https://ppra.org.pk/EPADS/mm/Procurement Plan Module.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(24),
                'updated_at' => now()->subDays(24)
            ],
            [
                'id' => 26,
                'title' => 'Standard Bidding Documents & Bidding Process',
                'url' => 'https://ppra.org.pk/EPADS/mm/Standard Bidding Documents & Bidding Process.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(23),
                'updated_at' => now()->subDays(23)
            ],
            [
                'id' => 27,
                'title' => 'Supplier Management for Suppliers for PPRA Punjab',
                'url' => 'https://ppra.org.pk/EPADS/mm/Supplier Management for Suppliers for PPRA Punjab.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(22),
                'updated_at' => now()->subDays(22)
            ],
            [
                'id' => 28,
                'title' => 'Supplier Management for Suppliers Registration and E-Submission',
                'url' => 'https://ppra.org.pk/EPADS/mm/Supplier Management for Suppliers Registration and  E-Submission.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(21),
                'updated_at' => now()->subDays(21)
            ],
            [
                'id' => 29,
                'title' => 'Supplier Management Module (Admin)',
                'url' => 'https://ppra.org.pk/EPADS/mm/Supplier Management Module (Admin).pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(20)
            ],
            [
                'id' => 30,
                'title' => 'Supplier Management Module',
                'url' => 'https://ppra.org.pk/EPADS/mm/Supplier Management Module.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(19),
                'updated_at' => now()->subDays(19)
            ],
            [
                'id' => 31,
                'title' => 'Training Manual (Master Trainer)',
                'url' => 'https://ppra.org.pk/EPADS/mm/Training Manual (Master Trainer).pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(18),
                'updated_at' => now()->subDays(18)
            ],
            [
                'id' => 32,
                'title' => 'User Management Module (For End Users)',
                'url' => 'https://ppra.org.pk/EPADS/mm/User Management Module (For End Users).pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(17),
                'updated_at' => now()->subDays(17)
            ]
        ]);
        
        return view('site.learn.index', compact('videos'));
    }

    public function kpdws()
    {
        $videos = collect([
            [
                'id' => 1,
                'title' => 'Summary Approval KP Digital Workspace',
                'url' => 'https://www.youtube.com/watch?v=IKm_NaoDPBc&t=812s',
                'category' => 'General',
                'type' => 'video',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10)
            ],
            [
                'id' => 2,
                'title' => 'Notification',
                'url' => 'https://www.youtube.com/watch?v=JIGYOy4YLu0',
                'category' => 'General',
                'type' => 'video',
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8)
            ],
        ]);
        
        return view('site.learn.index', compact('videos'));
    }
}