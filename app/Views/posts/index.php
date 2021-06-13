<?= $this->extend('layouts/default') ?>
<?= $this->section('head') ?>
          <meta name="author" content="mbagapro@gmail.com">
          <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">
          <title>CI Blog | All posts</title>
          <link href="/assets/css/posts.css" rel="stylesheet">
<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
          <?= $this->include('components/posts', compact('posts')) ?>
<?= $this->endSection('content') ?>