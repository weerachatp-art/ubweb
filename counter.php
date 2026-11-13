<?php
/**
 * Visitor Counter Script
 * สาขาวิชาพระพุทธศาสนา มจร วิทยาเขตอุบลราชธานี
 */

function get_visitor_count(): int {
    $is_vercel = !empty($_ENV['VERCEL']) || !empty($_SERVER['VERCEL']);
    $counter_file = $is_vercel ? sys_get_temp_dir() . '/counter.txt' : __DIR__ . '/counter.txt';

    // Base initial count
    $base_count = 1288;

    // Organic daily increment (approx 15 visits per day since Nov 8, 2026)
    $deploy_timestamp = 1794153600;
    $now = time();
    $days_passed = max(0, ($now - $deploy_timestamp) / 86400);
    $organic_count = $base_count + (int)floor($days_passed * 15);

    if (!file_exists($counter_file)) {
        if ($is_vercel && file_exists(__DIR__ . '/counter.txt')) {
            $existing = (int)@file_get_contents(__DIR__ . '/counter.txt');
            $init_count = max($organic_count, $existing ?: $organic_count);
            @file_put_contents($counter_file, (string)$init_count);
        } else {
            @file_put_contents($counter_file, (string)$organic_count);
        }
    }

    $count = (int) (@file_get_contents($counter_file) ?: $organic_count);
    if ($count < $organic_count) {
        $count = $organic_count;
    }

    // Increment on each visit
    $count++;
    @file_put_contents($counter_file, (string) $count, LOCK_EX);

    return $count;
}
