<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BookingTransaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "booking_transactions";
    public $timestamps = true;
    protected $guarded = [];

    public static function generateBookingCode()
    {
        // Ambil tahun dan bulan saat ini
        $year = date('Y');
        $month = date('m');

        // Generate 4 karakter acak huruf besar
        $randomString = Str::random(4);
        $randomString = strtoupper($randomString);

        // Gabungkan semua bagian menjadi kode booking
        $bookingCode = 'NZ' . $year . $month . '-' . $randomString;

        return $bookingCode;
    }

    public function officeSpaces(): BelongsTo
    {
        return $this->belongsTo(OfficeSpace::class);
    }
}
