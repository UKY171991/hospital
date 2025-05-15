<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'contact_no', 'pan_no', 'address', 'logo', 'userid', 'password', 'passcode',
        'email', 'tag_line', 'bank_name', 'branch_name', 'ifsc_code', 'account_no', 'gstin_no', 'cin_no', 'prefix', 'signature', 'stamp', 'payment_qr'
    ];
}
