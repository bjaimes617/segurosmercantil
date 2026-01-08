<?php

namespace App\Models\SegurosMercantil;

use Illuminate\Database\Eloquent\Model;

class UrbanizacionModel extends Model
{
    protected $table = 'urbanizacion';
    
    public function Relation_Urb_to_Estados() {
        
        return $this->belongsTo(EstadosModel::class,'estado_id','id');
    }
    
    public function Relation_Urb_to_Ciudad() {
        
        return $this->belongsTo(CiudadesModel::class,'ciudad_id','id','estado_id','estado_id');
      
    }
    
    public function Relation_Urb_to_Municipio() {
        
        return $this->belongsTo(MunicipiosModel::class,'municipio_id','id','ciudad_id','ciudad_id');
      
    }
    
    public function Relation_Urb_to_Parroquia() {
        
        return $this->belongsTo(ParroquiaModel::class,'parroquia_id','id','ciudad_id','ciudad_id','municipio_id','municipio_id');
      
    }
    
    
}
