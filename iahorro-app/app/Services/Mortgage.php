<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Expert;
use App\Providers\MortgageServiceProvider;
use App\Repository\Eloquent\ExpertRepository;
use App\Repository\Eloquent\TimeZoneRepository;
use App\Repository\ExpertRepositoryInterface;
use App\Repository\TimeZoneRepositoryInterface;
use Illuminate\Http\Request;

class Mortgage
{
    private $timeZoneRepository, $expertRepository;
//
//    public function __construct(TimeZoneRepositoryInterface $timeZoneRepository, ExpertRepositoryInterface $expertRepository)
//    {
////        $this->mortgageService = $mortgageService;
//        $this->timeZoneRepository = $timeZoneRepository;
//        $this->expertRepository = $expertRepository;
//    }

    /**
     * Mortgage constructor.
     * @param TimeZoneRepositoryInterface $timeZoneRepository
     * @param ExpertRepositoryInterface $expertRepository
     */
    public function __construct(TimeZoneRepository $timeZoneRepository, ExpertRepository $expertRepository)
    {
        $this->timeZoneRepository = $timeZoneRepository;
        $this->expertRepository = $expertRepository;
    }

    /**
     * @return array
     */
    public function getBaseData()
    {
        return [
            "Experts" => $this->expertRepository->all(),
            "Time Zones" => $this->timeZoneRepository->all()
        ];
    }

    /**
     * @param Request $request
     * @return Customer
     */
    public function createMortgage(Request $request): Customer
    {
        //Create customer
        /** @var Customer $customer */
        $customer = Customer::updateOrCreate(
            [
                'email' => $request->email
            ],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'net_income' => $request->net_income,
                'time_zones_id' => $request->time_zones_id
            ]
        );

        //Get a random expert
        $expert = $this->expertRepository->all()->random(1)->first();

        //Create a new mortgage request and assign it to an expert
        $customer->experts()->attach($expert->id, ['amount' => $request->amount, 'status' => 'pending']);

        return $customer;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getExpertById($id)
    {
        return $this->expertRepository->find($id);
    }

    /**
     * @param Expert $expert
     * @return array
     */
    public function getMortgageRequestsByExpert(Expert $expert): array
    {
        //Get current date
        $currentDate = new \DateTime('NOW');

        //Get mortgage requests by expert ID
        $requests = $expert->customers()->get()->toArray();

        //Filter the requests that are available at the current time with respect to the customer's time zone
        $requests = array_filter(array_map(
            function ($request) use ($currentDate) {
                //Get the time zone object by ID
                $time_zone = $this->timeZoneRepository->find($request['time_zones_id']);
                $request['time_zone_from'] = $time_zone->from;
                $request['time_zone_to'] = $time_zone->to;
                unset($request['time_zones_id']);

                $from = new \DateTime($time_zone->from);
                $to = new \DateTime($time_zone->to);

                if ( strtotime($currentDate->format('H:i')) >= strtotime($from->format('H:i'))
                    && strtotime($currentDate->format('H:i')) <= strtotime($to->format('H:i')) ) {
                    //Get the created date
                    $created = new \DateTime($request['request']['created_at']);

                    //Calculates the difference in hours between the current date and the created date
                    $diff = $created->diff($currentDate);
                    $hoursDiff = (($diff->d * 24 ) * 60 ) + ( $diff->h * 60 );

                    //Calculates the scoring
                    $request['scoring'] = number_format(($request['request']['amount'] / $request['net_income']) * $hoursDiff,2,'.','');

                    //Extract fields to display from the object and then destroy it
                    $request['amount'] = $request['request']['amount'];
                    $request['status'] = $request['request']['status'];
                    $request['created_at'] = $request['request']['created_at'];
                    $request['updated_at'] = $request['request']['updated_at'];
                    unset($request['request']);

                    return $request;
                } else {
                    //Discard request
                    unset($request);
                }
            }, $requests
        ), function ($request) {
            return $request;
        });

        //Sort desc by scoring column
        $sortAux = array_column($requests,'scoring');
        array_multisort($sortAux,SORT_DESC, $requests);

        return $requests;
    }
}