<?php

class ApiClass {

    function getRepos() {
        $token = '4699bb1bf51f393a23ad126bfffbf535101db38a';
        $curl_token_auth = 'Authorization: token ' . $token;


        $curl_url = 'https://api.github.com/search/repositories?q=' . urlencode($_GET['repo']) . '&per_page=10';
        $ch = curl_init($curl_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: charnej', $curl_token_auth));
        $output = curl_exec($ch);

        curl_close($ch);
        $search_array = json_decode($output, TRUE);

        return $search_array;
    }

    function getLatestTag($fullname) {

        $token = '4699bb1bf51f393a23ad126bfffbf535101db38a';
        $curl_token_auth = 'Authorization: token ' . $token;

        $latest_tag_url = 'https://api.github.com/repos/' . $fullname . '/releases/latest';
        $ch1 = curl_init($latest_tag_url);
        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch1, CURLOPT_HTTPHEADER, array('User-Agent: charnej', $curl_token_auth));
        $output1 = curl_exec($ch1);
        curl_close($ch1);
        $tag_array = json_decode($output1, TRUE);
        return $tag_array;
    }

}
