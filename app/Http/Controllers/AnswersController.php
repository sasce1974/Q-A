<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswersController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param Question $question
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Question $question, Request $request)
    {
        $request->validate([
            'body'=> 'required',
        ]);
        $question->answers()->create(['body'=>$request->body, 'user_id'=> Auth::id()]);

        // or can be shortened like this:
      //  $question->answers()->create($request->validate(['body'=> 'required'])
      //      + ['user_id'=> Auth::id()]);


        return back()->with('success', 'Your answer has been submitted successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Question $question
     * @param \App\Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question, Answer $answer)
    {
        if(\Gate::denies('update-answer', $answer)){
            abort(403, "Access Denied");
        }
        return view('answers.edit', compact('question','answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Question $question
     * @param \App\Answer $answer
     * @return void
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        if(\Gate::denies('update-answer', $answer)){
            abort(403, "Access Denied");
        }
        $answer->update($request->validate([ 'body' => 'required']));

        return redirect()->route('questions.show', $question->slug)->with('success', "Your answer has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        if(\Gate::denies('delete-answer', $answer)){
            abort(403, "Access Denied");
        }

        $answer->delete();
        return back()->with('success', "Your answer was removed.");
    }
}
