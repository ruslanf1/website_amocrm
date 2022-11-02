<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    public $timestamps = false;

    protected $guarded = false;
    protected $subdomain;
    protected $client_id;
    protected $client_secret;
}
