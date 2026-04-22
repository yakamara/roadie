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
        <img <?= $this->imageAttributes->toString() ?> <?= !$this->figure ? $this->attributes->toString() : '' ?> />
    <?php endif ?>
    <?php if (($this->caption && '' !== $this->caption) || ($this->copyright && '' !== $this->copyright)): ?>
        <figcaption>
            <?php if ($this->caption && '' !== $this->caption): ?>
                <?= rex_escape($this->caption) ?>
            <?php endif ?>
            <?php if ($this->copyright && '' !== $this->copyright): ?>
                <small class="copyright">
                    <span class="copyright--symbol" aria-hidden="true">&copy;</span><span class="copyright--text"><?= rex_escape($this->copyright) ?></span>
                </small>
            <?php endif ?>
        </figcaption>
    <?php endif ?>
<?php if ($this->figure): ?>
    </figure>
<?php endif ?>
