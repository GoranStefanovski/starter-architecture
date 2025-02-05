<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Applications\NationalHoliday\Model\NationalHoliday;
use GuzzleHttp\Client;
use Carbon\Carbon;

class PopulateNationalHolidays extends Command
{
    protected $signature = 'populate:holidays {--year=}';
    protected $description = 'Populate national holidays for Macedonia and Bulgaria using Nager.Date API';

    public function handle()
    {
        $year = $this->option('year');

        if (!$year) {
            $this->error('HOLIDAYS_YEAR is not set in the .env file.');
            return Command::FAILURE;
        }

        $this->info("Fetching holidays for year: $year");

        $countries = [
            'Macedonia' => 'MK',
            'Bulgaria'  => 'BG',
        ];

        $client = new Client();

        foreach ($countries as $countryName => $countryCode) {
            $this->info("Fetching holidays for $countryName...");

            $response = $client->get("https://date.nager.at/api/v3/PublicHolidays/{$year}/{$countryCode}");

            if ($response->getStatusCode() !== 200) {
                $this->error("Failed to fetch holidays for $countryName.");
                continue;
            }

            $holidays = json_decode($response->getBody(), true);

            foreach ($holidays as $holiday) {
                $holidayDate = Carbon::parse($holiday['date']);

                if ($holidayDate->isWeekend()) {
                    continue;
                }

                NationalHoliday::updateOrCreate(
                    [
                        'date'    => $holiday['date'],
                        'country' => $countryName,
                        'year'    => $year,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }

            $this->info("Holidays successfully populated for $countryName.");
        }

        $this->info("✅ All holidays populated successfully.");
        return Command::SUCCESS;
    }
}
