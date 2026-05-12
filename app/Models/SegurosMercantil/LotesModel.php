<?php

namespace App\Models\SegurosMercantil;

use Illuminate\Database\Eloquent\Model;

class LotesModel extends Model
{
    protected $table = 'gt_lotes';

    public function RelationUsers()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function RelationClientes()
    {
        return $this->hasMany(\App\Models\SegurosMercantil\ClientesModel::class, 'lote_id', 'id');
    }
}
