<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cita extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'citas';

    protected $fillable = [
        'mascota_id',
        'servicio_id',
        'fecha',
        'hora',
        'estado',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at'; 

    public function mascota()
{
    return $this->belongsTo(Mascota::class, 'mascota_id');
}

public function servicio()
{
    return $this->belongsTo(Servicio::class, 'servicio_id');
}

}
