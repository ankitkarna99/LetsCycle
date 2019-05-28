<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KYCForm extends Model
{
    protected $fillable = [
        'user_id',
        'father_name',
        'mother_name',
        'grandfather_name',
        'spouse_name',
        'occupation',
        'district',
        'municipality',
        'ward_number',
        'identity_type',
        'identity_number',
        'issued_date'
    ];
}
