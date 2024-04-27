<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
<footer class="py-4">
    <div class="text-center">
        <small>© <?= date("Y") ?> <?= Option::get('blogname') ?> </small>
    </div>
</footer>
</div>
</div>
</div>
</main>
<?php doAction('adm_footer') ?>
<script src="./views/js/sb-admin-2.min.js?t=<?= Option::EMLOG_VERSION_TIMESTAMP ?>"></script>
</body>
</html>

