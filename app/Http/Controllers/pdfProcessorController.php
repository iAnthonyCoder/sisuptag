<?php

namespace App\Http\Controllers;
use App\Restore;
use Illuminate\Http\Request;
use App\Events\RestoreEvent;
use App\documento;

class pdfProcessorController extends Controller
{

    public function generatePdf($id)
    {

        $documento = documento::find($id);
        $pdfName = $id.'.pdf';
        $documento->views=$documento->views+1;

        $documento->save();
        if (!file_exists(public_path(). '//pdf//' . $pdfName)) {
            \File::put(public_path(). '//pdf//' . $pdfName, base64_decode($documento->pdf));
        }
        return redirect("pdf//".$pdfName);

    }


    public function generatePdfMobile($id)
    {

        $documento = documento::find($id);
        $documento->views=$documento->views+1;
        $counter=$documento->views;
        $documento->save();
        $pdfName = $id.'.pdf';
        if (!file_exists(public_path(). '//pdf//' . $pdfName)) {
            \File::put(public_path(). '//pdf//' . $pdfName, base64_decode($documento->pdf));
        }
        return json_encode(['success' => true, 'uri' => 'pdf', "name"=>$pdfName]);


    }

}
