<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditCommentRequest;
use App\Models\TaskComment;
use App\Models\WorldComment;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    private $comment;

    public function edit(EditCommentRequest $request, string $id): RedirectResponse
    {
        $fields = $request->validated();

        switch ($fields['type']) {
            case 'world':
                $this->comment = WorldComment::findOrFail($id);
                break;
            case 'task':
                $this->comment = TaskComment::findOrFail($id);
        }

        $this->comment->content = $fields['text'];
        $this->comment->save();

        return redirect()->back()->withFragment('#comments')->withSuccess('Comment edited!');
    }
}
