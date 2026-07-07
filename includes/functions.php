<?php
function render_paragraphs($text)
{
    $blocks = preg_split('/\n\s*\n/', trim($text));
    $html = '';
    foreach ($blocks as $block) {
        $block = trim($block);
        if ($block === '') {
            continue;
        }
        $html .= '<p>' . nl2br(htmlspecialchars($block)) . '</p>';
    }
    return $html;
}

function reading_time($text)
{
    $words = str_word_count(strip_tags($text));
    $minutes = max(1, (int) ceil($words / 200));
    return $minutes . ' min read';
}
