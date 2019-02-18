<?php foreach($lot as $item): ?>
    <h2>
        <?php if (isset($item['lot_name'])): ?>
            <?= strip_tags($item['lot_name']); ?>
        <?php endif; ?>
    </h2>
<?php endforeach; ?>
<div class="lot-item__content">
  <div class="lot-item__left">
    <?php foreach($lot as $item): ?>
        <div class="lot-item__image">
            <?php if (isset($item['image'])): ?>
                <img src="<?= strip_tags($item['image']); ?>" width="730" height="548" alt="Картинка">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <p class="lot-item__category">Категория:
        <?php foreach($lot as $item): ?>
            <span>
                <?php if (isset($item['category_name'])): ?>
                    <?= strip_tags($item['category_name']); ?>
                <?php endif; ?>
            </span>
        <?php endforeach; ?>
    </p>
    <?php foreach($lot as $item): ?>
        <?php if (isset($item['description'])): ?>
            <p class="lot-item__description">
                <?= $item['description']; ?>
            </p>
        <?php endif; ?>
    <?php endforeach; ?>
  </div>
</div>
