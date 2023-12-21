<?php
  require_once('Card.php');
  require_once('Person.php');
  
  // タイトルコール
  echo "--------------------------\n";
  echo "$ ブラックジャックゲーム $\n";
  echo "--------------------------\n";
  
  do {
    // 開始 / 終了
    echo "--------------------\n";
    echo "+ 選択してください +\n";
    echo "--------------------\n";
    echo "|     開始 : 1     |\n";
    echo "|     終了 : 2     |\n";
    echo "--------------------\n";
    fscanf(STDIN, "%d", $isContinue);
    
    if ($isContinue === 1) {
      // チップ
      do {
        echo "----------------------------\n";
        echo "+ チップ数をご入力ください +\n";
        echo "----------------------------\n";
        fscanf(STDIN, "%d", $chip);

        if (gettype($chip) !== "integer" || $chip < 1) {
          echo "----------------------------\n";
          echo "| 不正な値が入力されました |\n";
          echo "----------------------------\n";
        }
      } while (gettype($chip) !== "integer" || $chip < 1);
      echo "チップ : {$chip}枚\n";
      
      // 人数
      do {
        echo "---------------------------------------\n";
        echo "+ プレイ人数をご入力ください(最大3人) +\n";
        echo "---------------------------------------\n";
        fscanf(STDIN, "%d", $people);

        if (1 > $people || $people > 3) {
          echo "----------------------------\n";
          echo "| 不正な値が入力されました |\n";
          echo "----------------------------\n";
        }
      } while (1 > $people || $people > 3);
      echo "プレイ人数 : {$people}人\n";

      // ゲームスタート
      echo "------------------------\n";
      echo "+ ゲームを開始します +\n";
      echo "------------------------\n";

      // チップがなくなるか実行者が終了するまでループ
      do {
        // 賭け金（チップ）
        do {
          echo "------------------------------------\n";
          echo "+ 賭け金（チップ）をご入力ください +\n";
          echo "------------------------------------\n";
          echo "|       現在のチップ枚数 : $chip       |\n";
          echo "------------------------------------\n";
          fscanf(STDIN, "%d", $betChip);
  
          if (gettype($betChip) !== "integer" || $betChip < 1) {
            echo "----------------------------\n";
            echo "| 不正な値が入力されました |\n";
            echo "----------------------------\n";
          } elseif ($betChip > $chip) {
            echo "----------------------------------------------------\n";
            echo "| 賭け金（チップ）がお持ちのチップ枚数より多いです |\n";
            echo "----------------------------------------------------\n";
          }
        } while (gettype($betChip) !== "integer" || $betChip < 1 || $betChip > $chip);
        echo "賭け金（チップ） : {$betChip}枚\n";
        $chip -= $betChip;

        // カード
        $cards = new Card();
        // 実行者
        $player = new Person();
        // ディーラー
        $dealer = new Person();
        // CPU
        for ($i=1; $i<$people; $i++) {
          ${"cpu".$i} = new Person();
        }
        
        // カード配布
        for ($i=0; $i<2; $i++) {
          $player->setCards($cards->drawCard());
          echo "あなたの". $i+1 ."枚目のカードは". $player->getCards()[$i][0] . "の" . $player->getCards()[$i][1] ."です\n";
          for ($k=1; $k<$people; $k++) {
            ${"cpu".$k}->setCards($cards->drawCard());
            echo "CPU{$k}の". $i+1 ."枚目のカードは". ${"cpu".$k}->getCards()[$i][0] ."の". ${"cpu".$k}->getCards()[$i][1] ."です\n";
          }
          $dealer->setCards($cards->drawCard());
        }
        echo "ディーラーの1枚目のカードは". $dealer->getCards()[0][0] . "の" . $dealer->getCards()[0][1] ."です\n";
        echo "ディーラーの2枚目のカードはわかりません\n";

        // 実行者のターン
        do {
          for ($i=0; $i<count($player->getCards()); $i++) {
            echo "あなたの". $i+1 ."枚目のカードは". $player->getCards()[$i][0] . "の" . $player->getCards()[$i][1] ."です\n";
          }
          echo "あなたの現在の得点は". $player->getTotal() ."です\n";

          echo "-----------------------------------\n";
          echo "+         選択してください        +\n";
          echo "-----------------------------------\n";
          echo "|     カードを引く : 1            |\n";
          echo "| カードを引かない : 2            |\n";
          echo "|     ダブルダウン : 3            |\n";
          echo "|       スプリット : 4（選択不可）|\n";
          echo "|       サレンダー : 5            |\n";
          echo "-----------------------------------\n";
          fscanf(STDIN, "%d", $select);

          // 2 ~ 4を選択時 2回目以降では選択できない
          $isSelect = false;
          if ($select === 3 || $select === 4 || $select === 5) {
            if (count($player->getCards()) > 2) {
              $isSelect = true;
              echo "------------------------\n";
              echo "+ その選択はできません +\n";
              echo "------------------------\n";
            }
          }

          if ($select === 1) {
            $player->setCards($cards->drawCard());
            // ダブルダウン
          } elseif ($select === 3) {
            do {
              echo "--------------------------------------\n";
              echo "+ 賭け金（チップ）を入力してください +\n";
              echo "--------------------------------------\n";
              echo "|       手持ちのチップ枚数 : $chip       |\n";
              echo "|     現在の賭け金（チップ）: $betChip      |\n";
              echo "--------------------------------------\n";
              fscanf(STDIN, "%d", $doubleBetChip);
              if ($betChip < $doubleBetChip || gettype($betChip) !== "integer" || $doubleBetChip < 1 || $doubleBetChip > $chip) {
                echo "----------------------------\n";
                echo "| 不正な値が入力されました |\n";
                echo "----------------------------\n";
              } else {
                $betChip += $doubleBetChip;
              }
            } while ($betChip < $doubleBetChip || gettype($betChip) !== "integer" || $doubleBetChip < 1 || $doubleBetChip > $chip);
            $card = $cards->drawCard();
            $player->setCards($card);
            echo "あなたの引いたカードは". $card[0] ."の". $card[1] . "です。\n";
            break;
          // スプリット
          } elseif ($select === 4) {
            echo "未実装\n";
          // サレンダー 
          } elseif ($select === 5) {
            $chip += floor($betChip/2);
            break;
          }
        } while (1 > $select || $select > 5 || $isSelect || $select !== 2 || $select === 4);

        if ($select !== 5) {
          // CPU 操作
          for ($i=1; $i<$people; $i++) {
            while (${"cpu".$i}->getTotal() < 17) {
              $card = $cards->drawCard();
              ${"cpu".$i}->setCards($card);
              echo "CPU{$i}の引いたカードは". $card[0] ."の". $card[1] . "です。\n";
            }
          }
  
          // ディーラー 操作
          echo "ディーラーの引いた2枚目のカードは". $dealer->getCards()[1][0] ."の". $dealer->getCards()[1][1] ."でした。\n";
          echo "ディーラーの現在の得点は". $dealer->getTotal() ."です。\n";
  
          while ($dealer->getTotal() < 17) {
            $card = $cards->drawCard();
            $dealer->setCards($card);
            echo "ディーラーの引いたカードは". $card[0] ."の". $card[1] . "です。\n";
          }
  
          // 全ての得点
          echo "あなたの得点は". $player->getTotal() ."です。\n";
          for ($i=1; $i<$people; $i++) {
            echo "CPU{$i}の得点は". ${"cpu".$i}->getTotal() ."です。\n";
          }
          echo "ディーラーの得点は". $dealer->getTotal() ."です。\n";
  
          if ($player->getTotal() < 22) {
            if ($dealer->getTotal() < 22) {
              if ($player->getTotal() > $dealer->getTotal()) {
                $chip += $betChip*2;
                echo "あなたは勝ちです！\n";
              } elseif ($player->getTotal() == $dealer->getTotal()) {
                echo "引き分けです。\n";
              } else {
                echo "あなたは負けです。\n";
              }
            } else {
              $chip += $betChip*2;
              echo "あなたは勝ちです!\n";
            }
          } else {
            echo "あなたは負けです。\n";
          }
  
          for ($i=1; $i<$people; $i++) {
            if (${"cpu".$i}->getTotal() < 22) {
              if ($dealer->getTotal() < 22) {
                if (${"cpu".$i}->getTotal() > $dealer->getTotal()) {
                  echo "CPU{$i}は勝ちです！\n";
                } elseif (${"cpu".$i}->getTotal() == $dealer->getTotal()) {
                  echo "引き分けです。\n";
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
        }

        echo "-----------------------\n";
        echo "+ 続けますか？(Y / N) +\n";
        echo "-----------------------\n";
        fscanf(STDIN, "%s", $isEnd);
        if ($isEnd === "N") break; 

        // 初期化
        $betChip = null;
      } while ($chip > 0);

      if ($chip <= 0) {
        echo "-------------------\n";
        echo "+ G A M E O V E R +\n";
        echo "-------------------\n";
      }
    } elseif ($isContinue === 2) {
      break;
    } else {
      echo "----------------------------\n";
      echo "| 不正な値が入力されました |\n";
      echo "----------------------------\n";
    }
  } while ($isContinue === 1 || $isContinue !== 2);

  echo "--------------------------\n";
  echo "+   ゲームを終了します   +\n";
  echo "--------------------------\n";
?>
