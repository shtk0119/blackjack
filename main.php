<?php
  require_once('Card.php');

  echo "ブラックジャックを開始します。\n";

  $player = [];
  $dealer = [];

  // スペード、ハート、ダイヤ、クラブ
  // A = 1 or 11 点数が最大（良い方）となる方で数える
  // 2 ~ 10
  // J, Q, K = 10
  $cards = new Card();
  $player[] = $cards->drawCard();
  $dealer[] = $cards->drawCard();
  $player[] = $cards->drawCard();
  $dealer[] = $cards->drawCard();

  echo "あなたの引いたカードは". $player[0][0] ."の". $player[0][1] . "です。\n";
  echo "あなたの引いたカードは". $player[1][0] ."の". $player[1][1] . "です。\n";
  
  echo "ディーラーの引いたカードは". $dealer[0][0] ."の". $dealer[0][1] . "です。\n";
  echo "ディーラーの引いた2枚目のカードはわかりません。\n";

  $playerTotal = 0;
  for ($i=0; $i<count($player); $i++) {
    $playerTotal += $player[$i][1];
  }

  echo "あなたの現在の得点は". $playerTotal ."です。カードを引きますか？（Y/N）\n";
  fscanf(STDIN, "%s", $bool);
  
  while ($bool === "Y") {
    $card = $cards->drawCard();
    $player[] = $card;
    $playerTotal += $card[1];
    echo "あなたの引いたカードは". $card[0] ."の". $card[1] . "です。\n";
    echo "あなたの現在の得点は". $playerTotal ."です。カードを引きますか？（Y/N）\n";
    fscanf(STDIN, "%s", $bool);
  }

  $dealerTotal = 0;
  for ($i=0; $i<count($dealer); $i++) {
    $dealerTotal += $dealer[$i][1];
  }

  echo "ディーラーの引いた2枚目のカードは". $dealer[1][0] ."の". $dealer[1][1] ."でした。\n";
  echo "ディーラーの現在の得点は". $dealerTotal ."です。\n";

  while ($dealerTotal < 18) {
    $card = $cards->drawCard();
    $dealer[] = $card;
    $dealerTotal += $card[1];
    echo "ディーラーの引いたカードは". $card[0] ."の". $card[1] . "です。\n";
  }

  echo "あなたの得点は". $playerTotal ."です。\n";
  echo "ディーラーの得点は". $dealerTotal ."です。\n";

  if ($playerTotal < 22) {
    if ($dealerTotal < 22) {
      if ($playerTotal > $dealerTotal) {
        echo "あなたの勝ちです！\n";
      } elseif ($playerTotal == $dealerTotal) {
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
