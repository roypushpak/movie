<?php

class Omdb {
    private $omdb_key;
// Constructer for omdb key.
    public function __construct() {
        $this->omdb_key = $_ENV['omdb_key'];
    }
// Search movie by title, query omdb with api key and return the movie's information.
    public function search_movie($title) {
      $query_url = "http://www.omdbapi.com/?apikey=". $this->omdb_key ."&t=" . urlencode($title);
      $response = file_get_contents($query_url);
      return json_decode($response, true);
    }

}
