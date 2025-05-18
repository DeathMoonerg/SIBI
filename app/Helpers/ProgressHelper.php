<?php

namespace App\Helpers;

class ProgressHelper
{
    public static function getScoreColor($score)
    {
        if ($score >= 90) {
            return 'success';
        } elseif ($score >= 80) {
            return 'primary';
        } elseif ($score >= 70) {
            return 'warning';
        } else {
            return 'danger';
        }
    }
    
    /**
     * Get hex color based on score
     * 
     * @param int $score
     * @return string
     */
    public static function getScoreColorHex($score)
    {
        if ($score >= 90) {
            return '#28a745'; // success
        } elseif ($score >= 80) {
            return '#0d6efd'; // primary
        } elseif ($score >= 70) {
            return '#ffc107'; // warning
        } else {
            return '#dc3545'; // danger
        }
    }
} 
 
 
 