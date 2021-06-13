<?= $this->extend('layouts/default') ?>
<?= $this->section('head') ?>
          <title>Creating new Tag</title>
<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
          <h1 class="container py-5 d-flex justify-content-center">Create new Tag</h1>
          <?= $this->include('components/tagForm') ?>
<?= $this->endSection('content') ?>