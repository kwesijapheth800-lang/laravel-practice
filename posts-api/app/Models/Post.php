<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Add this line to explicitly allow mass assignment for these columns
    protected $fillable = ['title', 'content'];
}