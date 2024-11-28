<?php

use App\Http\Controllers\CallBackAdminController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ConsultarAdminController;
use App\Http\Controllers\GenerarCobroController;
use App\Http\Controllers\PageViewController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductosLandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\WelcomeController;
use App\Models\PageView;
use App\Models\Producto;
use App\Models\Rating;
use App\Models\Role;
use App\Models\Welcome;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', WelcomeController::class)->name('/');
Route::get('/landing/productos/search', [WelcomeController::class, 'search'])->name('landing.productos.search');

Route::get('/landing/productos', [ProductosLandingController::class, 'index'])->name('landing.productos');

Route::get('/landing/producto/details/{producto_id}', [ProductosLandingController::class, 'details'])->name('landing.producto.details');
Route::post('/pagos/callback', CallBackAdminController::class)->name('admin.pagos.callback');
// CONSULTAR PAGO
Route::get('/landing/pagos/create', [PagoController::class, 'create'])->name('landing.pagos.create');
Route::get('/landing/pagos/consultar', [ConsultarAdminController::class, '__invoke'])->name('landing.pagos.consultar');
Route::get('/admin/ratings', [RatingController::class, 'index'])->name('admin.ratings');
Route::post('/landing/ratings/register', [RatingController::class, 'storerating'])->name('landing.ratings.storerating');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


      // GESTIONAR ROLES
      Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles');
      Route::get('/admin/roles/create', [RoleController::class, 'create'])->name('admin.roles.create');
      Route::post('/admin/roles/register', [RoleController::class, 'store'])->name('admin.roles.store');
      Route::get('/admin/roles/edit/{role}', [RoleController::class, 'edit'])->name('admin.roles.edit');
      Route::patch('/admin/roles/edit/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
      Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');


      // GESTIONAR USUARIOS
      Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
      Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
      Route::post('/admin/users/register', [UserController::class, 'store'])->name('admin.users.store');
      Route::get('/admin/users/edit/{user}', [UserController::class, 'edit'])->name('admin.users.edit');
      Route::post('/admin/users/edit/{user}', [UserController::class, 'update'])->name('admin.users.update');
      Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

       // GESTIONAR CATEGORIAS
       Route::get('/admin/categorias', [CategoriaController::class, 'index'])->name('admin.categorias');
       Route::get('/admin/categorias/create', [CategoriaController::class, 'create'])->name('admin.categorias.create');
       Route::post('/admin/categorias/register', [CategoriaController::class, 'store'])->name('admin.categorias.store');
       Route::get('/admin/categorias/edit/{categoria}', [CategoriaController::class, 'edit'])->name('admin.categorias.edit');
       Route::patch('/admin/categorias/edit/{categoria}', [CategoriaController::class, 'update'])->name('admin.categorias.update');
       Route::delete('/admin/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('admin.categorias.destroy');

        // GESTIONAR PRODUCTOS
        Route::get('/admin/productos', [ProductoController::class, 'index'])->name('admin.productos');
        Route::get('/admin/productos/create', [ProductoController::class, 'create'])->name('admin.productos.create');
        Route::post('/admin/productos/register', [ProductoController::class, 'store'])->name('admin.productos.store');
        Route::get('/admin/productos/edit/{producto}', [ProductoController::class, 'edit'])->name('admin.productos.edit');
        Route::post('/admin/productos/edit/{producto}', [ProductoController::class, 'update'])->name('admin.productos.update');
        Route::delete('/admin/productos/{producto}', [ProductoController::class, 'destroy'])->name('admin.productos.destroy');



         // GESTIONAR  RATINGS

         Route::get('/admin/ratings/create', [RatingController::class, 'create'])->name('admin.ratings.create');
         Route::post('/admin/ratings/register', [RatingController::class, 'store'])->name('admin.ratings.store');
         Route::get('/admin/ratings/edit/{producto}', [RatingController::class, 'edit'])->name('admin.ratings.edit');
         Route::post('/admin/ratings/edit/{producto}', [RatingController::class, 'update'])->name('admin.ratings.update');
         Route::delete('/admin/ratings/{producto}', [RatingController::class, 'destroy'])->name('admin.ratings.destroy');


          //GESTIONAR VENTAS
         Route::get('/admin/ventas',[VentaController::class, 'index'])->name('admin.ventas');
         Route::get('/admin/ventas/catalogo',[VentaController::class, 'catalogo'])->name('admin.ventas.catalogo');
         Route::get('/admin/ventas/create',[VentaController::class, 'create'])->name('admin.ventas.create');
         Route::post('/admin/ventas/store',[VentaController::class, 'store'])->name('admin.ventas.store');
         Route::get('/admin/ventas/edit/{venta}',[VentaController::class, 'edit'])->name('admin.ventas.edit');
         Route::patch('/admin/ventas/update/{venta}', [VentaController::class, 'update'])->name('admin.ventas.update');
         Route::delete('admin/ventas/destroy/{venta}',  [VentaController::class, 'destroy'])->name('admin.ventas.destroy');

        //GESTIONAR PAGOS
         Route::get('/admin/pagos',[PagoController::class, 'index'])->name('admin.pagos');
         Route::get('/admin/pagos/create',[PagoController::class, 'create'])->name('admin.pagos.create');
         Route::post('/admin/pagos/store',[PagoController::class, 'store'])->name('admin.pagos.store');
         Route::get('/admin/pagos/edit/{pago}',[PagoController::class, 'edit'])->name('admin.pagos.edit');
        Route::patch('/admin/pagos/update/{pago}', [PagoController::class, 'update'])->name('admin.pagos.update');
         Route::delete('admin/pagos/destroy/{pago}',  [PagoController::class, 'destroy'])->name('admin.pagos.destroy');


          //GESTIONAR REPORTES Y ESTADISTICAS
          Route::get('/admin/reportes',[ReporteController::class, 'index'])->name('admin.reportes');

            //GESTIONAR VIEWS
            Route::get('/admin/views',[PageViewController::class, 'index'])->name('admin.views');


          // PAGOS WEB

          Route::post('/pagos/generarCobro', [GenerarCobroController::class, 'generarCobro'])->name('admin.pagos.generarCobro');
          Route::post('/pagos/callback', CallBackAdminController::class)->name('admin.pagos.callback');
          Route::get('/pagos/consultar/{venta_id}', ConsultarAdminController::class)->name('admin.pagos.consultar');

});

require __DIR__.'/auth.php';
