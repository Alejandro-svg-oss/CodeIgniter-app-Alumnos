<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\AlumnosController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('alumnos', [AlumnosController::class, 'index']);
$routes->get('alumnos/create', [AlumnosController::class, 'create']);
$routes->post('alumnos/store', [AlumnosController::class, 'store']);
$routes->get('alumnos/edit/(:num)', [AlumnosController::class, 'edit/$1']);
$routes->post('alumnos/update/(:num)', [AlumnosController::class, 'update/$1']);
$routes->post('alumnos/delete/(:num)', [AlumnosController::class, 'delete/$1']);

// Rutas para busqueda de alumnos por carrera
$routes->get('alumnos_carrera', 'Alumnosxcarrera::index');
$routes->post('alumnos_carrera/filtrar', 'Alumnosxcarrera::filtrar');