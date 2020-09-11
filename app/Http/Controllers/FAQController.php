<?php


namespace App\Http\Controllers;


use App\Http\Resources\FAQCollection;
use App\Http\Resources\FAQResource;
use App\Models\FAQ;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    use ApiResponser;

    public function getFAQs(Request $request)
    {
        $fqas = FAQ::where('type', $request->type)->get();
        return $this->successResponseMessage(new FAQCollection($fqas), 200, 'Get FQAs success');
    }

}
