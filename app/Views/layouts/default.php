<!doctype html>
<html lang="en">

<head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

          <!-- Bootstrap core CSS -->
          <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

          <!-- Custom styles for this template -->
          <link href="/assets/css/blog.css" rel="stylesheet">
          <?= $this->renderSection('head') ?>
</head>

<body>

          <header>
                    <div class="navbar navbar-expand-lg navbar-dark bg-dark box-shadow">
                              <div class="container d-flex justify-content-between">
                                        <a href="<?= route_to('root') ?>" class="navbar-brand d-flex align-items-center">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                                            <circle cx="12" cy="13" r="4"></circle>
                                                  </svg>
                                                  <strong> CI Blog</strong>
                                        </a>
                                        <ul class="navbar-nav">
                                                  <li class="nav-item">
                                                            <a class="nav-link <?= active('posts.root') ?>" aria-current="page" href="<?= route_to('posts.root') ?>">Posts</a>
                                                  </li>
                                                  <li class="nav-item">
                                                            <a class="nav-link <?= active('tags.root') ?>" href="<?= route_to('tags.root') ?>">Tags</a>
                                                  </li>
                                                  <?php if(isAdmin()): ?>
                                                            <li class="nav-item">
                                                                      <a class="nav-link <?= active('posts.create') ?>" href="<?= route_to('posts.create') ?>">New post</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                      <a class="nav-link <?= active('tags.create') ?>" href="<?= route_to('tags.create') ?>">New tag</a>
                                                            </li>
                                                  <?php endif ?>
                                                  <?php if(islogged()): ?>
                                                            <?php if(isAdmin()): ?>
                                                                      <li class="nav-item">
                                                                                <a class="btn btn-primary" href="<?= route_to('logout') ?>">Admin</a>
                                                                      </li>
                                                            <?php else: ?>
                                                                      <li class="nav-item">
                                                                                <a class="btn btn-secondary" href="<?= route_to('logout') ?>"><?= esc(user()->full_name) ?>    </a>
                                                                      </li>
                                                            <?php endif ?>
                                                  <?php else: ?>
                                                            <div class="d-flex">
                                                                      <li class="nav-item">
                                                                                <a class="btn btn-outline-secondary" href="<?= route_to('login') ?>">Login</a>
                                                                      </li>
                                                                      <li class="nav-item ml-2" style="margin-left: 5px;">
                                                                                <a class="btn btn-outline-secondary" href="<?= route_to('register') ?>">Register</a>
                                                                      </li>
                                                            </div>
                                                  <?php endif ?>
                                        </ul>
                              </div>
                    </div>
          </header>

          <?= $this->renderSection('content') ?>

          <footer class="text-muted">
                    <div class="container">
                              <p class="float-right">
                                        <a href="#">Back to top</a>
                              </p>
                              <p>Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
                              <p>New to Bootstrap? <a href="../../">Visit the homepage</a> or read our <a href="../../getting-started/">getting started guide</a>.</p>
                    </div>
          </footer>

          <!-- Bootstrap core JavaScript
    ================================================== -->
          <!-- Placed at the end of the document so the pages load faster -->
          <script src="/assets/js/jquery-3.4.1.js"></script>
          <?= $this->renderSection('footer') ?>
</body>

</html>