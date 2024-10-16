<?php

namespace App\Http\Controllers;

use App\Models\BookTranslation;
use App\Models\BookTranslationComments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookTranslationController extends Controller
{
    //
    public function index(){
        $booklistings = BookTranslation::with('comment')->get();
       // echo "<pre>"; print_r($booklistings); die;
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

        $commentId = $request->input('comment_id');
        $validated = $request->validate([
            'book_translation_id' => 'nullable|integer',
            'comment' => 'required',
            'type' => 'nullable',
        ]);
        $validated['comment'] =  htmlspecialchars($request->comment, ENT_QUOTES, 'UTF-8');
        $validated['user_id'] = Auth::id();
        $validated['proof_read_user'] = Auth::id();
        if(!empty($commentId)){
            BookTranslationComments::find($commentId)->update($validated);
        }else{
            BookTranslationComments::create($validated);
        }
        // return response()->json([
        //     'success' => 'Comment added successful','data' => $commentData
        // ]);
         return redirect()->back()->with(['success'=>'Comment added Successfully']);
    }


    public function store(Request $request){
        $validated = $request->validate([
            'book_number' => 'nullable|integer',
            'chapter' => 'nullable|integer',
            'page_number' => 'nullable|integer',
            'sentence' => 'nullable|integer',
            'text' => 'nullable|string',
            'supporting_language' =>  'nullable|string',
            // 'urdu_audio' => 'required|mimes:mp3,wav|max:2097152',

        ]);
        $validated['user_id'] = Auth::id();

        if ($request->hasFile('urdu_audio')) {
            try {

                $file = $request->file('urdu_audio');
                $audioFileName = time() . '.' . $file->getClientOriginalExtension();
                // Upload the file to S3 and get the path
                $path = Storage::disk('s3')->putFile('uploads', $file);
                $validated['urdu_audio'] = Storage::disk('s3')->url($path);

            } catch (\Throwable $th) {
                // Return error message
                Log::info("Error In Upload save".$th->getMessage());
            }
        }
        // Create new TextRecord
       $book =  BookTranslation::create($validated);

        BookTranslationComments::create([
            'book_translation_id' => $book->id,
            'proof_read_user' => Auth::id(),
            'user_id' => Auth::id()
        ]);
        return response()->json([
            'success' => 'Book Created Successfully'
        ]);

    }
    public function edit($id){
        $book = BookTranslation::findOrFail($id);

        return response()->json([
            'success' => 'Book data fetched','data' => $book
        ]);

        // return view('pages.books.create',compact('book'));
    }

    public function update(Request $request,$id){
        $validated = $request->validate([
            'book_number' => 'nullable|integer',
            'chapter' => 'nullable|integer',
            'page_number' => 'nullable|integer',
            'sentence' => 'nullable|integer',
            'text' => 'nullable|string',
            'supporting_language' =>  'nullable|string',
            // 'text_status' => 'required',
            // 'urdu_audio' => 'nullable|file|mimes:mp3,wav',
            // 'urdu_audio_status' => 'required|in:approved_with_no_comment,approved_with_comment,reject_revise_and_resubmit,under_review',
        ]);


        // Find the record by ID
        $bookTranslation = BookTranslation::findOrFail($id);

        if ($request->hasFile('urdu_audio')) {


            try {

                $file = $request->file('urdu_audio');
                $audioFileName = time() . '.' . $file->getClientOriginalExtension();
                // Upload the file to S3 and get the path
                $path = Storage::disk('s3')->putFile('uploads', $file);
                $validated['urdu_audio'] = Storage::disk('s3')->url($path);

            } catch (\Throwable $th) {
                // Return error message
                Log::info("Error In Upload".$th->getMessage());
            }
        }

        // Update record
        $bookTranslation->update($validated);

        return response()->json([
            'success' => 'Book data fetched'
        ]);

        // return redirect()->back()->with('success','Book Updated Successfully');
    }

    public function statusUpdate(Request $request,$id){

        $validated = $request->validate([
             'text_status' => 'required|in:approved_without_comment,approved_with_comment,reject_revise_and_resubmit,under_review,in-process',
        ]);
        $user =Auth::user();
        if($request->input('text_status') == 'approved_without_comment'){
            $current_proof_reader = ($user->user_level == 'admin') ? 0 :  $user->user_level + 1;
            $validated['current_user_level'] = $current_proof_reader;
        }else{
            $current_proof_reader = ($user->user_level == 'admin') ? 0 : $user->user_level;
            $validated['current_user_level'] = $current_proof_reader;
        }
        $bookTranslation = BookTranslationComments::findOrFail($id)->update($validated);

        return response()->json([
            'success' => 'Status has been updated','data' => $bookTranslation
        ]);
    }

    public function AudiostatusUpdate(Request $request,$id){

        $validated = $request->validate([
             'urdu_audio_status' => 'required|in:approved_without_comment,approved_with_comment,reject_revise_and_resubmit,under_review,in-process',
        ]);
        // $user =Auth::user();
        // if($request->input('urdu_audio_status') == 'approved_without_comment'){
        //    // $current_proof_reader = ($user->user_level == 'admin') ? 0 :  $user->user_level + 1;
        //   //  $validated['current_user_level'] = $current_proof_reader;
        // }else{
        //   //  $current_proof_reader = ($user->user_level == 'admin') ? 0 : $user->user_level;
        //     //$validated['current_user_level'] = $current_proof_reader;
        // }
        $bookTranslation = BookTranslationComments::findOrFail($id)->update($validated);

        return response()->json([
            'success' => 'Status has been updated','data' => $bookTranslation
        ]);
    }

    public function delete($id)
    {
        BookTranslation::find($id)->delete();
        return redirect()->back()->with('success', 'deleted successfully');
    }

}
