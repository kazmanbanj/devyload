<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Support\Str;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (self::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
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
            'type' => $this->getActivityType($event),
        ]);
    }

    /**
     * @throws \ReflectionException
     */
    protected function getActivityType($event): string
    {
        $type = Str::lower(class_basename($this));

        return "{$event}_{$type}";
    }
}
