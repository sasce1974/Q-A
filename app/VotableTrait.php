<?php
namespace App;

trait VotableTrait{
    public function voted(){
        return $this->morphToMany(User::class, 'votable');
    }

    public function votedUp(){
        return $this->voted()->wherePivot('vote', 1);
    }

    public function votedDown(){
        return $this->voted()->wherePivot('vote', -1);
    }
}
