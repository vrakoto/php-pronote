<?php

function nav_item(string $lien, string $titre): string
{
    $currentURL = $_SERVER['REQUEST_URI'];
    $active = "";
    if ($currentURL === $lien) {
        $active = " active";
    }
    return <<<HTML
    <li class="nav-item">
        <a href="$lien" class="nav-link $active">
            $titre
        </a>
    </li>
HTML;
}