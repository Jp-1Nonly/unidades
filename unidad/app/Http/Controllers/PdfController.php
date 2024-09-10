<?php

namespace App\Http\Controllers;

use App\Models\Dato;
use PDF; 
use Illuminate\Http\Request;
use App\Models\Pedido;

use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;

class PdfController extends Controller
{
    public function generarpdf($id)
{
    $pedido = Pedido::find($id);
    $datos = Dato::first();

    if (!$pedido) {
        abort(404);
    }

    $nombrePDF = 'Pedido_' . $pedido->id . '_Creado_en_' . $pedido->created_at->format('Y-m-d_H-i-s') . '.pdf';

 
    $pdf = FacadePdf::loadView('pedidos.pdf', compact('pedido', 'datos'));

    // Guardar el PDF en la carpeta deseada con el nombre generado
    $pdf->save(storage_path('app/public/pdf/' . $nombrePDF));

    // Devolver una respuesta de descarga del PDF con el nombre generado
    return $pdf->download($nombrePDF);
}
}
