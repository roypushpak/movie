<?php

class Gemini {
    private $GEMINI_KEY;
    // Construct to input gemini key.
    public function __construct() {
      $this->GEMINI_KEY = $_ENV['GEMINI_KEY'];
    }
  // Generate a review using gemini and their provided code.
    public function generate_review($movie_title, $rating) {
      $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=" . $this->GEMINI_KEY;

      $data = array(
        "contents" => array(
          array(
            "role" => "user",
            "parts" => array(
              array(
                // Echo this prompt to the screen of our movie controller in that view.
                "text" => "Please give a review of {$movie_title} from someone who rated it a {$rating} out of 5."
              )
            )
          )
        )
      );
      // Curl for php.
      $json_data = json_encode($data);
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $response = curl_exec($ch);
      curl_close($ch);
      if(curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
      }

      $result = json_decode($response, true);
      return $result['candidates'][0]['content']['parts'][0]['text'] ?? "Error in review generation.";
    }

}
