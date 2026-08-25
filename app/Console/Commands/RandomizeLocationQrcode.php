<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Location;
use Illuminate\Support\Str;

class RandomizeLocationQrcode extends Command
{
    protected $signature = 'location:randomize-qrcode';

    protected $description = 'Randomize QR Code lokasi';

    public function handle()
    {
        Location::chunkById(500, function ($locations) {

            foreach ($locations as $location) {
                $location->qrcode = Str::random(32);
                $location->save();
            }

        });

        $this->info('QR Code berhasil diubah.');

        return 0;
    }
}