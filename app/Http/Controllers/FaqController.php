<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Http\Requests\FaqRequest;
class FaqController extends Controller
{
    public function show()
    {
        $faqs = Faq::all();
        return view('pages.faqs', [
            'faqs' => $faqs,
        ]);
    }
    public function add(FaqRequest $request)
    {
        $faq = new Faq();
        $faq->question = $request['question'];
        $faq->answer = $request['answer'];
        $faq->save();
        return redirect()->route('show-faqs');
    }
    public function delete(FaqRequest $request)
    {
        $faq = Faq::find($request['id']);
        $faq->delete();
        return redirect()->route('show-faqs');
    }
}
