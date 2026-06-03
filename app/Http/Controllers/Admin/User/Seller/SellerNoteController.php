<?php

namespace App\Http\Controllers\Admin\User\Seller;

use App\Models\Note;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\NoteService;
use App\Http\Requests\Admin\User\Seller\Note\NoteCreateRequest;
use App\Http\Requests\Admin\User\Seller\Note\NoteUpdateRequest;

class SellerNoteController extends Controller
{
    use ApiResponse;

    private $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    public function index(User $user, Request $request)
    {
        if ($request->ajax()) {
            return $this->noteService->dataTable($user->id);
        }

        return view('admin.pages.user.seller.note.index', compact('user'));
    }

    public function create(User $user): View
    {
        return view('admin.pages.user.seller.note.create', [
            'user' => $user,
        ]);
    }

    public function store(NoteCreateRequest $request, User $user): RedirectResponse
    {
        $result = $this->noteService->store($request->validated(), $user->id);

        if ($result) {
            return redirect(route('admin.user.seller.note.index', $user->id))->with('success', $this->noteService->message);
        }

        return back()->withInput($request->all())->with('error', $this->noteService->message);
    }

    public function show(Request $request, Note $note)
    {
        abort_unless($note, 404);

        return response($note);
    }

    public function edit(Note $note): View
    {
        abort_unless($note, 404);

        return view('admin.pages.user.seller.note.edit', [
            'note' => $note
        ]);
    }

    public function update(NoteUpdateRequest $request, Note $note): RedirectResponse
    {
        abort_unless($note, 404);
        $result = $this->noteService->update($request->validated(), $note);

        if ($result) {
            return redirect(route('admin.user.seller.note.index', $note->user_id))->with('success', $this->noteService->message);
        }

        return back()->withInput($request->all())->with('error', $this->noteService->message);
    }

    public function destroy(Note $note): RedirectResponse
    {
        abort_unless($note, 404);
        $user_id = $note->user_id;

        $note->delete();

        return redirect(route('admin.user.seller.note.index', $user_id))->with('success', 'Successfully Deleted !!!');
    }
}
