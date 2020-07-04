<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    protected $fillable = ['title', 'body'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    //mutator, will populate title and then slug column with slugged title
    public function setTitleAttribute($value){
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    //accesor, will give $this->url
    public function getUrlAttribute(){
        return route("questions.show", $this->id);
    }

    //accesor, will give $this->created_date
    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }
}
