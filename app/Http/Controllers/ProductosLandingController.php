<?php

namespace App\Http\Controllers;

use App\Models\PageView;
use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductosLandingController extends Controller
{

    public function index()
    {
        $pageName = 'Seccion Productos';
        $PageView = $this->pageView($pageName);

        $allProductos = Producto::with('ratings')->get();
        $allProductos = $allProductos->map(function ($producto) {
            $producto->averageRating = $producto->averageRating();  // Agregar calificación promedio
            return $producto;
        });

        // Verificar el resultado con dd()
      //  dd($allProductos);

        return Inertia::render('LandingPage/Components/ProductosSeccion', [
            'productos' => $allProductos,
            'pageview' => $PageView,
        ]);
    }



    public function details($producto_id)
    {
        $producto = Producto::find($producto_id);
        $producto->averageRating = $producto->averageRating();
        if (!$producto) {
            abort(404, 'Producto no encontrado');
        }
        $pageName = "Producto: " . $producto->nombre;
        $PageView = $this->pageView($pageName);
        return Inertia::render('LandingPage/Components/ProductoDetails', [
            'producto' => $producto,
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


        public function search(Request $request)
        {
            dd($request);
            $query = $request->input('query');
            $productos = Producto::where('nombre', 'like', '%' . $query . '%')
                                 ->orWhereHas('categoria', function ($query) use ($request) {
                                     $query->where('nombre', 'like', '%' . $request->query . '%');
                                 })
                                 ->with('categoria')
                                 ->get();

            return response()->json([
                'productos' => $productos
            ]);
        }

}
