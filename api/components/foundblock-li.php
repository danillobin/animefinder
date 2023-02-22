<a href="<?= $value["href"]; ?>" class="foundblock">
    <p class="foundblock-name"><?= $value["title"]; ?></p>
    <div class="info">
        <div class="site">
            <img class="site-domain-logo" src="<?= $value["domain"]."/favicon.ico"; ?>"></img>
            <div class="site-domain-name"><?= $value["domain"]; ?></div>
        </div>
        <div class="foundblock-info">
            <div class="foundblock-date"><?= $value["date"]; ?></div>
        </div>
    </div>
</a>