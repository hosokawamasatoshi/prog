
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script type="text/javascript" src="//webfonts.sakura.ne.jp/js/sakurav3.js"></script>
  <link rel="stylesheet" href="kadai06.css">
  <title>テニスイキタイ</title>
</head>
<body>
<form method="POST" action="insert_activity.php" enctype="multipart/form-data">
  <div id="act_input">
    <div class="act_wrap">
      <div class="flex_wrap">
        <div><input id="act_date" type="date" name="indate"></div>
        <div class="radio_wrap">
          <label><input type="radio" name="category" value="練習">練習</label>
          <label><input type="radio" name="category" value="試合">試合</label>
          <label><input type="radio" name="category" value="その他">その他</label>
        </div>
      </div>
    </div>
    <div id="act_container">
      <textarea rows="10" name="act"></textarea>
      <input id="file_upload" type="file" name="image" accept="image/*">
      <div class="act_btn_wrap"><input id="activity_btn" type="submit" value="送信"></div>
    </div>
  </div>
</form>
</body>
</html>