        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link h5" style="color:black" aria-current="page" href="customer_index.php">会員</a>
          </li>
          <li class="nav-item">
            <a class="nav-link bg-dark text-white h5" href="customer_index.php?secession_members" style="color:black">退会済み</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled">&emsp;名前をクリックすると、「再入会」処理を実行します</a>
          </li>
        </ul>
        <div class="card-body pt-0 px-0">
          <div class="row h5 py-4 mx-0 bg-dark text-white">
            <div class="d-flex align-items-center">
              <div class="col-md-2">
                &nbsp;名前
                <small class="h6">(退会日)</small>
              </div>
              <div class="col-md-3">
                &nbsp;メールアドレス
              </div>
              <div class="col-md-5">
                &nbsp;住所
              </div>
              <div class="col-md-2">
                &nbsp;電話番号
              </div>
            </div>
          </div>
          <?php foreach ($customers as $customer) { ?>
            <!-- <div class="table table-bordered table-striped table-hover">  ホバーで色変える、隔行で色変えたい-->
            <tbody>
              <div class="row d-flex align-items-center px-4 py-3 border-bottom">
                <div class="col-md-2">
                  <!-- 出来たらアラートに苗字だけ表示したい -->
                  <!-- <a href="#?id=<?= $customer["id"], $customer["name_last"] ?>" name="secession" class="secession_btn" style="text-decoration:none"> -->
                  <div class="row mb-2 h5">
                    <a href="customer_index.php?secession_member_id=<?= $customer["id"] ?>" class="rejoign_btn" style="text-decoration:none">
                      <div class="text-dark">
                        <?= $customer['name_last'] . '&nbsp;' . $customer['name_first'] ?>
                      </div>
                  </div>
                  </a>

                  <div class="row text-end me-1">
                    <small class="text-muted">
                      <?= date('Y-m-d', strtotime($customer['updated_at'])) ?>
                    </small>
                  </div>
                </div>
                <div class="col-md-3 ~~~" style="word-wrap:break-word;">
                  <?= $customer['email'] ?></p>
                </div>
                <div class="col-md-5 ~~~" style="word-wrap:break-word;">
                  <div class="mb-1">
                    <?= '〒' . substr_replace($customer['postal_code'], '-', 3, 0) . '<br>' ?>
                  </div>
                  <?= '&emsp;' . $customer['address'] . '<br>' . '&emsp;' . $customer['house_num'] ?>
                </div>
                <div class="col-md-2">
                  <?= $customer['telephone_num'] ?>
                </div>
              </div>
            </tbody>
          <?php } ?>
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
                        <a class="page-link" href="??secession_members&page=<?= $x ?>">
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
                      <a class="page-link" href="??secession_members&page=<?= ($page + 1) ?>" aria-label="Previous">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </nav>
            </div>
          </div>
        </div>