<?php
   return [

    App\Core\Route::get('|^admin/login/?$|', 'Main', 'getLogin'),
    App\Core\Route::post('|^admin/login/?$|', 'Main', 'postLogin'),
    App\Core\Route::get('|^admin/logout/?$|', 'Main', 'getLogout'),
    App\Core\Route::get('|^contact/store_locator/?$|', 'Contact', 'storeLocator'),
    
    
    
    App\Core\Route::get('|^user/reservation/?$|', 'Main', 'getReservation'),
    App\Core\Route::post('|^user/reservation/?$|', 'Main', 'postReservation'),
    App\Core\Route::post('|^user/reservationTermUser/?$|', 'Main', 'postReservationTermUser'),

     App\Core\Route::get('|^exhibition/([0-9]+)/?$|', 'Exhibition', 'show'),
                    //ruta za prikazivanje pojedinacnih izlozbi po id-ju
     App\Core\Route::get('|^exhibitions/?$|', 'Exhibition', 'exhibitions'),
     App\Core\Route::get('|^location/([0-9]+)/?$|', 'Location', 'show'),
     App\Core\Route::get('|^term/([0-9]+)/?$|', 'Term', 'show'),
     App\Core\Route::get('|^locations/?$|', 'Location', 'locations'),
     App\Core\Route::get('|^user/([0-9]+)/?$|', 'User', 'show'),
     App\Core\Route::post('|^search/?$|', 'Term', 'postSearch'),


     #API rute:

     App\Core\Route::get('|^api/exhibition/([0-9]+)/?$|', 'ApiExhibition', 'show'),
     App\Core\Route::get('|^api/bookmarks/?$|', 'ApiBookmark', 'getBookmarks'),
     App\Core\Route::get('|^api/bookmarks/add/([0-9]+)/?$|', 'ApiBookmark', 'addBookmark'),
     App\Core\Route::get('|^api/bookmarks/clear/?$|', 'ApiBookmark', 'clear'),
     
     #Admin role ruta:
    //ruta samo za admina, samo je njemu vidljiv sadrzaj kad se uloguje
    App\Core\Route::get('|^admin/profile/?$|', 'AdminDashboard', 'index'),
     
    App\Core\Route::get('|^admin/locations/?$|', 'AdminLocationManagement', 'locations'), // ruta za izmenu lokacija
    App\Core\Route::get('|^admin/locations/edit/([0-9]+)/?$|', 'AdminLocationManagement', 'getEdit'), // ruta za izmenu lokacija
    App\Core\Route::post('|^admin/locations/edit/([0-9]+)/?$|','AdminLocationManagement', 'postEdit'),
    App\Core\Route::get('|^admin/locations/add/?$|', 'AdminLocationManagement', 'getAdd'),
    App\Core\Route::post('|^admin/locations/add/?$|', 'AdminLocationManagement', 'postAdd'),
    App\Core\Route::get('|^admin/reservation/([0-9]+)/?$|', 'Reservation', 'show'),                //ruta za prikazivanje potrebnih informacija o rezervaciji
    App\Core\Route::get('|^admin/reservations/?$|', 'Reservation', 'reservations'),


     App\Core\Route::any('|^.*$|', 'Main', 'home')

   ]; 