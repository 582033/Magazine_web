<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Academic Free License version 3.0
 *
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

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
| There are two reserved routes:
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

$route['default_controller'] = "magazine";
$route['404_override'] = '';


$route['mag_list/(tour_reader|foreign|domestic)(/p/(:num))?'] = 'magazine/magazine_list/$1/$3';
$route['find(/p/(:num))?'] = 'magazine/find_elements/$2';

$route['mag'] = 'magazine/main_magazine_list';

$route['search/(all|magazine|author)/(:any)(/p/(:num))?'] = 'search/index/$1/$2/$4';

$route['soft'] = 'magazine/soft';
$route['soft/(pc|android)'] = 'magazine/soft/$1';

$route['magazine/detail/(:num)'] = 'magazine/magazine_detail/$1';

$route['user/element/(:num)']='user/element/$1';
$route['user/bookstore/(:num)']='user/bookstore/$1';

$route['magazine/(:num)/comment/p/(:num)'] = '/magazine/comment_list/$1/$2';

$route['(magazine|element)/(:num)/(like|cancelLike)'] = '/magazine/like/$1/$2/$3';
$route['user/(:num)/(follow|unfollow)'] = '/magazine/like/user/$1/$2';
# user/me/elements -> user/elements/me, user/me/elements/p/2 -> user/elements/me/2
$route['user/(:any)/(bookstore|magazines|elements|followees|messages)(/p/(:num))?'] = '/user/$2/$1/$4';
$route['user/me'] = 'user/bookstore/me';
$route['user/(:num)'] = 'user/magazines/$1';
$route['message/del/(:num)'] = 'user/del_msg/$1';

$route['(about_us|contact_us|business_cooperation|legal_statement)'] = '/about/foot_link/$1';
/* End of file routes.php */
/* Location: ./application/config/routes.php */
