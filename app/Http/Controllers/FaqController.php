<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Http\Requests\FaqRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
class FaqController extends Controller
{
    public function show()
    {   
        $faqs = Faq::all();
        if(Auth::check()){
            $user_type = Auth::user()->persistentUser->type_;
        }
        else{
            $user_type = 'Guest';
        }
        return view('pages.faqs', [
            'faqs' => $faqs,
            'user_type' => $user_type
        ]);
    }
    public function add(FaqRequest $request) : RedirectResponse
    {   
        try{
            $request->validated();
            $faq = new Faq();
            $faq->question = $request['faq'];
            $faq->answer = $request['answer'];
            $faq->save();
            return redirect()->route('show-faqs')->wihSuccess('FAQ added successfully!');
        }
        catch(\Exception $e){
            return redirect()->route('show-faqs')->withError('String too long!');
        }
       
    }
    public function delete(FaqRequest $request): RedirectResponse
    {   $request->validated();
        $faq = Faq::find($request['id']);
        $faq->delete();
        return redirect()->route('show-faqs')->withSuccess('FAQ deleted successfully!');
    }
}
