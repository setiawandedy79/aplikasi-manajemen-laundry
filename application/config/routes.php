<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['auth'] = 'auth';
$route['auth/login'] = 'auth/login';
$route['auth/logout'] = 'auth/logout';
$route['dashboard'] = 'dashboard';

// Master
$route['pakaian'] = 'pakaian';
$route['sabun'] = 'sabun';
$route['satuan_sabun'] = 'satuan_sabun';
$route['pelanggan'] = 'pelanggan';
$route['users'] = 'users';
$route['users/add'] = 'users/add';
$route['users/save'] = 'users/save';
$route['users/edit/(:num)'] = 'users/edit/$1';
$route['users/update/(:num)'] = 'users/update/$1';
$route['users/delete/(:num)'] = 'users/delete/$1';

// Transaksi
$route['transaksi'] = 'transaksi';
$route['transaksi/edit/(:num)'] = 'transaksi/edit/$1';
$route['transaksi/update/(:num)'] = 'transaksi/update/$1';

// Laporan
$route['laporan'] = 'laporan';
$route['laporan/mutasi_masuk'] = 'laporan/mutasi_masuk';
$route['laporan/pemakaian_shift'] = 'laporan/pemakaian_shift';
$route['laporan/stok_sabun'] = 'laporan/stok_sabun';
$route['laporan/transaksi'] = 'laporan/transaksi';

// Pemakaian
$route['pemakaian'] = 'pemakaian';
$route['pemakaian/add'] = 'pemakaian/add';
$route['pemakaian/save'] = 'pemakaian/save';
$route['pemakaian/edit/(:num)'] = 'pemakaian/edit/$1';
$route['pemakaian/update/(:num)'] = 'pemakaian/update/$1';
$route['pemakaian/delete/(:num)'] = 'pemakaian/delete/$1';

// Mutasi
$route['mutasi'] = 'mutasi';
$route['mutasi/add'] = 'mutasi/add';
$route['mutasi/save'] = 'mutasi/save';
$route['mutasi/edit/(:num)'] = 'mutasi/edit/$1';
$route['mutasi/update/(:num)'] = 'mutasi/update/$1';
$route['mutasi/delete/(:num)'] = 'mutasi/delete/$1';

// Penyerahan
$route['penyerahan'] = 'penyerahan';
$route['penyerahan/form/(:num)'] = 'penyerahan/form/$1';
$route['penyerahan/save'] = 'penyerahan/save';

// Supplier
$route['supplier'] = 'supplier';
$route['supplier/add'] = 'supplier/add';
$route['supplier/save'] = 'supplier/save';
$route['supplier/edit/(:num)'] = 'supplier/edit/$1';
$route['supplier/update/(:num)'] = 'supplier/update/$1';
$route['supplier/delete/(:num)'] = 'supplier/delete/$1';

//Pengambilan
//$route['laporan/pengambilan_linen'] = 'laporan/pengambilan_linen';
//$route['laporan/print_pengambilan_linen'] = 'laporan/print_pengambilan_linen';

// Pengembalian
$route['laporan/pengembalian_linen'] = 'laporan/pengembalian_linen';
$route['laporan/print_pengembalian_linen'] = 'laporan/print_pengembalian_linen';

// application/config/routes.php
$route['laporan/rekapitulasi_pencucian'] = 'laporan/rekapitulasi_pencucian';
$route['laporan/print_rekapitulasi_pencucian'] = 'laporan/print_rekapitulasi_pencucian';

// Log Activity
$route['log_activity'] = 'log_activity';

// $route['default_controller'] = 'welcome';
// $route['404_override'] = '';
// $route['translate_uri_dashes'] = FALSE;
