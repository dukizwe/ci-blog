<?= $this->extend('layouts/default') ?>
<?= $this->section('head') ?>
          <title>Edit post | <?= $post->title ?></title>
<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
          <h4 class="container py-5 d-flex justify-content-center">Edit post: <small class="text-muted"><?= $post->title ?></small></h4>
          <?= $this->include('components/postForm', compact('post'))?>
<?= $this->endSection('content') ?>