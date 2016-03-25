<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//基本轉址
$route['default_controller'] = 'index';
$route['404_override'] = '';
$route['admin'] = 'admin/rewrite';

//購物功能
$route['product'] = 'shop/product';
$route['product/(:any)'] = "shop/product/view/$1";
$route['shop'] = 'shop/store';
$route['store'] = 'shop/store';
$route['store/(:any)'] = 'shop/store/view/$1';
$route['order'] = 'shop/order';
$route['order/(:any)'] = 'shop/order/$1';

//手機功能
$route['mobile'] = 'mobile/index';
$route['mobile/(:any)'] = 'mobile/index';

//其它app
$route['page/(:num)'] = "page/view/$1";
$route['page/slug/(:any)'] = "page/view/$1";
$route['pager/(:num)'] = "page/view/$1";
$route['pager/slug/(:any)'] = "page/view/$1";
$route['note/(:num)'] = "note/view/$1";
$route['note/slug/(:any)'] = "note/view/$1";
$route['pdf/(:num)'] = "pdf/view/$1";
$route['pdf/slug/(:any)'] = "pdf/view/$1";
$route['pic/(:num)'] = "pic/view/$1";
$route['pic/slug/(:any)'] = "pic/view/$1";
$route['showpiece/(:num)'] = "showpiece/view/$1";
$route['showpiece/slug/(:any)'] = "showpiece/view/$1";
$route['space/(:num)'] = "space/view/$1";
$route['space/slug/(:any)'] = "space/view/$1";


/* End of file routes.php */
/* Location: ./application/config/routes.php */