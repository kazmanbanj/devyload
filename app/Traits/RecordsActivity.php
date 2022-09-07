<?php

namespace App\Traits;

use ReflectionClass;
use App\Models\Activity;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) return;
        
        foreach (static::getRecordsEvent() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected static function getRecordsEvent()
    {
        return ['created'];
    }

    public function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $event . '_' . strtolower((new ReflectionClass($this))->getShortName()),
            // 'subject_id' => $this->id,
            // 'subject_type' => get_class($this),
        ]);
    }
}