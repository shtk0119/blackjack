<?php
  class Person {
    private $cards = [];

    public function getCards() {
      return $this->cards;
    }

    public function setCards($card) {
      $this->cards[] = $card;
    }

    public function getTotal() {
      $total = 0;

      for ($i=0; $i<count($this->cards); $i++) {
        if ($this->cards[$i][1] === "A") {
          if (($total + 11) < 22) {
            $total += 11;
          } else {
            $total += 1;
          }
        } elseif ($this->cards[$i][1] === "J" || $this->cards[$i][1] === "Q" || $this->cards[$i][1] === "K") {
          $total += 10;
        } else {
          $total += $this->cards[$i][1];
        }
      }

      return $total;
    }
  }
?>
