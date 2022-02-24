<div class="row d-flex align-items-center justify-content-center mt-3 mb-5">
  <div class="col-sm-10 d-flex align-items-center justify-content-center">
    <nav aria-label="Page navigation example">
      <ul class='pagination'>
        <?php if ($page == 1) { ?>
          <!-- 現在のページが1の場合disabledに -->
          <li class="page-item disabled">
            <a class="page-link" href="?page=<?= 1 ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
        <?php } else { ?>
          <!-- 現在のページが1でなければ有効 -->
          <li class="page-item">
            <a class="page-link" href="?page=<?= 1 ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
        <?php }
        for ($x = 1; $x <= $pagination; $x++) { ?>
          <li class='page-item'>
            <a class="page-link" href="?page=<?= $x ?>">
              <?= $x; ?>
            </a>
          </li>
        <?php }
        if ($pagination > $page) { ?>
          <!-- 最終ページでなければ有効 -->
          <li class="page-item">
            <a class="page-link" href="?page=<?= ($page + 1) ?>" aria-label="Previous">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        <?php } else { ?>
          <!-- 最終ページの場合disabledに -->
          <li class="page-item disabled">
            <a class="page-link" href="?page=<?= ($page + 1) ?>" aria-label="Previous">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        <?php } ?>
      </ul>
    </nav>
  </div>
</div>