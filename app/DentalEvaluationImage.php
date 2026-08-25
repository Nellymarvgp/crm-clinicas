<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DentalEvaluationImage extends Model
{
    protected $table = 'dental_evaluation_images';

    protected $fillable = [
        'dental_evaluation_id',
        'path',
        'original_name',
    ];

    public function evaluation()
    {
        return $this->belongsTo(DentalEvaluation::class, 'dental_evaluation_id');
    }
}
