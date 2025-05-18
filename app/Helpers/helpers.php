<?php

if (!function_exists('getScoreColor')) {
    function getScoreColor($score) {
        if ($score >= 85) return 'success';
        if ($score >= 70) return 'primary';
        if ($score >= 50) return 'warning';
        return 'danger';
    }
} 