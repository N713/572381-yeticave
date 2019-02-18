<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php foreach ($categories as $category): ?>
            <li class="promo__item promo__item--boards">
                <?php if (isset($category['name'])): ?>
                    <a class="promo__link" href="pages/all-lots.html"><?= strip_tags($category['name']); ?></a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
        <?php foreach($lot_list as $lot): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <?php if (isset($lot['image'])): ?>
                        <?php if (isset($lot['lot_id'])): ?>
                            <a href="lot.php?tab=<?= strip_tags($lot['lot_id']); ?>">
                                <img src="<?= strip_tags($lot['image']); ?>" width="350" height="260" alt="">
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="lot__info">
                    <?php if (isset($lot['category_name'])): ?>
                        <span class="lot__category"><?= strip_tags($lot['category_name']); ?></span>
                    <?php endif; ?>
                    <h3 class="lot__title">
                        <?php if(isset($lot['lot_name'])):?>
                            <?php if (isset($lot['lot_id'])): ?>
                                <a class="text-link" href="lot.php?tab=<?= strip_tags($lot['lot_id']); ?>">
                                    <?= strip_tags($lot['lot_name']); ?>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <?php if (isset($lot['start_cost'])):?>
                                <span class="lot__cost"><?= strip_tags(format_price($lot['start_cost'])); ?>
                            <?php endif; ?>
                        </div>
                        <div class="lot__timer timer">
                            <?= strip_tags($lot['final_date']); ?>
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
