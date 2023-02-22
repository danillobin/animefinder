<ul class="foundblocks-container">
    <div class="matches">Showing matches <p class="count-showed"><? echo count($results); ?></p></div>
    <? foreach($results as $key => $value): ?>
    <li>
        <? getComponent("foundblock-li", ["value" => $value]); ?>
    </li>
    <?php endforeach; ?>
</ul>