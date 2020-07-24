<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }


    //accesor
    public function getUrlAttribute(){
        //return route("questions.show", $this->id);
        return "#";
    }

    public function getAvatarAttribute(){
        $email = $this->email;
        //$default = "https://www.somewhere.com/homestar.jpg";
        $size = 32;

        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;

    }

    public function favorites(){
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps();
    }


    public function voteQuestions(){
        return $this->morphedByMany(Question::class, 'votable');
    }

    public function voteAnswers(){
        return $this->morphedByMany(Answer::class, 'votable');
    }

    public function voteQuestion(Question $question, $vote){
        $voteQuestions = $this->voteQuestions();
        $this->_vote($voteQuestions, $question, $vote);
    }

    public function voteAnswer(Answer $answer, $vote){
        $voteAnswers = $this->voteAnswers();
        $this->_vote($voteAnswers, $answer, $vote);
    }

    private function _vote ($relationship, $model, $vote){

        if($relationship->where('votable_id', $model->id)->exists()){
            $relationship->updateExistingPivot($model, ['vote'=> $vote]);
        }else {
            $relationship->attach($model, ['vote' => $vote]);
        }

        $model->load('voted');
        $downVotes = (int) $model->votedDown()->sum('vote');
        $upVotes = (int) $model->votedUp()->sum('vote');
        if(get_class($model) === 'App\Answer'){
            $model->votes_count = $upVotes + $downVotes;
        } elseif (get_class($model) === 'App\Question'){
            $model->votes = $upVotes + $downVotes;
        }
        $model->save();
    }

}
