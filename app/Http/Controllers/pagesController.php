<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class pagesController extends Controller
{
    public function index(){
        $title='Welcom to Laravel';
        //return view('index',compact('title'));
        return view('index')->with('title',$title);
    }
    public function abute(){
        $title='About Us';
            return view('abute')->with('title',$title);
    }
    public function category(){
        $title='category';
        return view('category')->with('title',$title);
    }
}
