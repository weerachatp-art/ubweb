<?php
/**
 * Visitor Counter Script
 * สาขาวิชาพระพุทธศาสนา มจร วิทยาเขตอุบลราชธานี
 */

function get_visitor_count(): int {
    $is_vercel = !empty($_ENV['VERCEL']) || !empty($_SERVER['VERCEL']);
    $counter_file = $is_vercel ? sys_get_temp_dir() . '/counter.txt' : __DIR__ . '/counter.txt';

    if (!file_exists($counter_file)) {
        if ($is_vercel && file_exists(__DIR__ . '/counter.txt')) {
            @copy(__DIR__ . '/counter.txt', $counter_file);
        } else {
            @file_put_contents($counter_file, '1250');
        }
    }

    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        @session_start();
    }

    $count = (int) (@file_get_contents($counter_file) ?: 1250);

    // Count once per session
    if (empty($_SESSION['ubweb_visited'])) {
        $_SESSION['ubweb_visited'] = true;
        $count++;
        
        @file_put_contents($counter_file, (string) $count, LOCK_EX);
    }

    return $count;
}
