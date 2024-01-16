<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Http\Requests\StoreTenderRequest;
use App\Http\Requests\UpdateTenderRequest;
use Illuminate\Support\Facades\Http;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTenderRequest $request)
    {
        $apiURL = env('TENDER_API_URL');
        $response = Http::timeout(10000000)->get($apiURL);
        $data = json_decode($response, true);
        $tenders = $data['TenderDetails'][0]['TenderLists'];

        foreach ($tenders as $tender) {
            if (isset($tender['BDR_No']) && $tender['BDR_No'] !== '' && !Tender::where('bdr_no', $tender['BDR_No'])->exists()) {
                Tender::create([
                    'bdr_no' => $tender['BDR_No'],
                    'purchasing_authority' => $tender['Purchasing_Authority'],
                    'tender_number' => $tender['Tender_No'],
                    'tender_brief' => $tender['Tender_Brief'],
                    'competition_type' => $tender['CompetitionType'],
                    'funded_by' => $tender['Funding'],
                    'country' => $tender['Geographical_Addresses'],
                    'value' => $tender['Tender_Value'],
                    'work_detail' => $tender['Work_Detail'],
                    'email' => $tender['Email_Address'],
                    'link' => $tender['FileUrl'],
                    'expiry' => $tender['Tender_Expiry']
                ]);
            }
        }

        return response()->json('Done');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tender $tender)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tender $tender)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTenderRequest $request, Tender $tender)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tender $tender)
    {
        //
    }
}
