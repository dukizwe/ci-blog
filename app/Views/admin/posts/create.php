<?= $this->extend('layouts/default') ?>
<?= $this->section('head') ?>
          <title>Creating new post</title>
<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
          <h1 class="container py-5 d-flex justify-content-center">Create new post</h1>
          <?= $this->include('components/postForm') ?>
<?= $this->endSection('content') ?>