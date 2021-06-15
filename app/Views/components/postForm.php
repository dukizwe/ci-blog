<div class="container py-5 d-flex justify-content-center">
          <form class="form w-50" method="POST">
                    <?= csrf_field() ?>
                    <div class="form-group">
                              <input type="text"
                                        name="title"
                                        value="<?= esc($title ?? $post->title ?? '') ?>"  
                                        class="form-control <?= (isset($validation) && $validation->hasError('title')) ? 'is-invalid' : '' ?>"
                                        placeholder="Title">
                              <?php if(isset($validation) && $validation->hasError('title')): ?>
                                        <div class="invalid-feedback"><?= $validation->getError('title') ?></div>
                              <?php endif ?>
                    </div>
                    <div class="form-group mt-2">
                              <textarea name="body"
                                        placeholder="Body"
                                        class="form-control <?= (isset($validation) && $validation->hasError('body')) ? 'is-invalid' : '' ?>"><?= esc($body ?? $post->body ?? '') ?></textarea>
                              <?php if(isset($validation) && $validation->hasError('body')): ?>
                                        <div class="invalid-feedback"><?= $validation->getError('body') ?></div>
                              <?php endif ?>
                    </div>
                    <div class="form-group mt-2">
                              <select 
                              class="form-control <?= (isset($validation) && ($validation->hasError('tags.0') ||  $validation->hasError('tags.1') ||  $validation->hasError('tags.2') || $validation->hasError('tags'))) ? 'is-invalid' : '' ?>"
                              name="tags[]" id="tags" multiple>
                                        <?php foreach($tags as $tag): ?>
                                                  <option 
                                                            <?= (isset($selectedTags) && in_array($tag->id, $selectedTags)) || (isset($post->tags) && in_array($tag->id, $post->tags)) ? 'selected' : '' ?>
                                                            value="<?= $tag->id ?>"><?= $tag->name ?></option>
                                        <?php endforeach ?> 
                              </select>
                              <?php if(isset($validation) && ($validation->hasError('tags.0') ||  $validation->hasError('tags.1') ||  $validation->hasError('tags.2'))): ?>
                                        <div class="invalid-feedback">Select at least 3 tags</div>
                              <?php endif ?>
                              <?php if(isset($validation) && $validation->hasError('tags')): ?>
                                        <div class="invalid-feedback"><?= $validation->getError('tags') ?></div>
                              <?php endif ?>

                    </div>
                    <div class="form-group mt-2 text-lg-end">
                              <button class="btn btn-primary">Send</button>
                    </div>
          </form>
</div>