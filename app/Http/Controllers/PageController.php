<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function contact()
    {
        return view('pages.contact');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function technicalSupport()
    {
        return view('pages.technical-support');
    }

    public function shippingReturns()
    {
        return view('pages.shipping-returns');
    }

    public function faq()
    {
        $faqs = \App\Models\Faq::active()->ordered()->get()->groupBy('category');
        return view('pages.faq', compact('faqs'));
    }

    public function privacy()
    {
        return view('pages.privacy');
    }
} 