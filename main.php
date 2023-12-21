<?php
  require_once('Card.php');
  require_once('Person.php');

  echo "ブラックジャックを開始します。\n";

  $player = new Person;
  $dealer = new Person;

  $cards = new Card();
  $player->setCards($cards->drawCard());
  $dealer->setCards($cards->drawCard());
  $player->setCards($cards->drawCard());
  $dealer->setCards($cards->drawCard());

  echo "あなたの引いたカードは". $player->getCards()[0][0] ."の". $player->getCards()[0][1] . "です。\n";
  echo "あなたの引いたカードは". $player->getCards()[1][0] ."の". $player->getCards()[1][1] . "です。\n";
  
  echo "ディーラーの引いたカードは". $dealer->getCards()[0][0] ."の". $dealer->getCards()[0][1] . "です。\n";
  echo "ディーラーの引いた2枚目のカードはわかりません。\n";

  echo "あなたの現在の得点は". $player->getTotal() ."です。カードを引きますか？（Y/N）\n";
  fscanf(STDIN, "%s", $bool);
  
  while ($bool === "Y") {
    $card = $cards->drawCard();
    $player->setCards($card);
    echo "あなたの引いたカードは". $card[0] ."の". $card[1] . "です。\n";
    echo "あなたの現在の得点は". $player->getTotal() ."です。カードを引きますか？（Y/N）\n";
    fscanf(STDIN, "%s", $bool);
  }

  echo "ディーラーの引いた2枚目のカードは". $dealer->getCards()[1][0] ."の". $dealer->getCards()[1][1] ."でした。\n";
  echo "ディーラーの現在の得点は". $dealer->getTotal() ."です。\n";

  while ($dealer->getTotal() < 17) {
    $card = $cards->drawCard();
    $dealer->setCards($card);
    echo "ディーラーの引いたカードは". $card[0] ."の". $card[1] . "です。\n";
  }

  echo "あなたの得点は". $player->getTotal() ."です。\n";
  echo "ディーラーの得点は". $dealer->getTotal() ."です。\n";

  if ($player->getTotal() < 22) {
    if ($dealer->getTotal() < 22) {
      if ($player->getTotal() > $dealer->getTotal()) {
        echo "あなたの勝ちです！\n";
      } elseif ($player->getTotal() == $dealer->getTotal()) {
        echo "引き分けです。";
      } else {
        echo "あなたの負けです。\n";
      }
    } else {
      echo "あなたの勝ちです!\n";
    }
  } else {
    echo "あなたの負けです。\n";
  }

  echo "ブラックジャックを終了します。\n";
?>
