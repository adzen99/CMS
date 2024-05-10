<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'series',
        'number',
        'id_user',
        'id_company',
        'id_partner',
        'id_contract',
        'id_appendix',
        'date',
        'due_date',
        'currency',
        'value',
        'vat',
        'vat_percentage',
    ];

}
