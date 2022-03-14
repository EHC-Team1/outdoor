    <!-- 退会済みタブ選択時 -->
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link h5" style="color:black" aria-current="page" href="customer_index.php">会員</a>
      </li>
      <li class="nav-item">
        <a class="nav-link bg-dark text-white h5" href="customer_index.php?secession_members" style="color:black">退会済み</a>
      </li>
    </ul>
    <table class="table table-borderless mb-1">
      <thead class="bg-dark text-white">
        <tr>
          <th rowspan="3" class="align-middle col-sm-1 text-center"></th>
          <th rowspan="2" class="align-middle col-sm-4 text-center">
            <h5>氏名</h5>
          </th>
          <th class="col-sm-7 text-center">メールアドレス</th>
        </tr>
        <tr>
          <th class="col-sm-7 text-center">住所</th>
        </tr>
        <tr>
          <th class="col-sm-4 text-center" id="space">入会日</th>
          <th class="col-sm-7 text-center" id="space">電話番号</th>
        </tr>
      </thead>
    </table>
    </div>
    </div>
    </div>
    <div class="row d-flex justify-content-center mx-1">
      <div class="col-sm-12 p-0">
        <table class="table table-borderless m-0">
          <?php $i = 0;
          foreach ($customers as $customer) {
            $i++ ?>
            <tbody class="bg-dark text-white border-bottom">
              <tr>
                <td rowspan="3" class="align-middle col-sm-1 text-center">
                  <h5 class="text-white">
                    <?= $i ?>
                  </h5>
                </td>
                <td rowspan="2" class="align-middle col-sm-4 text-center">
                  <a href="customer_index.php?id=<?= $customer["id"] ?>" name="secession" class="secession_btn p-0" style="text-decoration:none">
                    <h5 class="text-white">
                      <?= $customer['name_last'] . '&nbsp;' . $customer['name_first'] ?>
                    </h5>
                  </a>
                </td>
                <td class="col-sm-7 text-center">
                  <?= $customer['email'] ?>
                </td>
              </tr>
              <tr>
                <td class="col-sm-7 text-center">
                  <?= '〒' . substr_replace($customer['postal_code'], '-', 3, 0) . '　' . $customer['address'] . $customer['house_num'] ?>
                </td>
              </tr>
              <tr>
                <td class="col-sm-4 text-center">
                  <?= date('Y-m-d', strtotime($customer['created_at'])) ?>
                </td>
                <td class="col-sm-7 text-center">
                  <?= $customer['telephone_num'] ?>
                </td>
              </tr>
            </tbody>
          <?php } ?>
        </table>
      </div>
    </div>

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