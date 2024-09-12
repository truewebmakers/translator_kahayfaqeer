<?php

namespace App\Http\Controllers;

use App\Models\BookTranslation;
use App\Models\BookTranslationComments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookTranslationController extends Controller
{
    //
    public function index(){
        $booklistings = BookTranslation::with('comment')->get();
        return view('pages.books.index',compact('booklistings'));
    }

    public function book_comment($id){
        $book = BookTranslation::with('comment')->find($id);

       // dd($book);
        return view('pages.books.comment',compact('book'));
    }
    public function create(){
        return view('pages.books.create');
    }


    public function storeComment(Request $request){
        $validated = $request->validate([
            'book_translation_id' => 'nullable|integer',
            'comment' => 'required',
            'type' => 'nullable',
        ]);
        $validated['user_id'] = Auth::id();
        $commentData = BookTranslationComments::create($validated);
        return response()->json([
            'success' => 'Comment added successful','data' => $commentData
        ]);
        // return redirect()->back()->with(['success'=>'Comment added Successfully']);
    }


    public function store(Request $request){
        $validated = $request->validate([

            'book_number' => 'nullable|integer',
            'chapter' => 'nullable|integer',
            'page_number' => 'nullable|integer',
            'sentence' => 'nullable|integer',
            'text' => 'nullable|string',
            // 'text_status' => 'required|in:approved,comment,user_review',
            'urdu_audio' => 'nullable|string',
            // 'urdu_audio_status' => 'required|in:approved_with_no_comment,approved_with_comment,reject_revise_and_resubmit,under_review',
        ]);
        $validated['user_id'] = Auth::id();

        if ($request->hasFile('urdu_audio')) {
            $validated['urdu_audio'] = $request->file('urdu_audio')->store('urdu_audio_files');
        }

        // Create new TextRecord
        $textRecord = BookTranslation::create($validated);

        return redirect()->back()->with('success','Book Created Successfully');
    }
    public function edit($id){
        $book = BookTranslation::findOrFail($id);

        return view('pages.books.create',compact('book'));
    }

    public function update(Request $request,$id){
        $validated = $request->validate([
            'book_number' => 'nullable|integer',
            'chapter' => 'nullable|integer',
            'page_number' => 'nullable|integer',
            'sentence' => 'nullable|integer',
            'text' => 'nullable|string',
            'text_status' => 'required',
            'urdu_audio' => 'nullable|string',
            // 'urdu_audio_status' => 'required|in:approved_with_no_comment,approved_with_comment,reject_revise_and_resubmit,under_review',
        ]);

        // Find the record by ID
        $bookTranslation = BookTranslation::findOrFail($id);

        if ($request->hasFile('urdu_audio')) {
            // Delete old file if exists
            if ($bookTranslation->urdu_audio) {
                Storage::delete($bookTranslation->urdu_audio);
            }
            $validated['urdu_audio'] = $request->file('urdu_audio')->store('urdu_audio_files');
        }

        // Update record
        $bookTranslation->update($validated);

        return redirect()->back()->with('success','Book Updated Successfully');
    }

    public function statusUpdate(Request $request,$id){

        $validated = $request->validate([
             'text_status' => 'required|in:approved_without_comment,approved_with_comment,reject_revise_and_resubmit,under_review,in-progress',
        ]);
        $bookTranslation = BookTranslation::findOrFail($id)->update($validated);
        return response()->json([
            'success' => 'Status has been updated','data' => $bookTranslation
        ]);
    }

}
