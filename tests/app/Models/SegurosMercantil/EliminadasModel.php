<?php

namespace App\Models\SegurosMercantil;

use Illuminate\Database\Eloquent\Model;

class EliminadasModel extends Model
{
    protected $table = 'gt_eliminadas';
    
     
    public function RelationEstatus() {
        return $this->belongsTo(EstatusModel::class,'estatus_id','id');
    }
    
    public function RelationCliente() {
        return $this->belongsTo(ClientesModel::class,'clientes_id','id');
    }
}
