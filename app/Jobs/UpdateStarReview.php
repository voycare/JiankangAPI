<?php


namespace App\Jobs;


use App\Models\SummaryReview;
use App\User;

class UpdateStarReview extends Job
{
    protected $clinicId;
    protected $star;

    public function __construct($clinicId, $star)
    {
        $this->clinicId = $clinicId;
        $this->star = $star;
    }

    public function handle()
    {
        $summary = SummaryReview::where('clinic_id', $this->clinicId)->first();
        $rate = $this->star;
        if ($summary) {
            $rate = ((5 * $summary->star_5) + (4 * $summary->star_4) + (3 * $summary->star_3) + (2 * $summary->star_2) + $summary->star_1 + $this->star) / ($summary->star_5 + $summary->star_4 + $summary->star_3 + $summary->star_2 + $summary->star_1 + 1);
            switch ($this->star) {
                case 1:
                    $summary->star_1 = $summary->star_1 + 1;
                    break;
                case 2:
                    $summary->star_2 = $summary->star_2 + 1;
                    break;
                case 3:
                    $summary->star_3 = $summary->star_3 + 1;
                    break;
                case 4:
                    $summary->star_4 = $summary->star_4 + 1;
                    break;
                case 5:
                    $summary->star_5 = $summary->star_5 + 1;
                    break;
            }
            $summary->star = $rate;
            $summary->save();
        } else {

            $star_5 = 0;
            $star_4 = 0;
            $star_3 = 0;
            $star_2 = 0;
            $star_1 = 0;
            switch ($this->star) {
                case 1:
                    $star_1 = 1;
                    break;
                case 2:
                    $star_2 = 1;
                    break;
                case 3:
                    $star_3 = 1;
                    break;
                case 4:
                    $star_4 = 1;
                    break;
                case 5:
                    $star_5 = 1;
                    break;
            }
            SummaryReview::create([
                'clinic_id' => $this->clinicId,
                'star' => $this->star,
                'star_5' => $star_5,
                'star_4' => $star_4,
                'star_3' => $star_3,
                'star_2' => $star_2,
                'star_1' => $star_1
            ]);
        }
        $clinic = User::find($this->clinicId);
        $clinic->rate = $rate;
        $clinic->save();
    }
}
