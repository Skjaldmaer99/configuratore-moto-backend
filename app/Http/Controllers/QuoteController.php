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

            $pdf = Pdf::loadView(
                'pdf.quote', // view
                [
                    'configuration' => $configuration // dati
                ]
            );

            $fileName = 'preventivo_' . $configuration->id . '.pdf';

            $path = 'quotes/' . $fileName;

            Storage::disk('public')
                ->put($path, $pdf->output());

            $preventivo = Quote::create([
                'configuration_id' => $configuration->id,
                'total_price' => $configuration->total_price,
                'pdf_path' => $path
            ]);

            return response()->json([
                'success' => true,
                'data' => $preventivo
            ]);
        }catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function download(Quote $quote) {
        return Storage::disk('public')->download($quote->pdf_path);
    }
}
