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
        <form class="lot-item__form" action="lot.php" method="post">
            <?php $classname = isset($errors['bet_amount']) ? "form__item--invalid" : ""; ?>
            <p class="lot-item__form-item form__item <?= $classname; ?>">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="cost" placeholder="<?= strip_tags($bet_min); ?>" value=''>
                <span class="form__error"><?= $errors['bet_amount'] ?? ''; ?></span>
            </p>
            <button type="submit" class="button">Сделать ставку</button>
        </form>
    <?php endif; ?>
</div>
