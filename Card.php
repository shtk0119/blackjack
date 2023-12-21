<?php
  class Card {
    private $cards;

    public function __construct() {
      $numbers = ["A", "2", "3", "4", "5", "6", "7", "8", "9", "10", "J", "Q", "K"];
      $this->cards = ["スペード" => $numbers, "ハート" => $numbers, "ダイヤ" => $numbers, "クラブ" => $numbers];
    }

    public function getCards() {
      return $this->cards;
    }

    public function drawCard() {
      $mark = array_rand($this->cards);
      $number = array_splice($this->cards[$mark], array_rand($this->cards[$mark]), 1)[0];
      return [$mark, $number];
    }
  }
?>
