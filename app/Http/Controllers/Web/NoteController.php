<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class NoteController extends Controller
{
    public function index() {
        return Inertia::render('Notes/List');
    }

    public function create() {
        return Inertia::render('Notes/Create');
    }
}
