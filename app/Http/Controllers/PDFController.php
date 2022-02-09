<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReconciledData;

class PDFController extends Controller
{
    public function bavaPDF(Request $request){
    	$query = ReconciledData::query();
        $query->whereHas("data", function ($q) use ($request) {
            $q->where('branch_name', $request->branch);
        });
        $data = $query->get();
        $branch_name = $request->branch;

        $fileName = "Bava.pdf";
        $mpdf = new \Mpdf\Mpdf([
        	'margin_left' => 10,
        	'margin_right' => 10,
        	'margin_top' => 15,
        	'margin_down' => 20,
        	'margin_header' => 20,
        	'margin_footer' => 10,
        ]);
        $html = \View::make('pdf.bava')->with('data',$data);
        $html->render();
        $stylesheet = file_get_contents('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');
    }
}
