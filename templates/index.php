<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
        <?php for ($i = 0; $i < count($categories); $i++): ?>
            <li class="promo__item promo__item--boards">
                <?php if (isset($categories[$i])): ?>
                    <a class="promo__link" href="pages/all-lots.html"><?= strip_tags($categories[$i]); ?></a>
                <?php endif; ?>
            </li>
        <?php endfor; ?>
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
                    <?php if (isset($lot['url'])): ?>
                        <img src="<?= strip_tags($lot['url']); ?>" width="350" height="260" alt="">
                    <?php endif; ?>
                </div>
                <div class="lot__info">
                    <?php if (isset($lot['category'])): ?>
                        <span class="lot__category"><?= strip_tags($lot['category']); ?></span>
                    <?php endif; ?>
                    <h3 class="lot__title">
                        <?php if(isset($lot['name'])):?>
                            <a class="text-link" href="pages/lot.html"><?= strip_tags($lot['name']); ?></a>
                        <?php endif; ?>
                    </h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <?php if (isset($lot['price'])):?>
                                <span class="lot__cost"><?= strip_tags(format_price($lot['price'])); ?>
                            <?php endif; ?>
                        </div>
                        <div class="lot__timer timer">
                            12:23
                        </div>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>
