<?php
function redirect_to(string $pageLocation, bool $relativeToIndex = true)
{
    header("Location: " . ($relativeToIndex ? "/hellow/$pageLocation" : "$pageLocation"));
}
function redirect_main_page()
{
    redirect_to("");
}
