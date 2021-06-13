<?= $this->extend('layouts/default') ?>
<?= $this->section('head') ?>
          <title>Edit tag | <?= $tag->name ?></title>
<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
          <h4 class="container py-5 d-flex justify-content-center">Edit tag: <small class="text-muted"><?= $tag->name ?></small></h4>
          <?= $this->include('components/tagForm', compact('tag'))?>
<?= $this->endSection('content') ?>