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
                    <?php if ( ( time() - strtotime($bet['bet_date']) ) < 86400 ): ?>
                        <?php $time = ( time() - strtotime($bet['bet_date']) ); ?>
                        <?php $hours = floor($time / 3600); ?>
                        <?php $minutes = floor(($time % 3600) / 60 ); ?>
                        <?php if ($hours > 1): ?>
                            <td class="history__time"><?= strip_tags($hours . ' часов ' . $minutes . ' минут назад'); ?></td>
                        <?php else: ?>
                            <td class="history__time"><?= strip_tags($minutes . ' минут назад'); ?></td>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php $date = date_create($bet['bet_date']); ?>
                        <?php $date = date_format($date, 'd.m.Y' . ' в ' . 'H:i:s'); ?>
                        <td class="history__time"><?= strip_tags($date); ?></td>
                    <?php endif; ?>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
