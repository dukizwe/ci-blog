<?= $this->extend('layouts/default') ?>
<?= $this->section('head') ?>
          <meta name="description" content="Some description from the blog">
          <meta name="author" content="mbagapro@gmail.com">
          <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">
          <title>Code Igniter blog</title>
          <link href="/assets/css/home.css" rel="stylesheet">
<?= $this->endSection('head') ?>

<?= $this->section('content') ?>
          <main role="main">

                    <section class="jumbotron text-center">
                              <div class="container">
                                        <h1 class="jumbotron-heading">CodeIgniter Blog</h1>
                                        <p class="lead text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt aliquam excepturi ullam hic quisquam. Odit vero ad placeat porro quaerat atque corrupti. Architecto repellendus nam, possimus eveniet magni eaque delectus?</p>
                                        <p>
                                                  <a href="<?= route_to('posts.root') ?>" class="btn btn-primary my-2">All posts</a>
                                                  <a href="<?= route_to('tags.root') ?>" class="btn btn-secondary my-2">Posts by tags</a>
                                        </p>
                              </div>
                    </section>
                    <?= $this->include('components/posts', compact('posts')) ?>

          </main>
<?= $this->endSection('content') ?>