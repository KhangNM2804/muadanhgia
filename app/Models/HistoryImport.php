<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryImport extends Model
{
    use HasFactory;

    protected $table = "history_import";
    protected $fillable = [
        'category_id', 'name', 'amount',
    ];
}
