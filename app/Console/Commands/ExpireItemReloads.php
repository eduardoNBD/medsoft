<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ItemReload;
use Carbon\Carbon;

class ExpireItemReloads extends Command
{
    protected $signature = 'item-reloads:expire';
    protected $description = 'Verifica si un ItemReload ha expirado y actualiza el status a 0';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $expiredItems = ItemReload::whereNotNull('expiration')
            ->where('expiration', '<', $today)
            ->where('status', '!=', 0)
            ->update(['status' => 0]);

        $this->info("$expiredItems registros actualizados a status 0.");
    }
}
