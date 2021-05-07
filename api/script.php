<?php

function getPosts()
{
    $ch = curl_init();
    $url = 'https://jsonplaceholder.typicode.com/posts';

    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true
    ]);

    $posts = curl_exec($ch);
    curl_close($ch);
    return json_decode($posts, true);
}

function getComments()
{
    $ch = curl_init();
    $url = 'https://jsonplaceholder.typicode.com/comments';

    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true
    ]);

    $comments = curl_exec($ch);
    curl_close($ch);
    return json_decode($comments, true);
}
