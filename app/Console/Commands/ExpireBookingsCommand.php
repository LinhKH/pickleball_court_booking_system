<?php

namespace App\Console\Commands;

use App\Application\Booking\ExpireBooking;
use Illuminate\Console\Command;

class ExpireBookingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire pending bookings and release slot locks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app(ExpireBooking::class)->execute();

        $this->info('Expired pending bookings successfully.');

        return Command::SUCCESS;
    }
}
