<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Http\Requests\StoreTenderRequest;
use App\Http\Requests\UpdateTenderRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function importTenders()
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

        return redirect()->route('dashboard')->with('message', 'Tenders loaded successfully');
    }

    public function downloadTenderFile(Request $request)
    {

        $fileUrl = $request->link;
        $tenderId = $request->tenderId;
        $fileName = 'tenderFiles/' . $tenderId . '.html';
        $fileContents = file_get_contents($fileUrl);
        file_put_contents(public_path($fileName), $fileContents);

        return back()->with('File downloaded and stored successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTenderRequest $request)
    {


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
