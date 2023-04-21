<?php

namespace App\Http\Controllers\Frontend;

/**
 * Class TermsController.
 */
class TermsController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('frontend.pages.terms');
    }

    public function privacy_policy()
    {
        return view('frontend.pages.privacy-policy');
    }
}
