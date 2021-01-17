<?php

namespace App\Http\Controllers;

use App\Services\Mortgage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class MortgageController extends Controller
{
    private $mortgageService;

    public function __construct(Mortgage $mortgageService)
    {
        $this->mortgageService = $mortgageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            //Get base data
            $data = $this->mortgageService->getBaseData();

            return response()->json([
                'data' => $data
            ],201);
        } catch(\Exception  $e) {
            return response()->json([
                'error' => true,
                'msg' => 'Whoops, looks like something went wrong. Error: '.$e->getMessage()
            ],404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            //Validate the request
            $this->validate($request, [
                'first_name' => ['required', 'string', 'max:45'],
                'last_name' => ['required', 'string', 'max:45'],
                'email' => ['required', 'email:rfc'],
                'phone' => ['required', 'string'],
                'net_income' => ['required', 'numeric'],
                'amount' => ['required', 'numeric'],
                'time_zones_id' => ['required', 'exists:App\Models\TimeZone,id'],
            ]);

            $customer = $this->mortgageService->createMortgage($request);

            return response()->json([
                'created' => true,
                'msg' => 'The mortgage request was created successfully.'
            ],201);
        } catch(\Exception  $e) {
            return response()->json([
                'created' => false,
                'msg' => 'Whoops, looks like something went wrong. Error: '.$e->getMessage()
            ],404);
        }
    }

    /**
     * Display the specified resource.
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $expert = $this->mortgageService->getExpertById($id);

            if (!$expert)
                throw new \Exception('Expert not found.');

            $requests = $this->mortgageService->getMortgageRequestsByExpert($expert);

            return response()->json([
                'Expert' => $expert,
                'Mortgage Requests' => $requests
            ],201);
        } catch(\Exception  $e) {
            return response()->json([
                'error' => true,
                'msg' => 'Whoops, looks like something went wrong. Error: '.$e->getMessage()
            ],404);
        }
    }
}