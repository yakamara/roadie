<?php

use Yakamara\Roadie\Component\Image\Image;

/** @var Image $this */
?>

<?php if ($this->figure): ?>
    <figure <?= $this->attributes->toString() ?>>
<?php endif ?>
    <?php if (count($this->sources)): ?>
        <picture <?= false === $this->figure ? $this->attributes->toString() : '' ?>>
            <?php foreach ($this->sources as $source): ?>
                <source <?= $source->toString() ?> />
            <?php endforeach ?>
            <img <?= $this->imageAttributes->toString() ?> />
        </picture>
    <?php else: ?>
        <img <?= $this->imageAttributes->toString() ?> />
    <?php endif ?>
    <?php if ($this->copyright && '' !== $this->copyright): ?>
        <footer>
            <small>&copy; <?= $this->copyright ?></small>
        </footer>
    <?php endif ?>
    <?php if ($this->caption && '' !== $this->caption): ?>
        <figcaption><?= $this->caption ?></figcaption>
    <?php endif ?>
<?php if ($this->figure): ?>
    </figure>
<?php endif ?>
