<div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title"><?= htmlentities($post->getTitle()) ?></h5>
          <p class="card-text"><?= substr($post->getContent(), 0, 150) . "..." ?></p>
          <p class="text-muted"><?= $post->getCreatedAt() ?></p>
          <p>
            <a href="<?= $router->generateUrl('Post', ['slug' => $post->getSlug(), 'id' => $post->getId()]) ?>" class="btn btn-primary">Lire la suite</a>
          </p>
        </div>
      </div>