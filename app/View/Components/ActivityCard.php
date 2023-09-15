<?php

namespace App\View\Components;

use App\Models\Activity;
use Illuminate\Support\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


class ActivityCard extends Component
{
    public $activity;
    public $name = "UNNAMED ACTIVITY";
    public $fasilitatorName = "UNNAMED FASILITATOR";
    public $fasilitatorImage = "fasilitator_placeholder.png";
    public $startTime = "00:00";
    public $endTime = "24:00";
    public $likeAmount = 0;
    public $activityDate;
    public $image_src = "activity_placeholder.png";


    public function __construct(Activity $activity)
    {
        $this->activity = $activity;
        $this->name = $activity->name;
        $this->startTime = $activity->startTime;
        $this->endTime = $activity->endTime;
        $this->image_src = $activity->picture;

        if ($activity->fasilitator) {
            $this->fasilitatorName = $activity->fasilitator->name;
            $this->fasilitatorImage = $activity->fasilitator->picture;
        }

        if ($activity->date) {
            $this->activityDate = Carbon::parse($activity->date)->format('j F Y');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.activity-card');
    }
}
