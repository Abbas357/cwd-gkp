<?php

namespace App\Http\Controllers\Site;

use App\Models\Tender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        $tenders = Tender::with(['media', 'user'])
            ->when($request->domain, function ($query, $domain) {
                $query->where('domain', $domain);
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        $categories = Tender::select('domain')->distinct()->pluck('domain');

        return view('site.tenders.index', compact('tenders', 'categories'));
    }

    public function showTenders($slug)
    {
        $tender = Tender::where('slug', $slug)->with(['media'])->firstOrFail();

        $tenderDocuments = $tender->getMedia('tender_documents')->map(function ($media) {
            return [
                'url' => $media->getUrl(),
                'name' => $media->name,
                'type' => $media->mime_type,
            ];
        });

        $tenderEoiDocuments = $tender->getMedia('tender_eoi_documents')->map(function ($media) {
            return [
                'url' => $media->getUrl(),
                'name' => $media->name,
                'type' => $media->mime_type,
            ];
        });

        $biddingDocuments = $tender->getMedia('bidding_documents')->map(function ($media) {
            return [
                'url' => $media->getUrl(),
                'name' => $media->name,
                'type' => $media->mime_type,
            ];
        });

        $tenderData = [
            'id' => $tender->id,
            'title' => $tender->title,
            'slug' => $tender->slug,
            'description' => $tender->description ?? 'No description available.',
            'domain' => $tender->domain ?? 'General',
            'procurement_entity' => $tender->procurement_entity,
            'date_of_advertisement' => $tender->date_of_advertisement->format('j, F Y'),
            'closing_date' => $tender->closing_date->format('j, F Y'),
            'user' => $tender->user->position,
            'published_by' => $tender->publishBy->position,
            'published_at' => $tender->published_at->format('j, F Y'),
            'tender_documents' => $tenderDocuments,
            'tender_eoi_documents' => $tenderEoiDocuments,
            'bidding_documents' => $biddingDocuments,
        ];

        return view('site.tenders.show', compact('tenderData'));
    }
}