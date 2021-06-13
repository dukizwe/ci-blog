<div class="album py-5 bg-light">
          <div class="container">
                    <?php if (session()->has('success')) : ?>
                              <div class="alert alert-success"><?= session()->getFlashData('success') ?></div>
                    <?php endif ?>
                    <div class="row">
                              <?php if (empty($posts)) : ?>
                                        <small class="text-muted">No posts yet</small>
                              <?php else : ?>
                                        <?php foreach ($posts as $post) : ?>
                                                  <div class="col-md-4">
                                                            <div class="card mb-4 box-shadow">
                                                                      <!-- <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&bg=55595c&fg=eceeef&text=Thumbnail" alt="Card image cap"> -->
                                                                      <div class="card-body">
                                                                                <?php $postUri = route_to('posts.show', postSlug($post->title), $post->id) ?>
                                                                                <a href="<?= $postUri ?>" class="to-detail">
                                                                                          <h5 class="card-title"><?= postTitle($post->title) ?></h5>
                                                                                          <p class="card-text"><?= postbody($post->body) ?></p>
                                                                                </a>
                                                                                <?php if (isset($post->tags)) : ?>
                                                                                          <div class="mb-2">
                                                                                                    <div class="btn-group d-flex flex-wrap">
                                                                                                              <?php foreach ($post->tags as $tag) : ?>
                                                                                                                        <a href="<?= route_to('posts.tag', postSlug($tag->name), $tag->id) ?>" class="btn btn-sm btn-outline-primary mt-1"><?= $tag->name ?></a>
                                                                                                              <?php endforeach ?>
                                                                                                    </div>
                                                                                          </div>
                                                                                <?php endif ?>
                                                                                <div class="d-flex justify-content-between align-items-center">
                                                                                          <div class="btn-group">
                                                                                                    <?php if (isAdmin()) : ?>
                                                                                                              <a onclick="return confirm('Are you sure you want to delete this post ?')" href="<?= route_to('posts.delete', $post->id) ?>" class="btn btn-sm btn-outline-danger">Delete</a>
                                                                                                              <a href="<?= route_to('posts.edit', $post->id) ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                                                                                    <?php endif ?>
                                                                                          </div>
                                                                                          <small class="text-muted"><?= postDate($post->created_at) ?></small>
                                                                                </div>
                                                                      </div>
                                                            </div>
                                                  </div>
                                        <?php endforeach ?>
                                        <div aria-label="Page navigation example" class="d-flex justify-content-between">
                                                  <div class="page-item">
                                                            <?php if(showPrev()): ?>
                                                                      <a class="btn btn-outline-primary" href="<?= prevPostsPage() ?>">Previous</a>
                                                            <?php endif ?>
                                                  </div>
                                                  <div class="page-item">
                                                            <?php if(showNext()): ?>
                                                                      <a class="btn btn-outline-primary" href="<?= nextPostsPage() ?>">Next</a>
                                                            <?php endif ?>
                                                  </div>
                                        </div>
                              <?php endif ?>
                    </div>
          </div>
</div>