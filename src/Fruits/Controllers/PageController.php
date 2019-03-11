<?php namespace Fruits\Controllers;

class PageController extends Controller
{
    public function about()
    {
        $_PAGE = [
            'title' => 'About',
            'url'   => 'about',
        ];

        return $this->view('about')
            ->with('_PAGE', $_PAGE);
    }
}
