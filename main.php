<?php
  require_once('Card.php');
  require_once('Person.php');

  echo "ブラックジャックを開始します。\n";
  $cards = new Card();

  echo "プレイ人数を選択してください\n";
  echo "ひとりでプレイ:1 ふたりでプレイ:2 さんにんでプレイ:3\n";
  fscanf(STDIN, "%d", $people);
  while (1 > $people || $people > 3) {
    echo "1人〜3人で選択してください。\n";
    fscanf(STDIN, "%d", $people);
  }

  $dealer = new Person;
  $you = new Person;

  for ($i=1; $i<=$people-1; $i++) {
    ${"cpu".$i} = new Person;
  }

  for ($i=0; $i<2; $i++) {
    $you->setCards($cards->drawCard());

    for ($k=1; $k<=$people-1; $k++) {
      ${"cpu".$k}->setCards($cards->drawCard());
    }

    $dealer->setCards($cards->drawCard());
  }

  for ($i=1; $i<=$people-1; $i++) {
    echo "CPU{$i}の引いたカードは". ${"cpu".$i}->getCards()[0][0] ."の". ${"cpu".$i}->getCards()[0][1] . "です。\n";
    echo "CPU{$i}の引いたカードは". ${"cpu".$i}->getCards()[1][0] ."の". ${"cpu".$i}->getCards()[1][1] . "です。\n";
  }

  echo "あなたの引いたカードは". $you->getCards()[0][0] ."の". $you->getCards()[0][1] . "です。\n";
  echo "あなたの引いたカードは". $you->getCards()[1][0] ."の". $you->getCards()[1][1] . "です。\n";

  echo "ディーラーの引いたカードは". $dealer->getCards()[0][0] ."の". $dealer->getCards()[0][1] . "です。\n";
  echo "ディーラーの引いた2枚目のカードはわかりません。\n";

  echo "あなたの現在の得点は". $you->getTotal() ."です。カードを引きますか？（Y/N）\n";
  fscanf(STDIN, "%s", $bool);
  
  while ($bool === "Y") {
    $card = $cards->drawCard();
    $you->setCards($card);
    echo "あなたの引いたカードは". $card[0] ."の". $card[1] . "です。\n";
    echo "あなたの現在の得点は". $you->getTotal() ."です。カードを引きますか？（Y/N）\n";
    fscanf(STDIN, "%s", $bool);
  }

  for ($i=1; $i<=$people-1; $i++) {
    while (${"cpu".$i}->getTotal() < 17) {
      $card = $cards->drawCard();
      ${"cpu".$i}->setCards($card);
      echo "CPU{$i}の引いたカードは". $card[0] ."の". $card[1] . "です。\n";
    }
  }

  echo "ディーラーの引いた2枚目のカードは". $dealer->getCards()[1][0] ."の". $dealer->getCards()[1][1] ."でした。\n";
  echo "ディーラーの現在の得点は". $dealer->getTotal() ."です。\n";

  while ($dealer->getTotal() < 17) {
    $card = $cards->drawCard();
    $dealer->setCards($card);
    echo "ディーラーの引いたカードは". $card[0] ."の". $card[1] . "です。\n";
  }

  echo "あなたの得点は". $you->getTotal() ."です。\n";
  for ($i=1; $i<=$people-1; $i++) {
    echo "CPU{$i}の得点は". ${"cpu".$i}->getTotal() ."です。\n";
  }
  echo "ディーラーの得点は". $dealer->getTotal() ."です。\n";

  if ($you->getTotal() < 22) {
    if ($dealer->getTotal() < 22) {
      if ($you->getTotal() > $dealer->getTotal()) {
        echo "あなたは勝ちです！\n";
      } elseif ($you->getTotal() == $dealer->getTotal()) {
        echo "引き分けです。";
      } else {
        echo "あなたは負けです。\n";
      }
    } else {
      echo "あなたは勝ちです!\n";
    }
  } else {
    echo "あなたは負けです。\n";
  }

  for ($i=1; $i<=$people-1; $i++) {
    if (${"cpu".$i}->getTotal() < 22) {
      if ($dealer->getTotal() < 22) {
        if (${"cpu".$i}->getTotal() > $dealer->getTotal()) {
          echo "CPU{$i}は勝ちです！\n";
        } elseif (${"cpu".$i}->getTotal() == $dealer->getTotal()) {
          echo "引き分けです。";
        } else {
          echo "CPU{$i}は負けです。\n";
        }
      } else {
        echo "CPU{$i}は勝ちです!\n";
      }
    } else {
      echo "CPU{$i}は負けです。\n";
    }
  }

  echo "ブラックジャックを終了します。\n";
?>
