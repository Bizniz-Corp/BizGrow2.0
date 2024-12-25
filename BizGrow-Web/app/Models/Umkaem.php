<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkaem extends Model
{
    protected $table = 'umkms'; // Nama tabel di database
    protected $primaryKey = 'umkm_id'; // Primary key tabel
    protected $fillable = ['user_id', 'npwp_no', 'izin_usaha_path', 'profile_picture'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
