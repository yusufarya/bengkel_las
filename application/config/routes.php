<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Login Admin //
$route['admin'] = 'Login/adm';
$route['register'] = 'Login/register';
$route['logoutAdmin'] = 'Login/logout_adm';

$route['dashboard'] = 'Dashboard';
$route['driver'] = 'Dashboard/driver';

// Master Data KATEGORI //
$route['kategoriList'] = 'Master/kategoriList';
$route['addKategori'] = 'Master/addKategori';
$route['updateKategori'] = 'Master/updateKategori';

// Master Data BAHAN BAKU //
$route['bahanBakuList'] = 'Master/bahanBakuList';
$route['addBahanbaku'] = 'Master/addBahanbaku';
$route['updateBahanbaku'] = 'Master/updateBahanbaku';

// Master Data Metode Pembayaran //
$route['metodeBayarList'] = 'Master/metodeBayarList';
$route['addMetodeBayar'] = 'Master/addMetodeBayar';
$route['updateMetodeBayar'] = 'Master/updateMetodeBayar';
$route['deleteMetodeBayar'] = 'Master/deleteMetodeBayar';

// Master Data Driver //
$route['listDriver'] = 'Master/listDriver';
$route['addDriver'] = 'Master/addDriver';

// Master Data SUPPLIER //
$route['suppList'] = 'Pembelian/supplierList';
$route['addSupplier'] = 'Pembelian/addSupplier';
$route['updateSupplier'] = 'Pembelian/updateSupplier';

// Master Data CUSTOMER //
$route['custList'] = 'Penjualan/customerList';
$route['addCustomer'] = 'Penjualan/addCustomer';
$route['updateCustomer'] = 'Penjualan/updateCustomer';

// Transaksi //
$route['listPesanan'] = 'Transaksi/listPesanan';

// PEMBELIAN //
$route['piList'] = 'Pembelian/listPembelian';
$route['addDataPi'] = 'Pembelian/addPi';
$route['editDataPi/(:any)'] = 'Pembelian/editPi/$1';

// PENJUALAN //
$route['siList'] = 'Penjualan/listPenjualan';
$route['addDataSi'] = 'Penjualan/addSi';
$route['editDataSi/(:any)'] = 'Penjualan/editSi/$1';


// PELANGGAN // 
$route['logout'] = 'Login/logout';
$route['transaksi_saya'] = 'Pelanggan/transaksi';
$route['pesanan_saya'] = 'Pelanggan/pesanan';
$route['pesan'] = 'Pelanggan/pesan';
$route['pembayaran/(:any)'] = 'Pelanggan/pembayaran/$1';
$route['kirimBuktiBayar/(:any)'] = 'Pelanggan/kirimBuktiBayar/$1';
$route['send_trx'] = 'Pelanggan/updateBayar';
