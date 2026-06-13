<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class QuoteController extends Controller
{
    public function generate(Configuration $configuration) {
        try {
            $configuration->load([ // carico le relazioni
                'model',
                'color',
                'engine',
                'optionals',
                'accessories'
            ]);

            $pdf = Pdf::loadView('pdf.quote', [ // per mostrare la view Blade
                    'configuration' => $configuration // dati
                ]);

            $fileName = 'preventivo_' . $configuration->model->name . $configuration->engine->name . '.pdf';

            $path = 'quotes/' . $fileName;

            Storage::disk('public')
                ->put($path, $pdf->output());

            $preventivo = Quote::create([
                'configuration_id' => $configuration->id,
                'total_price' => $configuration->total_price,
                'pdf_path' => $path,
                'final_price' => $configuration->total_price
            ]);

            return response()->json([
                'success' => true,
                'data' => $preventivo
            ], 201);
        }catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function download(Quote $quote) {
        try {
            return Storage::disk('public')->download($quote->pdf_path);

        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
