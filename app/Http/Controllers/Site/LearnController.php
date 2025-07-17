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
                'title' => 'How to Complete Registration Process on Epads Part-2',
                'url' => 'https://www.youtube.com/watch?v=_NVKsi8a8lY',
                'category' => 'general_video',
                'type' => 'video',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10)
            ],
            [
                'id' => 3,
                'title' => 'How To Create Procurement Plan',
                'url' => 'https://www.youtube.com/watch?v=7C1mQ9f56YY&pp=0gcJCcwJAYcqIYzv',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8)
            ],
            [
                'id' => 4,
                'title' => 'How to create a Supplier ID on Epads Part-1',
                'url' => 'https://www.youtube.com/watch?v=NiSTSJCO_KA',
                'category' => 'general_video',
                'type' => 'video',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10)
            ],
            [
                'id' => 5,
                'title' => 'How to participate in Pre Qualification , EOI (Expression of Intrest) on Epads',
                'url' => 'https://www.youtube.com/watch?v=MSu3-IsSUyc',
                'category' => 'general_video',
                'type' => 'video',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10)
            ],
            [
                'id' => 6,
                'title' => 'How to Bid in Tender using File Uploading Method l Vendor\'s Guide',
                'url' => 'https://www.youtube.com/watch?v=UivYAgLBcEw',
                'category' => 'general_video',
                'type' => 'video',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10)
            ],
            [
                'id' => 7,
                'title' => 'How to Quote on Petty & RFQ (Request for proposal) on EPADS',
                'url' => 'https://www.youtube.com/watch?v=avpsp3MDEl8',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7)
            ],
            [
                'id' => 8,
                'title' => 'How to Create a Petty Purchase on Epads l PA\'s Guide',
                'url' => 'https://www.youtube.com/watch?v=FjArVjKwabE',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(6),
                'updated_at' => now()->subDays(6)
            ],

            [
                'id' => 9,
                'title' => 'How to Create RFQ Request for Quotation l PA\'s Guide',
                'url' => 'https://www.youtube.com/watch?v=h69eFlYmtjA',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(6),
                'updated_at' => now()->subDays(6)
            ],
            [
                'id' => 10,
                'title' => 'How to Create PQ Pre-Qualification / EOI Expression of Interest on Epads PA\'s Guide',
                'url' => 'https://www.youtube.com/watch?v=xo9ns2QnFC8',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(6),
                'updated_at' => now()->subDays(6)
            ],
            [
                'id' => 11,
                'title' => 'How to Create Committee on Epads l PA\'s Guide',
                'url' => 'https://www.youtube.com/watch?v=DJ1cbaucK04&pp=0gcJCcwJAYcqIYzv',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5)
            ],
            [
                'id' => 12,
                'title' => 'How to Evaluate Tender Using File Uploading Method l PA\'s Guide',
                'url' => 'https://www.youtube.com/watch?v=vaGo-SZnha4',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4)
            ],
            [
                'id' => 13,
                'title' => 'How to Evaluate PQ Pre Qualification on Epads l PA\'s Guide',
                'url' => 'https://www.youtube.com/watch?v=cZmKjhKMWRs',
                'category' => 'procuring_agencies',
                'type' => 'video',
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2)
            ],
            [
                'id' => 19,
                'title' => 'Procurement Plan UTM e-PADS',
                'url' => 'https://old.ppra.org.pk/EPADS/mm/plan.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(30),
                'updated_at' => now()->subDays(30)
            ],
            [
                'id' => 20,
                'title' => 'Supplier Management for PPRA Admins UTM e-PADS',
                'url' => 'https://old.ppra.org.pk/EPADS/mm/supplier.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(29),
                'updated_at' => now()->subDays(29)
            ],
            [
                'id' => 21,
                'title' => 'Supplier Management for Suppliers',
                'url' => 'https://old.ppra.org.pk/EPADS/mm/supplier2.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(28),
                'updated_at' => now()->subDays(28)
            ],
            [
                'id' => 22,
                'title' => 'User Management UTM e-PADS',
                'url' => 'https://old.ppra.org.pk/EPADS/mm/user.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(27),
                'updated_at' => now()->subDays(27)
            ],
            [
                'id' => 23,
                'title' => 'Pre-qualification and e-Submission, e-Evaluation',
                'url' => 'https://old.ppra.org.pk/EPADS/mm/esubmission.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(26),
                'updated_at' => now()->subDays(26)
            ],
            [
                'id' => 24,
                'title' => 'e-Sourcing to e-Contracting',
                'url' => 'https://old.ppra.org.pk/EPADS/mm/e-Sourcing to e-Contracting.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(25),
                'updated_at' => now()->subDays(25)
            ],
            [
                'id' => 25,
                'title' => 'Procurement Plan Module',
                'url' => 'https://old.ppra.org.pk/EPADS/mm/Procurement Plan Module.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(24),
                'updated_at' => now()->subDays(24)
            ],
            [
                'id' => 26,
                'title' => 'Standard Bidding Documents & Bidding Process',
                'url' => 'https://old.ppra.org.pk/EPADS/mm/Standard Bidding Documents & Bidding Process.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(23),
                'updated_at' => now()->subDays(23)
            ],
            [
                'id' => 27,
                'title' => 'Supplier Management for Suppliers for PPRA Punjab',
                'url' => 'https://old.ppra.org.pk/EPADS/mm/Supplier Management for Suppliers for PPRA Punjab.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(22),
                'updated_at' => now()->subDays(22)
            ],
            [
                'id' => 28,
                'title' => 'Supplier Management for Suppliers Registration and E-Submission',
                'url' => 'https://old.ppra.org.pk/EPADS/mm/Supplier Management for Suppliers Registration and  E-Submission.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(21),
                'updated_at' => now()->subDays(21)
            ],
            [
                'id' => 29,
                'title' => 'Supplier Management Module (Admin)',
                'url' => 'https://old.ppra.org.pk/EPADS/mm/Supplier Management Module (Admin).pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(20)
            ],
            [
                'id' => 30,
                'title' => 'Supplier Management Module',
                'url' => 'https://old.ppra.org.pk/EPADS/mm/Supplier Management Module.pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(19),
                'updated_at' => now()->subDays(19)
            ],
            [
                'id' => 31,
                'title' => 'Training Manual (Master Trainer)',
                'url' => 'https://old.ppra.org.pk/EPADS/mm/Training Manual (Master Trainer).pdf',
                'category' => 'General',
                'type' => 'pdf',
                'created_at' => now()->subDays(18),
                'updated_at' => now()->subDays(18)
            ],
            [
                'id' => 32,
                'title' => 'User Management Module (For End Users)',
                'url' => 'https://old.ppra.org.pk/EPADS/mm/User Management Module (For End Users).pdf',
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
                'url' => 'https://www.youtube.com/watch?v=IKm_NaoDPBc',
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