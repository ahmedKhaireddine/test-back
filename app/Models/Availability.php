<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    /**
     * Formatted date.
     *
     * @return  $date
     */
    public static function formattedDate($date)
    {
      return date('Y-m-d H:i', strtotime($date));
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
