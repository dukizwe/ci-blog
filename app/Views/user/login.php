<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
          <div class="container py-5 d-flex justify-content-center">
                    <form class="form w-50" method="POST">
                              <?= csrf_field() ?>
                              <h1>Login</h1>
                              <div class="form-group">
                                        <input value="<?= isset($username) ? $username : '' ?>" type="text" class="form-control <?= (isset($validation) && $validation->hasError('username')) ? 'is-invalid' : '' ?>" placeholder="Username" name="username">
                                        <?php if(isset($validation) && $validation->hasError('username')): ?>
                                                  <div class="invalid-feedback"><?= $validation->getError('username') ?></div>
                                        <?php endif ?>
                              </div>
                              <div class="form-group mt-2">
                                        <input value="<?= isset($password) ? $password : '' ?>" type="password" class="form-control <?= (isset($validation) && $validation->hasError('password')) ? 'is-invalid' : ''  ?>" placeholder="password" name="password">
                                        <?php if(isset($validation) && $validation->hasError('password')): ?>
                                                  <div class="invalid-feedback"><?= $validation->getError('password') ?></div>
                                        <?php endif ?>
                              </div>
                              <?php if(isset($errors['main'])): ?>
                                        <div class="alert alert-danger mt-2"><?= $errors['main'] ?></div>
                              <?php endif ?>
                              <div class="form-group mt-2 text-lg-end">
                                        <button class="btn btn-primary">Login</button>
                              </div>
                    </form>
          </div>
<?= $this->endSection('content') ?>