<?php

use Illuminate\Console\Command;
use App\Models\Diskon;
use Carbon\Carbon;

class CleanupExpiredDiscounts extends Command
{
    protected $signature = 'discounts:cleanup';

    protected $description = 'Cleanup expired discounts';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Ambil semua diskon yang sudah berakhir
        $expiredDiscounts = Diskon::where('tanggal_berakhir', '<', Carbon::now())->get();

        // Hapus diskon yang sudah berakhir
        foreach ($expiredDiscounts as $discount) {
            $discount->delete();
        }

        $this->info('Expired discounts have been cleaned up.');
    }
}
