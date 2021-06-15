<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
          <div class="container py-5 d-flex justify-content-center">
                    <form class="form w-50" method="POST">
                              <?= csrf_field() ?>
                              <h1>Register</h1>
                              <div class="form-group">
                                        <input value="<?= isset($full_name) ? esc($full_name) : '' ?>" type="text" class="form-control <?= (isset($validation) && $validation->hasError('full_name')) ? 'is-invalid' : '' ?>" placeholder="Full name" name="full_name">
                                        <?php if(isset($validation) && $validation->hasError('full_name')): ?>
                                                  <div class="invalid-feedback"><?= $validation->getError('full_name') ?></div>
                                        <?php endif ?>
                              </div>
                              <div class="form-group mt-2">
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
                              <div class="form-group mt-2">
                                        <input value="<?= isset($password_confirm) ? esc($password_confirm) : '' ?>" type="password" class="form-control <?= (isset($validation) && $validation->hasError('password_confirm')) ? 'is-invalid' : ''  ?>" placeholder="Confirm password" name="password_confirm">
                                        <?php if(isset($validation) && $validation->hasError('password_confirm')): ?>
                                                  <div class="invalid-feedback"><?= $validation->getError('password_confirm') ?></div>
                                        <?php endif ?>
                              </div>
                              <?php if(isset($errors['main'])): ?>
                                        <div class="alert alert-danger mt-2"><?= $errors['main'] ?></div>
                              <?php endif ?>
                              <div class="form-group mt-2 text-lg-end">
                                        <button class="btn btn-primary">Register</button>
                              </div>
                    </form>
          </div>
<?= $this->endSection('content') ?>