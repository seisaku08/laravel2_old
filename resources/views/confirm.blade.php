<!doctype html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>入力確認画面</title>

	<link href="sendstyle.css" rel="stylesheet" type="text/css">

</head>

<body>
  <h1>送信内容確認画面</h1>
            <form method="post" action="./finish.php">
  <table id="form">
      <tr class="midashi">
          <th colspan="5">ご担当者様情報</th>
      </tr>
      <tr>
          <td class="left">ご担当者氏名</td>
          <td class="right-half"></td>
          <td class="left">所属部署</td>
          <td class="right-half"><input type="hidden" name="user_busho" placeholder="" value=""></td>
      </tr>
      <tr>
          <td class="left">メールアドレス</td>
          <td class="right-half"><input type="hidden" name="user_email" placeholder="" value="">
          </td>
          <td class="left">電話番号</td>
          <td class="right-half"><input type="hidden" name="user_tel" placeholder="" value="">
          </td>
      </tr>
      <tr class="midashi">
          <th colspan="5">配送先情報</th>
      </tr>
       <tr>
         <td class="left">セミナー開催日</td>
          <td class="right-half"><input type="hidden" name="seminar_day" placeholder="" value="">
          </td>
      </tr>
       <tr>
          <td class="left">セミナー名</td>
          <td class="right-half"><input type="hidden" name="seminar_name" placeholder="" value="">
          </td>
       </tr>
      <tr>
          <td class="left"><label>郵便番号</label></td>
          <td class="right-half"><input type="hidden" name="zip01" id="zip" maxlength="8" placeholder="例）1010047" >
          </td>
      </tr>
      <tr>
          <td class="left"><label>住所</label></td>
          <td class="right-half"><input type="hidden" name="addr11" placeholder="例）東京都千代田区内神田1-7-5">
          </td>
          <td class="left"><label>ビル名</label></td>
          <td class="right-half"><input type="hidden" name="addr12" placeholder="例）旭栄ビル 2階">
          </td>
      </tr>
      <tr>
          <td class="left"><label>施設名</label></td>
          <td class="right-half"><input type="hidden" name="addr13" placeholder="例）株式会社 大應">
          </td>
          <td class="left"><label>部署名</label></td>
          <td class="right-half"><input type="hidden" name="addr14" placeholder="例）●●部">
          </td>
      </tr>
      <tr>
          <td class="left"><label>配送先担当者</label></td>
          <td class="right-half"><input type="hidden" name="addr_name" placeholder="">
          </td>
      </tr>
      <tr>
          <td class="left">配達先電話番号</td>
          <td class="right-half"><input type="hidden" name="addr_tel" placeholder="例）0332921488 / 03-3292-1488" value=""  >
          </td>
      </tr>
     <tr>
          <td class="left">到着希望日時</td>
          <td class="right-half"><input type="hidden" name="arrival_date" placeholder="" value="">
              <input type="hidden" name="arrival_time" placeholder="" value="">
          </td>
          <td class="left">返送予定日</td>
          <td class="right-half"><input type="hidden" name="return_date" placeholder="" value="">
          </td>
      </tr>
    </table>
    <table id="kizai">
        <tr class="midashi">
          <th colspan="5">選択機材情報</th>
      </tr>
      <tr>
          <td class="kizai-left">機材番号</td>
          <td class="kizai-right">機種</td>
      </tr>
      <tr>
          <input type="hidden" name="id[]" value="">
          <td class="kizai-left"></td>
          <td class="kizai-right"></td>
      </tr>
  </table>
      <p>
          <button type="button" onclick="history.back();">戻る</button>
          <input type="submit" value="上記の内容で送信する">
      </p>
      </form>

</body>
</html>
