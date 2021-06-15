<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
          <div class="container py-5 d-flex justify-content-center">
                    <form class="form w-50" method="POST">
                              <?= csrf_field() ?>
                              <h1>Login</h1>
                              <div class="form-group">
                                        <input value="<?= isset($email) ? esc($email) : '' ?>" type="email" class="form-control <?= (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : '' ?>" placeholder="Email" name="email">
                                        <?php if(isset($validation) && $validation->hasError('email')): ?>
                                                  <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
                                        <?php endif ?>
                              </div>
                              <div class="form-group mt-2">
                                        <input value="<?= isset($password) ? esc($password) : '' ?>" type="password" class="form-control <?= (isset($validation) && $validation->hasError('password')) ? 'is-invalid' : ''  ?>" placeholder="password" name="password">
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