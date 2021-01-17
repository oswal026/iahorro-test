<?php
namespace App\Providers;

use App\Models\Expert;
use App\Models\TimeZone;
use App\Repository\Eloquent\ExpertRepository;
use App\Repository\Eloquent\TimeZoneRepository;
use App\Services\Mortgage;
use Illuminate\Support\ServiceProvider;

/**
 * Class MortgageServiceProvider
 * @package App\Providers
 */
class MortgageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Mortgage::class, function ($app) {
            return new Mortgage(new TimeZoneRepository( new TimeZone()), new ExpertRepository(new Expert()));
        });
    }
}