<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Reporte;
use App\Models\Venta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Contar el número total de productos
        $totalProductos = Producto::count();

        // Sumar el monto total de ventas
        $ventasTotales = Venta::sum('montototal');

        // Obtener las ventas agrupadas por mes y sumar el monto total por mes
        $ventasPorMes = Venta::selectRaw("EXTRACT(MONTH FROM fecha::timestamp) as mes, SUM(montototal) as monto_total")
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();



        // Devolver la vista con los datos
        return Inertia::render('GestionarReportesEstadisticas/Reportes/index', [
            'totalProductos' => $totalProductos,
            'ventasTotales' => $ventasTotales,
            'ventasPorMes' => $ventasPorMes,  // Pasamos las ventas por mes
        ]);
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reporte $reporte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reporte $reporte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reporte $reporte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reporte $reporte)
    {
        //
    }
}
