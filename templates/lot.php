<h2>
    <?php if (isset($lot['lot_name'])): ?>
        <?= strip_tags($lot['lot_name']); ?>
    <?php endif; ?>
</h2>
<div class="lot-item__content">
    <div class="lot-item__left">
        <div class="lot-item__image">
            <?php if (isset($lot['image'])): ?>
                <img src="<?= strip_tags($lot['image']); ?>" width="730" height="548" alt="Картинка">
            <?php endif; ?>
        </div>
        <p class="lot-item__category">Категория:
            <span>
                <?php if (isset($lot['category_name'])): ?>
                    <?= strip_tags($lot['category_name']); ?>
                <?php endif; ?>
            </span>
        </p>
        <?php if (isset($lot['description'])): ?>
            <p class="lot-item__description">
                <?= $lot['description']; ?>
            </p>
        <?php endif; ?>
    </div>
    <div class="lot-item__right">
        <?php if ( strip_tags($timer) > 0): ?>
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
                <?php if( (is_array($user) && $user !== []) && (strip_tags($timer) > 0) && $not_author && $none_bet ): ?>
                    <form class="lot-item__form" action="lot.php?tab=<?= $id; ?>" method="post">
                        <?php $classname = isset($errors['cost']) ? "form__item--invalid" : ""; ?>
                        <p class="lot-item__form-item form__item <?= $classname; ?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="<?= strip_tags($bet_min); ?>" value=''>
                            <span class="form__error"><?= strip_tags($errors['cost'] ?? '' ); ?></span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p class="lot-item__state">Торги завершены</p>
        <?php endif; ?>
        <?= $lot_history; ?>
    </div>
</div>
