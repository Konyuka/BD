<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tender;
use App\Http\Resources\TenderResource;



class ApiController extends Controller
{
    public function tenderListing()
    {
        return TenderResource::collection(Tender::orderBy('created_at')->paginate());
    }

    public function filterListing(Request $request)
    {

        $query = Tender::query();

        if ($request->has('title') && $request->title !== null) {
            $query->orWhere('tenders.tender_brief', 'like', '%' . $request->input('title') . '%');
        }


        if ($request->has('company') && $request->company !== null) {
            $query->orWhere('tenders.tender_brief', 'like', '%' . $request->input('company') . '%')
                ->orWhere('tenders.purchasing_authority', 'like', '%' . $request->input('company') . '%')
                ->orWhere('tenders.work_detail', 'like', '%' . $request->input('company') . '%');
        }

        if ($request->has('industry') && $request->industry !== null) {
            $query->orWhere('tenders.tender_brief', 'like', '%' . $request->input('industry') . '%')
                ->orWhere('tenders.purchasing_authority', 'like', '%' . $request->input('industry') . '%')
                ->orWhere('tenders.work_detail', 'like', '%' . $request->input('industry') . '%');
        }

        if ($request->has('number') && $request->number !== null) {
            $query->orWhere('tenders.tender_number', 'like', '%' . $request->input('number') . '%');
        }

        if ($request->has('posted') && $request->posted !== null) {
            $query->orWhere('tenders.created_at', 'like', '%' . $request->input('posted') . '%');
        }

        if ($request->has('expiry') && $request->expiry !== null) {
            $query->orWhere('tenders.expiry', 'like', '%' . $request->input('expiry') . '%');
        }


        return TenderResource::collection($query->paginate());


    }
}
