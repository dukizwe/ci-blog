<?= $this->extend('layouts/default') ?>
<?= $this->section('head') ?>
          <title>CI Blog | All Tags</title>
          <style>
          .tag-name {
                    text-decoration: none;
          }
          </style>
<?= $this->endSection('head') ?>
<?= $this->section('content') ?>
          <div class="container py-5">
                    <?php if(session()->has('success')): ?>
                              <div class="alert alert-success"><?= session()->getFlashData('success') ?></div>
                    <?php endif ?>
                    <div >
                              <h6>Click the tag to see related posts</h6>
                              <div class="class="d-flex justify-content-center"">
                                        <div class="row">
                                                  <?php foreach($tags as $tag): ?>
                                                            <div class="col-md-2">
                                                                      <div class="card mb-4 box-shadow">
                                                                                <div class="card-body">
                                                                                          <div>
                                                                                                    <a href="<?= route_to('posts.tag', postSlug($tag->name), $tag->id) ?>"  class="card-title tag-name"><?= $tag->name ?></a>
                                                                                          </div>
                                                                                          <?php if(isAdmin()): ?>
                                                                                                    <div class="btn-group mt-2">
                                                                                                              <a onclick="return confirm('Are you sure you want to delete this tag ?')" href="<?= route_to('tags.delete', $tag->id) ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                                                                                                              <a href="<?= route_to('tags.edit', $tag->id) ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                                                                                    </div>
                                                                                          <?php endif ?>
                                                                                </div>
                                                                      </div>
                                                            </div>
                                                  <?php endforeach ?>
                                        </div>
                              </div>
                    </div>
          </div>
<?= $this->endSection('content') ?>