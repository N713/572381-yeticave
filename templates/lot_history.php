<div class="history">
    <h3>История ставок (<span><?php print(count($bet_list)); ?></span>)</h3>
    <table class="history__list">
        <?php foreach($bet_list as $bet): ?>
            <tr class="history__item">
                <?php if (isset($bet['user_name'])): ?>
                    <td class="history__name"><?= strip_tags($bet['user_name']); ?></td>
                <?php endif; ?>
                <?php if (isset($bet['amount_to_buy'])): ?>
                    <td class="history__price"><?= strip_tags($bet['amount_to_buy']); ?></td>
                <?php endif; ?>
                <?php if (isset($bet['bet_date'])): ?>
                    <td class="history__time"><?= strip_tags($bet['bet_date']); ?></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
