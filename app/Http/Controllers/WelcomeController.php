<?php

namespace App\Http\Controllers;

use App\Models\PageView;
use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        $pageName = 'Pagina principal';
        $PageView = $this->pageView($pageName);
        $allProductos = Producto::with('ratings')->get();
        $allProductos = $allProductos->map(function ($producto) {
            $producto->averageRating = $producto->averageRating();  // Agregar calificación promedio
            return $producto;
        });
        return Inertia::render('LandingPage/index', [
            'productos' => $allProductos,
            'pageview' => $PageView,

        ]);
    }


    public function search(Request $request)
    {
        $pageName = 'Seccion Busqueda';
        $PageView = $this->pageView($pageName);
        $search = $request->input('search');

        // Realizamos la consulta insensible a mayúsculas/minúsculas
        $productos = Producto::query()
            ->when($search, function ($query, $search) {
                // Convertimos a minúsculas ambos, el campo 'nombre' y la búsqueda
                $query->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereHas('categoria', function ($query) use ($search) {
                        // También para la categoría, convertimos 'nombre' a minúsculas
                        $query->whereRaw('LOWER(nombre) LIKE ?', ['%' . strtolower($search) . '%']);
                    });
            })
            ->paginate(6);

        return response()->json(['productos' => $productos]);

        return Inertia::render('LandingPage/index', [
            'productos' => $productos,
            'search' => $search,
            'pageview' => $PageView,
        ]);
    }



        public function pageView($pageName){
            $PageView = PageView::where('page_name', $pageName)->first();
            if (!$PageView) {
                PageView::create([
                    'page_name' => $pageName,
                    'visits' => 1,
                ]);
            } else {
                $PageView->increment('visits');
            }
            $PageView = PageView::where('page_name', $pageName)->first();
            return $PageView;
        }


}
