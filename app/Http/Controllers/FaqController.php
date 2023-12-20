<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Http\Requests\FaqRequest;
use Illuminate\Http\RedirectResponse;
class FaqController extends Controller
{
    public function show()
    {   
        $faqs = Faq::all();
        return view('pages.faqs', [
            'faqs' => $faqs,
        ]);
    }
    public function add(FaqRequest $request) : RedirectResponse
    {   
        $request->validated();
        $faq = new Faq();
        $faq->question = $request['faq'];
        $faq->answer = $request['answer'];
        $faq->save();
        return redirect()->route('show-faqs')->wihSuccess('FAQ added successfully!');
    }
    public function delete(FaqRequest $request): RedirectResponse
    {   $request->validated();
        $faq = Faq::find($request['id']);
        $faq->delete();
        return redirect()->route('show-faqs')->withSuccess('FAQ deleted successfully!');
    }
}
