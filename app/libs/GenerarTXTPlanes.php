<?php
namespace App\libs;

use App\Models\SegurosMercantil\PlanesModel;
use App\Models\SegurosMercantil\SumaAseguradaModel;
use App\Models\SegurosMercantil\BancosModel;
use Carbon\Carbon;
/**
 * Description of ApiCheckInfinity
 *
 * @author bjaimes
 */
class GenerarTXTPlanes {
   
    private $data;
    private $nombre;
 
            
    public function __construct($data,$nombre) {
      $this->data = $data;
      $this->nombre = $nombre;
    }
    
    private function Cabeceras(){                  
            return "CODIGO ALIADO;MEDIO DE VENTA;CODIGO CAMPANA;CODIGO DEL GESTOR;NACIONALIDAD TOMADOR;CEDULA DEL TOMADOR;APELLIDO 1 TOMADOR;APELLIDO 2 TOMADOR;APELL CASADA TOMADOR;NOMBRE 1 TOMADOR;NOMBRE 2 TOMADOR;SEXO TOMADOR;EDO_CIVIL TOMADOR;FECHA NAC TOMADOR;ESTADO HAB TOMADOR;CIUDAD HAB TOMADOR;MUNICIPIO HAB TOMADO;PARROQUIA HAB TOMADO;URB_HAB TOMADOR;ZN POSTAL HAB TOMADO;AVENIDA HAB TOMADOR;CASA HAB TOMADOR;EMAIL OFIC TOMADOR;EMAIL HAB TOMADOR;AREA TLF HAB TOMADOR;TELEFONO HAB TOMADOR;AREA TLF OFI TOMADOR;TELEFONO OFI TOMADOR;CELULAR HAB TOMADOR;CELULAR OFI TOMADOR;NACIONALIDAD CLIENTE;CEDULA DEL CLIENTE;APELLIDO 1 CLIENTE;APELLIDO 2 CLIENTE;APELL CASADA CLIENTE;NOMBRE 1 CLIENTE;NOMBRE 2 CLIENTE;SEXO CLIENTE;EDO_CIVIL CLIENTE;FECHA NAC CLIENTE;ESTADO HAB CLIENTE;CIUDAD HAB CLIENTE;MUNICIPIO HAB CLIENT;PARROQUIA HAB CLIENT;URB_HAB CLIENTE;ZN POSTAL HAB CLIENT;AVENIDA HAB CLIENTE;CASA HAB CLIENTE;AREA TLF HAB CLIENTE;TELEFONO HAB CLIENTE;CELULAR HAB CLIENTE;EMAIL HAB CLIENTE;EMAIL OFIC CLIENTE;AREA TLF OFI CLIENTE;TELEFONO OFI CLIENTE;CELULAR OFI CLIENTE;SUCURSAL;PRODUCTO;FECHA SOLICITUD;FR_PAGO;CANAL_VENTA;PRODUCTOR;PROFESION;SUMA_ASEGURADA;DOMICILIADO;BANCO;NRO CUENTA;TIPO CUENTA;TIPO_TARJETA;FE_VCMTO_TARJETA;";
     
    } 

    public function prepareRows($data): array
{
    return $data->map(function ($change) {
        $change->codigo_aliado = 6;
        $change->medio_venta = "TLM";
        $cam = PlanesModel::find($change->plan_id)->nombre_archivo;
        $arraycampan = explode("_", $cam);        
        $change->campania       = trim($arraycampan[0]);
        $change->gestor         = 4;
        $change->nacionalidad   = $change->RelationCliente->nacionalidad_cliente;
        $change->n_cedula       = $change->RelationCliente->n_cedula;
        $change->apelld1        = $change->RelationCliente->apelld1;
        $change->apelld2        = $change->RelationCliente->apelld2;
        $change->apellcasada    = $change->RelationCliente->apellcasada;
        $change->nomb1          = $change->RelationCliente->nomb1;
        $change->nomb2          = $change->RelationCliente->nomb2;
        $change->cd_sexo        = $change->RelationCliente->cd_sexo;
        $change->cd_edo_civil   = $change->RelationCliente->cd_edo_civil;
        $change->fecha_de_nacimiento = carbon::create($change->RelationCliente->fecha_de_nacimiento)->format('d/m/Y');
        $change->cd_estado_hab  = $change->RelationCliente->cd_estado_hab;
        $change->cd_ciudad_hab  = $change->RelationCliente->cd_ciudad_hab;
        $change->municipio_hab  = $change->RelationCliente->municipio_hab;
        $change->parroquia_hab  = $change->RelationCliente->parroquia_hab;
        $change->cd_urbanizsector_hab = $change->RelationCliente->cd_urbanizsector_hab;
        $change->codigo_postal_hab  = $change->RelationCliente->codigo_postal_hab;
        $change->di_av_calle_hab    = $change->RelationCliente->di_av_calle_hab != null ? $change->RelationCliente->di_av_calle_hab : "No Suministrado";
        $change->di_casa_hab = $change->RelationCliente->di_casa_hab;
        $change->email_persol_tomador = $change->RelationCliente->email_persol_tomador;
        $change->email_trabajo_u_ofici_tomador = $change->RelationCliente->email_trabajo_u_ofici_tomador;
        
        
        if ($change->RelationCliente->num_telefono_hab_tomador == 0000000) {
                        $change->cd_area_num_telefono_habitacion_tomador = "";
            $change->num_telefono_hab_tomador = "";
        }
        else {
            $change->cd_area_num_telefono_habitacion_tomador = $change->RelationCliente->cd_area_num_telefono_habitacion_tomador;
            $change->num_telefono_hab_tomador = $change->RelationCliente->num_telefono_hab_tomador;
        }


        if ($change->RelationCliente->num_telefono_trab_ofic_tomador == 0000000) {
            $change->cd_area_num_telefono_trab_ofic_tomador = "";
            $change->num_telefono_trab_ofic_tomador = "";
        }
        else {
            $change->cd_area_num_telefono_trab_ofic_tomador = $change->RelationCliente->cd_area_num_telefono_trab_ofic_tomador;
            $change->num_telefono_trab_ofic_tomador = $change->RelationCliente->num_telefono_trab_ofic_tomador;
        }

        $change->num_celular_pers_tomador = $change->RelationCliente->num_celular_pers_tomador;
        
        if( $change->RelationCliente->num_celular_trab_tomador == 0000000){
            $change->num_celular_trab_tomador = "";
        } else {
            $change->num_celular_trab_tomador = $change->RelationCliente->num_celular_trab_tomador;
        }
             
        
        $change->cd_profesion_ocupacion_cliente = $change->RelationCliente->cd_profesion_ocupacion_cliente;

        $change->cuenta = $change->num_cuenta_asociar_inst_bancario_sinencriptar != null ? $change->num_cuenta_asociar_inst_bancario_sinencriptar : null;
        $change->plan = $change->plan_id != null ? PlanesModel::find($change->plan_id)->codigo : null;
              
        $change->estatus_id == 5 ? $change->fecha_solicitud = date('d/m/Y', strtotime($change->created_at)) : $change->fecha_solicitud = null;
        $change->suma_asegurada = $change->suma_asegurada_id != null ? SumaAseguradaModel::find($change->suma_asegurada_id)->nombre : null;
        
        $change->banco = $change->banco_domiciliado != null ? BancosModel::find($change->banco_domiciliado)->id : null;
        $change->tipo_tdc_domiciliar = $change->tipo_tdc_domiciliar != null ? $change->tipo_tdc_domiciliar : null;
        $change->fecha_vencimiento_tdc_domiciliar = $change->fecha_vencimiento_tdc_domiciliar != null ? $change->fecha_vencimiento_tdc_domiciliar : null;
        
        // Retornar una cadena con los valores separados por punto y coma
        return implode(';', [
                $change->codigo_aliado,
                $change->medio_venta,
                $change->campania,
                $change->gestor,   
                $change->nacionalidad,
                $change->n_cedula,
                $change->apelld1,
                $change->apelld2,
                $change->apellcasada,
                $change->nomb1,
                $change->nomb2,
                $change->cd_sexo,
                $change->cd_edo_civil,
                $change->fecha_de_nacimiento,
                $change->cd_estado_hab,
                $change->cd_ciudad_hab,
                $change->municipio_hab,
                $change->parroquia_hab,
                $change->cd_urbanizsector_hab,
                $change->codigo_postal_hab,
                $change->di_av_calle_hab,
                $change->di_casa_hab,
                $change->email_persol_tomador,
                $change->email_trabajo_u_ofici_tomador,
                $change->cd_area_num_telefono_habitacion_tomador,
                $change->num_telefono_hab_tomador,
                $change->cd_area_num_telefono_trab_ofic_tomador,
                $change->num_telefono_trab_ofic_tomador,
                $change->num_celular_pers_tomador,
                $change->num_celular_trab_tomador,
                $change->nacionalidad,
                $change->n_cedula,
                $change->apelld1,
                $change->apelld2,
                $change->apellcasada,
                $change->nomb1,
                $change->nomb2,
                $change->cd_sexo,
                $change->cd_edo_civil,
                $change->fecha_de_nacimiento,
                $change->cd_estado_hab,
                $change->cd_ciudad_hab,
                $change->municipio_hab,
                $change->parroquia_hab,
                $change->cd_urbanizsector_hab,
                $change->codigo_postal_hab,
                $change->di_av_calle_hab,
                $change->di_casa_hab,
                $change->cd_area_num_telefono_habitacion_tomador,
                $change->num_telefono_hab_tomador,
                $change->num_celular_pers_tomador,
                $change->email_persol_tomador,
                $change->email_trabajo_u_ofici_tomador,
                $change->cd_area_num_telefono_trab_ofic_tomador,
                $change->num_telefono_trab_ofic_tomador,
                $change->num_celular_trab_tomador,
                "1",
                $change->plan,
                $change->fecha_solicitud,
                $change->tipo_pago,
                "12",
                "35000",
                "00".$change->cd_profesion_ocupacion_cliente,
                $change->suma_asegurada,
                $change->tipo_pago,
                $change->banco,
                $change->cuenta,
                $change->tipo_cuenta_domiciliar,
                $change->tipo_tdc_domiciliar,
                $change->fecha_vencimiento_tdc_domiciliar,
                    ]);
                })->toArray(); // Convertir la colección a un array
    }

    public function GenerateTXT() {
        
        $cabecera = $this->Cabeceras();  
        
        $datos = $this->prepareRows($this->data);
        $contenido = $cabecera . "\n" . implode("\n", $datos);
        
        // Guardar el archivo
        $this->guardarArchivo($contenido,  $this->nombre.'.txt');
        
        return true;
    }
    
    private function guardarArchivo($contenido, $nombreArchivo)
    {
        // Guardar el archivo en el sistema de archivos
        file_put_contents(storage_path("app/public/{$nombreArchivo}"), $contenido);
    }
}
