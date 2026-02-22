<?php 
 namespace App\Controllers; 
 use App\Models\Alumno_carreraModel; 
 
 class Alumnosxcarrera extends BaseController 
 { 
     public function index() 
     { 
         $model = new Alumno_carreraModel(); 
 
         $data['carreras'] = $model->obtenerCarreras(); 
         $data['alumnos'] = []; 
 
         return view('/alumnos/alumnos_view', $data); 
     } 
 
     public function filtrar() 
     { 
         $model = new Alumno_carreraModel(); 
         $codigo_carrera = $this->request->getPost('codigo_carrera'); 
 
         $data['carreras'] = $model->obtenerCarreras(); 
         $data['alumnos'] = $model->obtenerAlumnosPorCarrera($codigo_carrera); 
 
         return view('/alumnos/alumnos_view', $data); 
     } 
 }
?>