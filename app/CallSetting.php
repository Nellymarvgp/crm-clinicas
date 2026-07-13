<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CallSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agent_name',
        'agent_id',
        'call_url',
        'parameters',
        'is_active',
        'is_deleted',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'parameters' => 'array',
        'is_active' => 'boolean',
        'is_deleted' => 'boolean',
    ];

    /**
     * Get all active call settings.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getActive()
    {
        return self::where('is_active', true)
            ->where('is_deleted', false)
            ->get();
    }
}
