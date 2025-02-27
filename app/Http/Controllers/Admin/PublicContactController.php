<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PublicContact;
use App\Mail\Query\DroppedMail;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\Query\ReliefGrantedMail;
use App\Mail\Query\ReliefNotGrantedMail;

class PublicContactController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $public_contacts = PublicContact::query();

        $public_contacts->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($public_contacts)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.public_contacts.partials.buttons', compact('row'))->render();
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('status', function ($row) {
                    return view('admin.public_contacts.partials.status', compact('row'))->render();
                })
                ->rawColumns(['action','status']);
            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.public_contacts.index');
    }

    public function reliefGrant(Request $request, PublicContact $PublicContact)
    {
        if ($PublicContact->status === 'new') {
            $PublicContact->status = 'relief-granted';
            $PublicContact->remarks = $request->remarks;
            $PublicContact->action_by = $request->user()->id;
            $PublicContact->action_at = now();

            if($PublicContact->save()) {
                Mail::to($PublicContact->email)->queue(new ReliefGrantedMail($PublicContact, $request->remarks));
                return response()->json(['success' => 'Relief Granted.']);
            }
        }
    }

    public function reliefNotGrant(Request $request, PublicContact $PublicContact)
    {
        if ($PublicContact->status === 'new') {
            $PublicContact->status = 'relief-not-granted';
            $PublicContact->remarks = $request->remarks;
            $PublicContact->action_by = $request->user()->id;
            $PublicContact->action_at = now();

            if($PublicContact->save()) {
                Mail::to($PublicContact->email)->queue(new ReliefNotGrantedMail($PublicContact, $request->remarks));
                return response()->json(['success' => 'Relief Not Granted.']);
            }
        }
        return response()->json(['error' => 'Product can\'t be rejected.']);
    }

    public function drop(Request $request, PublicContact $PublicContact)
    {
        if ($request->user()->isAdmin()) {
            if ($PublicContact->delete()) {
                return response()->json(['success' => 'PublicContact has been deleted successfully.']);
            }
        } elseif ($PublicContact->status === 'new') {
            $PublicContact->status = 'dropped';
            $PublicContact->remarks = $request->remarks;
            $PublicContact->action_by = $request->user()->id;
            $PublicContact->action_at = now();

            if ($PublicContact->save()) {
                Mail::to($PublicContact->email)->queue(new DroppedMail($PublicContact, $request->remarks));
                return response()->json(['success' => 'Dropped.']);
            }
        }

        return response()->json(['error' => 'PublicContact can\'t be rejected or deleted.']);
    }
}
