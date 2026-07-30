<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>
</div>
</div>
</div>
</main>
<footer class="py-4 mt-auto">
    <div class="text-center text-muted">
        <small>© <?= date("Y") ?> <?= Option::get('blogname') ?> - Powered by Emlog</small>
    </div>
</footer>
<?php doAction('adm_footer') ?>
</body>

</html>