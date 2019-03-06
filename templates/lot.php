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
    <div class="lot-item__right">
        <div class="lot-item__state">
    <div class="lot-item__timer timer">
        <?= strip_tags($timer); ?>
    </div>
    <div class="lot-item__cost-state">
        <div class="lot-item__rate">
            <span class="lot-item__amount">Текущая цена</span>
            <span class="lot-item__cost"><?= strip_tags($current_cost); ?></span>
        </div>
        <div class="lot-item__min-cost">
            Мин. ставка <span><?= strip_tags($bet_min); ?></span>
        </div>
    </div>
        <?php if(is_array($user) and $user !== []): ?>
            <form class="lot-item__form" action="lot.php?tab=<?= $id; ?>" method="post">
                <?php $classname = isset($errors['cost']) ? "form__item--invalid" : ""; ?>
                <p class="lot-item__form-item form__item <?= $classname; ?>">
                    <label for="cost">Ваша ставка</label>
                    <input id="cost" type="text" name="cost" placeholder="<?= strip_tags($bet_min); ?>" value=''>
                    <span class="form__error"><?= $errors['cost'] ?? ''; ?></span>
                </p>
                <button type="submit" class="button">Сделать ставку</button>
            </form>
        <?php endif; ?>
    </div>
        <?= $lot_history; ?>
    </div>
</div>
