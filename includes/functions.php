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
