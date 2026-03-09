<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\AlumnosController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Alumnos
$routes->get('alumnos', [AlumnosController::class, 'index']);
$routes->get('alumnos/create', [AlumnosController::class, 'create']);
$routes->post('alumnos/store', [AlumnosController::class, 'store']);
$routes->get('alumnos/edit/(:num)', [AlumnosController::class, 'edit/$1']);
$routes->post('alumnos/update/(:num)', [AlumnosController::class, 'update/$1']);
$routes->post('alumnos/delete/(:num)', [AlumnosController::class, 'delete/$1']);

// Alumnos por carrera
$routes->get('alumnos_carrera', 'Alumnosxcarrera::index');
$routes->post('alumnos_carrera/filtrar', 'Alumnosxcarrera::filtrar');

// Docentes CRUD
$routes->get('docentes', 'DocentesController::index');
$routes->get('docentes/create', 'DocentesController::create');
$routes->post('docentes/store', 'DocentesController::store');
$routes->get('docentes/edit/(:num)', 'DocentesController::edit/$1');
$routes->post('docentes/update/(:num)', 'DocentesController::update/$1');
$routes->post('docentes/delete/(:num)', 'DocentesController::delete/$1');

// Materias CRUD
$routes->get('materias', 'MateriasController::index');
$routes->get('materias/create', 'MateriasController::create');
$routes->post('materias/store', 'MateriasController::store');
$routes->get('materias/edit/(:num)', 'MateriasController::edit/$1');
$routes->post('materias/update/(:num)', 'MateriasController::update/$1');
$routes->post('materias/delete/(:num)', 'MateriasController::delete/$1');

// Horarios (asignación materia-docente y consultas)
$routes->get('horarios/asignar', 'HorariosController::asignar');
$routes->post('horarios/guardar', 'HorariosController::guardarAsignacion');
$routes->get('horarios/por_docente', 'HorariosController::porDocente');
$routes->post('horarios/filtrar_docente', 'HorariosController::filtrarPorDocente');
$routes->get('horarios/editar/(:num)', 'HorariosController::editar/$1');
$routes->post('horarios/actualizar/(:num)', 'HorariosController::actualizar/$1');
$routes->post('horarios/eliminar/(:num)', 'HorariosController::eliminar/$1');