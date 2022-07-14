<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Inertia\Inertia;

class NoteController extends Controller
{
    public function index() {
        return Inertia::render('Notes/List');
    }

    public function create() {
        return Inertia::render('Notes/Form');
    }

    public function edit(Note $note) {
        return Inertia::render('Notes/Form', compact('note'));
    }
}
