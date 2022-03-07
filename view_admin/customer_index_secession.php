<div class="mb-2">
  氏名をクリックすると、「再入会」処理を実行します
</div>
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link h5" style="color:black" aria-current="page" href="customer_index.php">会員</a>
  </li>
  <li class="nav-item">
    <a class="nav-link bg-dark text-white h5" href="customer_index.php?secession_members" style="color:black">退会済み</a>
  </li>
</ul>
<table class="table table-borderless m-0">
  <thead>
    <tr class="row h5 py-3 mx-0 mb-0 bg-dark text-white">
      <th class="col-sm-2">&emsp;氏名
        <small class="h6"> (退会日)</small>
      </th>
      <th class="col-sm-3">&emsp;メールアドレス</th>
      <th class="col-sm-5">&emsp;住所</th>
      <th class="col-sm-2">&emsp;電話番号</th>
    </tr>
  </thead>
</table>

<table class="table table-borderless">
  <?php $i = 0;
  foreach ($customers as $customer) {
    $i++ ?>
    <tbody>
      <tr>
        <td rowspan="2" class="border-bottom align-middle ps-0 pe-1">
          <h5 class="text-muted">
            <?= $i ?>
          </h5>
        </td>
      </tr>
      <tr class="row d-flex align-items-center py-3 m-0 border-bottom table table-hover">
        <td class="col-md-2">
          <div class="row h5 mb-1">
            <a href="customer_index.php?secession_member_id=<?= $customer["id"] ?>" class="rejoin_btn p-0" style="text-decoration:none">
              <div class="text-dark ps-3">
                <?= $customer['name_last'] . '&nbsp;' . $customer['name_first'] ?>
              </div>
          </div>
          <div class="row text-end me-3">
            <small class="text-muted">
              <?= date('Y-m-d', strtotime($customer['updated_at'])) ?>
            </small>
            </a>
          </div>
        </td>
        <td class="col-md-3 ps-3 ~~~" style="word-wrap:break-word;">
          <?= $customer['email'] ?>
        </td>
        <td class="col-md-5 ps-3 ~~~" style="word-wrap:break-word;">
          <div class="mb-1">
            <?= '〒' . substr_replace($customer['postal_code'], '-', 3, 0) . '<br>' ?>
          </div>
          <?= $customer['address'] . '<br>' . $customer['house_num'] ?>
        </td>
        <td class="col-md-2 ps-3">
          <?= $customer['telephone_num'] ?>
        </td>
      </tr>
    </tbody>
  <?php } ?>
</table>

<!-- 以下ページング -->
<div class="row d-flex align-items-center justify-content-center mt-3 mb-5">
  <div class="col-sm-10 d-flex align-items-center justify-content-center">
    <nav aria-label="Page navigation example">
      <ul class='pagination'>
        <?php if ($page == 1) { ?>
          <!-- 現在のページが1の場合disabledに -->
          <li class="page-item disabled">
            <a class="page-link" href="?secession_members&page=<?= 1 ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
        <?php } else { ?>
          <!-- 現在のページが1でなければ有効 -->
          <li class="page-item">
            <a class="page-link" href="?secession_members&page=<?= 1 ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <?php }
        for ($x = 1; $x <= $pagination; $x++) {
          // 現在のページの場合、disabledに
          if ($x == $page) { ?>
            <li class='page-item disabled'>
              <a class="page-link" href="?secession_members&page=<?= $x ?>">
                <?= $x; ?>
              </a>
            </li>
          <?php
            // 現在のページでなければ有効
          } else { ?>
            <li class='page-item'>
              <a class="page-link" href="?secession_members&page=<?= $x ?>">
                <?= $x; ?>
              </a>
            </li>
          <?php }
        }
        if ($pagination > $page) { ?>
          <!-- 最終ページでなければ有効 -->
          <li class="page-item">
            <a class="page-link" href="?secession_members&page=<?= ($page + 1) ?>" aria-label="Previous">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        <?php } else { ?>
          <!-- 最終ページの場合disabledに -->
          <li class="page-item disabled">
            <a class="page-link" href="?secession_members&page=<?= ($page + 1) ?>" aria-label="Previous">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        <?php } ?>
      </ul>
    </nav>
  </div>
</div>
</div>