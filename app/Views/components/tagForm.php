<div class="container py-5 d-flex justify-content-center">
          <form class="form w-50" method="POST">
                    <?= csrf_field() ?>
                    <div class="form-group">
                              <input type="text"
                                        name="tag"
                                        value="<?= $tagName ?? $tag->name ?? '' ?>"
                                        class="form-control <?= (isset($validation) && $validation->hasError('tag')) ? 'is-invalid' : '' ?>"
                                        placeholder="Tag name">
                              <?php if(isset($validation) && $validation->hasError('tag')): ?>
                                        <div class="invalid-feedback"><?= $validation->getError('tag') ?></div>
                              <?php endif ?>
                    </div>
                    <div class="form-group mt-2 text-lg-end">
                              <button class="btn btn-primary">Send</button>
                    </div>
          </form>
</div>