<?php
namespace App\View\Helper;

use Cake\View\Helper;

class AnimesHelper extends Helper
{
    public function getReviewAverage($reviews)
    {
        $evalution = [];
        $avg_stars = '';

        if (!empty($reviews)) {

            foreach($reviews as $review) {
                $evalution[] = $review->evalution;
            }

            $sum = array_sum($evalution);
            $cnt = count($evalution);
            $avg_evalution = round($sum / $cnt);

            for ($i=0; $i < $avg_evalution; $i++) {
                $avg_stars .= '☆';
            }
        }

        return $avg_stars;
    }
}