<?php
$pageTitle = $pageTitle ?? 'Dashboard';
$breadcrumbs = $breadcrumbs ?? [
    ['label' => 'Home', 'url' => 'index.php'],
    ['label' => $pageTitle, 'url' => null],
];
?>

<div class="pagetitle">
  <h1><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></h1>
  <nav>
    <ol class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb): ?>
        <?php if (!empty($breadcrumb['url'])): ?>
          <li class="breadcrumb-item">
            <a href="<?= htmlspecialchars($breadcrumb['url'], ENT_QUOTES, 'UTF-8') ?>">
              <?= htmlspecialchars($breadcrumb['label'], ENT_QUOTES, 'UTF-8') ?>
            </a>
          </li>
        <?php else: ?>
          <li class="breadcrumb-item active">
            <?= htmlspecialchars($breadcrumb['label'], ENT_QUOTES, 'UTF-8') ?>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ol>
  </nav>
</div>
