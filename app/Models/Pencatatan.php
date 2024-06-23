<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pencatatan extends Model
{
    use HasFactory;
    protected $table = 'pencatatans';
    protected $fillable = ['cutoff_date','invoice','due_date','trans_date','p_piutang','prediction'];
}
