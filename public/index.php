
<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Model.php';


$router = new Router();


$router->get('/', 'LoginController@index');
$router->post('/login', 'LoginController@login');
$router->get('/logout', 'LoginController@logout');

$router->get('/admin/dashboard', 'AdminController@dashboard');
$router->get('/user/dashboard', 'UserController@dashboard');

$router->get('/admin/add-room', 'AdminController@addRoomForm');
$router->post('/admin/add-room', 'AdminController@addRoom');

$router->get('/admin/register-user', 'AdminController@registerUserForm');
$router->post('/admin/register-user', 'AdminController@registerUser');

$router->get('/admin/list-users', 'AdminController@listUsers');
$router->get('/admin/list-rooms', 'AdminController@listRooms');

$router->get('/admin/edit-room', 'AdminController@editRoomForm');
$router->post('/admin/edit-room', 'AdminController@editRoom');
$router->get('/admin/delete-room', 'AdminController@deleteRoom');
$router->get('/admin/deactivate-room', 'AdminController@deactivateRoom');

$router->get('/admin/edit-user', 'AdminController@editUserForm');
$router->post('/admin/edit-user', 'AdminController@editUser');
$router->get('/admin/delete-user', 'AdminController@deleteUser');
$router->get('/admin/deactivate-user', 'AdminController@deactivateUser');

$router->get('/admin/edit-reservation', 'AdminController@editReservationForm');
$router->post('/admin/edit-reservation', 'AdminController@editReservation');


$router->get('/user/book-room', 'UserController@bookRoomForm');

$router->get('/user/my-reservations', 'UserController@myReservations');

$router->post('/user/book-room', 'UserController@bookRoom');
$router->post('/user/confirm-booking', 'UserController@confirmBooking');

// Rezervacije - korisnik

$router->post('/user/find-rooms', 'UserController@findRooms');
$router->post('/user/book-room-details', 'UserController@bookRoomDetails'); 
$router->post('/user/confirm-booking', 'UserController@confirmBooking'); 



$router->get('/profile', 'ProfileController@show');



$router->get('/test', 'TestController@index');


$router->dispatch();
?>
