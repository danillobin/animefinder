<? getComponent("search-form", ["searchformvalue" => $title]); ?>
</header>
<main>
    <? getComponent("foundblocksContainer", ["results" => $results]); ?>
    <div class="bottom-bar">
        <button class="more-button">Show more</button>
    </div>
    <script src="assets/js/find.js"></script>
    <link rel="stylesheet" href="assets/css/find.css">
</main>