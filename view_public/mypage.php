<?php
// セッションを宣言
session_start();




?>



<?php require_once '../view_common/header.php'; ?>

<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    <h1 class="text-center mt-5 mb-5">お客様情報</h1>
    <form action="customer_edit.php" method="POST">
      <input type="submit" name="" class="btn btn-success btn-lg text-right" value="編集">
    </form>
    <div class="col-md-10">
      <div class="card">
        <div class="card-body col-md-12">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <th scope="row" class="col-md-4 text-right">氏名</th>
                <td class="col-md-8"><? ?>山田太郎(仮)</td>
              </tr>
              <tr>
                <th scope="row" class="col-md-4 text-right">メールアドレス</th>
                <td class="col-md-8"><? ?></td>
              </tr>
              <tr>
                <th scope="row" class="col-md-4 text-right">郵便番号</th>
                <td class="col-md-8"><? ?></td>
              </tr>
              <tr>
                <th scope="row" class="col-md-4 text-right">住所</th>
                <td class="col-md-8"><? ?></td>
              </tr>
              <tr>
                <th scope="row" class="col-md-4 text-right">電話番号</th>
                <td class="col-md-8"><? ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <h1 class="text-center mt-5 mb-5">配送先一覧</h1>
    <form action="delivery_input.php" method="POST">
      <input type="submit" name="" class="btn btn-primary btn-lg text-right" value="配送先追加">
    </form>
    <div class="col-md-10">
      <!-- 配送先を繰り返しで表示 -->
      <div class="card">
        <div class="card-body">
        </div>
      </div>
    </div>

  </div>
</div>


<?php require_once '../view_common/footer.php'; ?>